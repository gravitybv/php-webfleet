<?php

declare(strict_types=1);

/**
 * ObjectReport Response Data Transfer Object
 *
 * @filesource   ObjectReport.php
 * @created      08.12.2025
 * @package      Webfleet\Responses
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\GpsStatus;
use Webfleet\Enums\CompassDirection;
use Webfleet\Enums\TripMode;
use Webfleet\Enums\WorkState;
use Webfleet\Enums\IgnitionState;
use DateTimeImmutable;

/**
 * Response DTO for showObjectReportExtern API call
 *
 * Contains all object master data and real-time information returned by the API.
 *
 * @property string $objectno Identifying number of an object. Unique within an account, case-sensitive. Max length: 10
 * @property string $objectname Display name of an object
 * @property string $objectclassname Object class name
 * @property string $objecttype Can be empty or contain valid vehicle types
 * @property string $description Vehicle description. Max length: 500
 * @property string $lastmsgid The ID of the last message received from or sent to this object. Range: 0 ≤ msgid ≤ 2^64-1
 * @property bool $deleted Indicates if the object is deleted
 * @property string $msgtime Time of the last message
 * @property string $longitude Geographic longitude in the form GGG° MM' SS.S" E/W in the WGS84 coordinate system
 * @property string $latitude Geographic latitude in the form GGG° MM' SS.S" N/S in the WGS84 coordinate system
 * @property string $postext Position text
 * @property string $postext_short Short position text
 * @property string $pos_time Time that is related to the last known position of the vehicle (ISO 8601 dateTime)
 * @property string $speed Current speed
 * @property int $course Compass direction in degrees (0° … 360°)
 * @property int $direction Cardinal/intercardinal compass direction (1=N, 2=NE, 3=E, 4=SE, 5=S, 6=SW, 7=W, 8=NW)
 * @property string $quality Not supported anymore (was LINK classic only)
 * @property string $satellite Not supported anymore (was LINK classic only)
 * @property string $status GPS signal status: A=ok, V=warn, L=last, 0=invalid
 * @property int $dest_latitude Destination latitude in micro degrees (10^-6 grd) WGS84
 * @property int $dest_longitude Destination longitude in micro degrees (10^-6 grd) WGS84
 * @property string $dest_text Destination text
 * @property string $dest_eta Estimated time of arrival as reported from navigation system (ISO 8601 dateTime)
 * @property mixed $dest_isorder Indicates if destination is an order
 * @property mixed $dest_addrnr Destination address number
 * @property string $orderno Account-unique order id, case sensitive. Max length: 20 bytes (UTF-8)
 * @property string $driver Account-unique driver number, case-sensitive. Max length: 20
 * @property string $drivername Display name of a driver
 * @property string $drivertelmobile Mobile phone number of the driver
 * @property string $codriver Account-unique co-driver number, case-sensitive. Max length: 20
 * @property string $codrivername Display name of a co-driver
 * @property string $codrivertelmobile Mobile phone number of the co-driver
 * @property int $driver_currentworkstate Driver work state: 0=Unknown, 1=Free time, 2=Pause, 3=Standby, 4=Working, 5=Driving, 6=Other work
 * @property int $codriver_currentworkstate Co-driver work state: 0=Unknown, 1=Free time, 2=Pause, 3=Standby, 4=Working, 5=Driving, 6=Other work
 * @property string $rll_btaddress Remote LINK Bluetooth address (MAC-48/EUI-48). Max length: 17. Example: 00:13:6C:88:26:0B
 * @property string $odometer Current odometer value in 100 meter
 * @property int $ignition Current state of ignition: 0=off, 1=on
 * @property string $ignition_time Time the last ignition state was reported
 * @property string $dest_distance Distance to current navigation destination in meters
 * @property int $tripmode Trip type: 0=Unknown, 1=Private, 2=Business, 3=Commute, 4=Correction
 * @property int $standstill Vehicle standing still: 0=moving, 1=standing still
 * @property int $pndconn Navigation device connected: 0=not connected, 1=connected
 * @property int $latitude_mdeg Geographic latitude in micro degrees (10^-6 grd) WGS84
 * @property int $longitude_mdeg Geographic longitude in micro degrees (10^-6 grd) WGS84
 * @property string $objectuid Unique, unchangeable identifier. Max length: 30. Can be used alternatively to objectno
 * @property int $fuellevel Current fuel level in per mill (only for LINK 510/710 with FMS)
 * @property string $externalid For future use
 * @property string $driveruid Unique, unchangeable identifier for driver. Can be used alternatively to driverno
 * @property string $codriveruid Unique, unchangeable identifier for co-driver. Can be used alternatively to codriver
 * @property string $driverkey_deviceaddress JSON encoded array of driver key device addresses. Example: ['00:21:3E:B3:8D:EA']
 * @property string $fuellevel_milliliters Current fuel level in milliliters (only for LINK 204)
 * @property int $engine_operation_time Accumulated engine operation time in seconds (LINK 7x0 or FMS connected)
 * @property int $odometer_long Current odometer value in meters
 */
