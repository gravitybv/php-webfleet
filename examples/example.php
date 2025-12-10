<?php
/**
 *
 * @filesource   example.php
 * @created      02.08.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Webfleet\{
	WebfleetConnect, WebfleetOptions, HTTP\GuzzleClient
};

date_default_timezone_set('UTC');

(new Dotenv(__DIR__.'/../config', '.env'))->load();

$guzzleConfig = [
	'timeout' => 30,
	'verify' => __DIR__.'/../config/cacert.pem',
	'headers' => [
		'User-Agent' => 'gravitybv-php-webfleet/1.0 +https://github.com/gravitybv/php-webfleet',
	],
];

$webfleetOptions = new WebfleetOptions([
	'account'  => getenv('WEBFLEET_ACCOUNT'),
	'username' => getenv('WEBFLEET_USERNAME'),
	'password' => getenv('WEBFLEET_PASSWORD'),
	'apikey'   => getenv('WEBFLEET_APIKEY'),
	'lang'     => 'en',
]);

$webfleet = (new WebfleetConnect(new GuzzleClient($guzzleConfig), $webfleetOptions));

$wfGeocode = $webfleet->GeocodingAndRouting;

var_dump($wfGeocode->getMethods());

var_dump(
	$wfGeocode->geocodeAddress([
		'addrstreet'       => '...',
		'addrstreetnumber' => '...',
		'addrzip'          => '...',
		'addrcity'         => '...',
		'addrcountry'      => '...',
	])->json
);

