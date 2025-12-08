<?php
/**
 * Example usage of showEventReportExtern endpoint
 *
 * @filesource   showEventReportExtern.php
 * @created      14.11.2025
 * @author       Erik de Groot
 * @license      MIT
 */

require_once __DIR__.'/../vendor/autoload.php';

use chillerlan\TinyCurl\RequestOptions;
use Dotenv\Dotenv;

use Webfleet\{
	WebfleetConnect, WebfleetOptions, HTTP\TinyCurlClient
};

date_default_timezone_set('UTC');

(new Dotenv(__DIR__.'/../config', '.env'))->load();

$requestOptions = new RequestOptions([
	'ca_info'    => __DIR__.'/../config/cacert.pem',
	'user_agent' => 'chillerlan-php-webfleet/0.1 +https://github.com/codemasher/php-webfleet',
]);

$webfleetOptions = new WebfleetOptions([
	'account'  => getenv('WEBFLEET_ACCOUNT'),
	'username' => getenv('WEBFLEET_USERNAME'),
	'password' => getenv('WEBFLEET_PASSWORD'),
	'apikey'   => getenv('WEBFLEET_APIKEY'),
	'lang'     => 'en',
]);

$webfleet = new WebfleetConnect(new TinyCurlClient($requestOptions), $webfleetOptions);

// Access the Events endpoint
$events = $webfleet->Events;

// Example 1: Get all events for today (using range pattern)
echo "Example 1: All events for today\n";
echo "=================================\n";
$response = $events->showEventReportExtern([], [
	'range_pattern' => 'd0' // today
]);
print_r($response->json);
echo "\n\n";

// Example 2: Get unresolved alarm events for a specific object
echo "Example 2: Unresolved alarms for specific object\n";
echo "==================================================\n";
$response = $events->showEventReportExtern([
	'objectno'        => 'VEHICLE001',
	'eventlevel_cur'  => 3, // Alarm 1
	'resolved'        => false,
], [
	'range_pattern' => 'd0'
]);
print_r($response->json);
echo "\n\n";

// Example 3: Get all unacknowledged warnings for the last week
echo "Example 3: Unacknowledged warnings for last week\n";
echo "=================================================\n";
$response = $events->showEventReportExtern([
	'eventlevel_cur'  => 2, // Warning
	'acknowledged'    => false,
], [
	'range_pattern' => 'w-1' // last week
]);
print_r($response->json);
echo "\n\n";

// Example 4: Get events using custom date range
echo "Example 4: Events for specific date range\n";
echo "==========================================\n";
$response = $events->showEventReportExtern([
	'objectno' => 'VEHICLE001',
], [
	'rangefrom_string' => '2025-11-01T00:00:00Z',
	'rangeto_string'   => '2025-11-14T23:59:59Z',
]);
print_r($response->json);
echo "\n\n";

// Example 5: Get all resolved events for a specific month
echo "Example 5: Resolved events for specific month\n";
echo "==============================================\n";
$response = $events->showEventReportExtern([
	'resolved' => true,
], [
	'year'  => 2025,
	'month' => 11,
]);
print_r($response->json);
echo "\n\n";

// Example 6: Using objectuid instead of objectno
echo "Example 6: Events by objectuid\n";
echo "===============================\n";
$response = $events->showEventReportExtern([
	'objectuid' => 'ABC123DEF456',
], [
	'range_pattern' => 'm0' // current month
]);
print_r($response->json);
echo "\n\n";

// Example 7: Get all alarm level events (any alarm)
echo "Example 7: All alarm events\n";
echo "============================\n";
$response = $events->showEventReportExtern([
	'eventlevel_cur' => 3, // Can use 3, 4, or 5 for different alarm levels
], [
	'range_pattern' => 'w0' // current week
]);
print_r($response->json);
echo "\n\n";

/**
 * Event level values:
 * 0 - Message
 * 1 - Notice/Information
 * 2 - Warning
 * 3 - Alarm 1
 * 4 - Alarm 2
 * 5 - Alarm 3
 *
 * Range pattern values:
 * d0    - today
 * d-1   - yesterday
 * d-2   - 2 days ago
 * w0    - current week
 * w-1   - last week
 * wf0   - current work week
 * m0    - current month
 * m-1   - last month
 *
 * Response includes:
 * - eventid: Unique event identifier
 * - msgtime: Message time
 * - eventtime: Event time
 * - objectno: Object number
 * - msgtext: Message text
 * - postext: Position text
 * - latitude/longitude: Geographic coordinates (degrees)
 * - latitude_mdeg/longitude_mdeg: Geographic coordinates (micro degrees)
 * - restime: Resolution time (if resolved)
 * - acktime: Acknowledgment time (if acknowledged)
 * - eventlevel: Original event level (I/W/A)
 * - eventlevel_cur: Current event level (I/W/A)
 * - alarmlevel: Alarm level
 * - resuser: User who resolved the event
 * - ackuser: User who acknowledged the event
 * - objectuid: Unique object identifier
 * - pos_time: Position time when event occurred
 */