final class ObjectReport extends Container
{
    // Basic object information
    public string $objectno = '';
    public string $objectname = '';
    public string $objectclassname = '';
    public string $objecttype = '';
    public string $description = '';
    public string $lastmsgid = '';
    public bool $deleted = false;
    public string $msgtime = '';

    // Position information (DMS format)
    public string $longitude = '';
    public string $latitude = '';
    public string $postext = '';
    public string $postext_short = '';
    public string $pos_time = '';

    // Movement information
    public string $speed = '';
    public int $course = 0;
    public int $direction = 0;

    // Legacy fields (not supported)
    public string $quality = '';
    public string $satellite = '';

    // GPS status
    public string $status = '';

    // Destination information
    public int $dest_latitude = 0;
    public int $dest_longitude = 0;
    public string $dest_text = '';
    public string $dest_eta = '';
    public mixed $dest_isorder = null;
    public mixed $dest_addrnr = null;

    // Order information
    public string $orderno = '';

    // Driver information
    public string $driver = '';
    public string $drivername = '';
    public string $drivertelmobile = '';
    public string $codriver = '';
    public string $codrivername = '';
    public string $codrivertelmobile = '';
    public int $driver_currentworkstate = 0;
    public int $codriver_currentworkstate = 0;

    // Device information
    public string $rll_btaddress = '';

    // Vehicle telemetry
    public string $odometer = '';
    public int $ignition = 0;
    public string $ignition_time = '';
    public string $dest_distance = '';
    public int $tripmode = 0;
    public int $standstill = 0;
    public int $pndconn = 0;

    // Position (micro degrees format)
    public int $latitude_mdeg = 0;
    public int $longitude_mdeg = 0;

    // Unique identifiers
    public string $objectuid = '';
    public string $driveruid = '';
    public string $codriveruid = '';

    // Fuel information
    public int $fuellevel = 0;
    public string $fuellevel_milliliters = '';

    // Additional information
    public string $externalid = '';
    public string $driverkey_deviceaddress = '';
    public int $engine_operation_time = 0;
    public int $odometer_long = 0;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Magic getter
     */
    public function __get(string $property): mixed
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    /**
     * Get the GPS status as a human-readable string.
     */
    public function getGpsStatusLabel(): string
    {
        return match($this->status) {
            'A' => 'OK - Current GPS fix available',
            'V' => 'Warning - GPS fix available but might be inaccurate',
            'L' => 'Last known - No current fix, using last known position',
            '0' => 'Invalid - No GPS fix available',
            default => 'Unknown',
        };
    }

    /**
     * Get the ignition status as a human-readable string.
     */
    public function getIgnitionStatusLabel(): string
    {
        return match($this->ignition) {
            0 => 'Off',
            1 => 'On',
            default => 'Unknown',
        };
    }

    /**
     * Get the trip mode as a human-readable string.
     */
    public function getTripModeLabel(): string
    {
        return match($this->tripmode) {
            0 => 'Unknown',
            1 => 'Private',
            2 => 'Business',
            3 => 'Commute',
            4 => 'Correction (manual odometer change)',
            default => 'Unknown',
        };
    }

    /**
     * Get the driver work state as a human-readable string.
     */
    public function getDriverWorkStateLabel(): string
    {
        return $this->getWorkStateLabel($this->driver_currentworkstate);
    }

    /**
     * Get the co-driver work state as a human-readable string.
     */
    public function getCoDriverWorkStateLabel(): string
    {
        return $this->getWorkStateLabel($this->codriver_currentworkstate);
    }

    /**
     * Get work state label by value.
     */
    private function getWorkStateLabel(int $state): string
    {
        return match($state) {
            0 => 'Unknown',
            1 => 'Free time',
            2 => 'Pause',
            3 => 'Standby',
            4 => 'Working',
            5 => 'Driving',
            6 => 'Other work',
            default => 'Unknown',
        };
    }

    /**
     * Get compass direction as a human-readable string.
     */
    public function getDirectionLabel(): string
    {
        return match($this->direction) {
            1 => 'North',
            2 => 'Northeast',
            3 => 'East',
            4 => 'Southeast',
            5 => 'South',
            6 => 'Southwest',
            7 => 'West',
            8 => 'Northwest',
            default => 'Unknown',
        };
    }

    /**
     * Check if the vehicle is currently standing still.
     */
    public function isStandingStill(): bool
    {
        return $this->standstill === 1;
    }

    /**
     * Check if a navigation device is connected.
     */
    public function hasNavigationDevice(): bool
    {
        return $this->pndconn === 1;
    }

    /**
     * Check if the ignition is on.
     */
    public function isIgnitionOn(): bool
    {
        return $this->ignition === 1;
    }

    /**
     * Get odometer in kilometers.
     */
    public function getOdometerKm(): float
    {
        if ($this->odometer_long > 0) {
            return $this->odometer_long / 1000;
        }
        return (float)$this->odometer / 10;
    }

    /**
     * Parse driver key device addresses from JSON string.
     *
     * @return array<string>
     */
    public function getDriverKeyDeviceAddresses(): array
    {
        if (empty($this->driverkey_deviceaddress)) {
            return [];
        }

        $decoded = json_decode($this->driverkey_deviceaddress, true);
        return is_array($decoded) ? $decoded : [];
    }
}
