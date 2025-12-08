<?php

declare(strict_types=1);
/**
 * Interface Objects
 *
 * @filesource   Objects.php
 * @created      14.03.2017
 * @package      Webfleet\Endpoints
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace Webfleet\Endpoints;

use Webfleet\WebfleetResponse;

/**
 * 4.2 Objects
 *
 * @method array getMethods():array
 */
interface Objects
{
    /**
     * 4.2.1 showObjectReportExtern
     *
     * Delivers a list of all objects. Provides access to object master data
     * and the most recent position information available for each object.
     *
     * Use Message queues instead of showObjectReportExtern, if you need all tracking data for the objects in your
     * account.
     *
     * Object types - An object in WEBFLEET always has a certain type (vehicle, person, asset, etc.). Every
     * type defines special properties. These properties are listed by special actions (showVehicleReportExtern etc.),
     * whereas this action lists all objects with type independent properties like number, name and description.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showObjectReportExtern(
        array $params = [],
    ): WebfleetResponse;

    const showObjectReportExtern = [
        "required" => [],
        "optional" => [
            "filterstring",
            "objectgroupname",
            "ungroupedonly",
            "objectno",
            "objectuid",
            "externalid",
        ],
        "limits" => [6, 60],
    ];

    /**
     * 4.2.2 showVehicleReportExtern
     *
     * Lists all objects of type "Vehicle" with comprehensive vehicle master data.
     *
     * Response fields (see \Webfleet\Responses\VehicleReport):
     * - objectno (string max:10): Identifying number of an object. Unique within account, case-sensitive
     * - objectname (string): Display name of an object
     * - licenseplatenumber (string): License plate number
     * - vehicletype (string): Vehicle type (see updateVehicle for valid values)
     * - width (string): Vehicle width
     * - length (string): Vehicle length
     * - height (string): Vehicle height
     * - maxweight (string): Maximum weight
     * - netweight (string): Net weight
     * - netload (string): Net load
     * - power (string): Vehicle power
     * - numaxes (string): Number of axles
     * - identnumber (string max:20): VIN (Vehicle Identification Number). Read-only when connected to FMS/Tachograph/LINK 105/ecoPLUS
     * - registrationdate (string): Registration date
     * - vh_avgfuelusage (int): Vehicle-based fuel consumption reference value, in ml/100 km
     * - ep_avgfuelusage (int): ecoPLUS-based fuel consumption reference value, in ml/100 km
     * - fl_avgfuelusage (int): Fleet-based fuel consumption reference value, in ml/100km
     * - vh_fueltype (int 0-9): Vehicle configured fuel type (see \Webfleet\Enums\FuelType)
     * - ep_fueltype (int 1-2): Fuel type determined by ecoPLUS (1=diesel, 2=gasoline)
     * - fl_fueltype (int 0-9): Fleet based fuel type (see \Webfleet\Enums\FuelType)
     * - enginesize (int): Engine size in ccm
     * - ep_btaddress (string max:17): ecoPLUS Bluetooth MAC-48/EUI-48 address (e.g., 00:13:6C:88:26:0B)
     * - speedlimit (float 0-300): Speed limit in km/h
     * - vehiclecolor (string): Vehicle color (see \Webfleet\Enums\VehicleColor)
     * - description (string max:500): Vehicle description
     * - objectuid (string max:30): Unique, unchangeable identifier. Can be used alternatively to objectno
     * - vh_rpmlimit (int): Vehicle engine's maximum allowed RPM (LINK 510/710 connected to FMS)
     * - fl_rpmlimit (int): Fleet-wide engine's maximum allowed RPM (LINK 510/710 connected to FMS)
     * - externalid (string): For future use
     * - obu_btaddress (string max:17): LINK device Bluetooth address (LINK 510/710/410 firmware 3.4+)
     * - fueltanksize (int): Size of the fuel tank in litres
     * - ep_type (int): Type of OBDII dongle (1=ecoPLUS, 2=LINK 105, see \Webfleet\Enums\EpType)
     * - manufacturedyear (int): Year in which the vehicle was manufactured
     * - fuelreference (int 0-2): Fuel reference type (0=fleet, 1=vehicle, 2=ecoPLUS, see \Webfleet\Enums\FuelReference)
     * - accelerationvehicletype (string): Acceleration vehicle type for calibration (heavy_weight, medium_weight, light_weight, see \Webfleet\Enums\AccelerationVehicleType)
     *
     * @param array $params Optional filter parameters
     *
     * @return \Webfleet\WebfleetResponse
     * @see \Webfleet\Responses\VehicleReport
     * @see \Webfleet\Enums\FuelType
     * @see \Webfleet\Enums\VehicleColor
     * @see \Webfleet\Enums\EpType
     * @see \Webfleet\Enums\FuelReference
     * @see \Webfleet\Enums\AccelerationVehicleType
     */
    public function showVehicleReportExtern(
        array $params = [],
    ): WebfleetResponse;

    const showVehicleReportExtern = [
        "required" => [],
        "optional" => [
            "filterstring",
            "objectgroupname",
            "objectno",
            "objectuid",
            "externalid",
            "ep_type",
            "manufacturedyear",
            "fuelreference",
        ],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.3 showNearestVehicles
     *
     * Retrieves a list of vehicles that are within a defined radius n around the indicated location.
     * This action delivers details on the routed distance and the routed time for the 8 nearest vehicles.
     *
     * The list is sorted by:
     *
     * 1. Object state.
     * 2. Linear distance to the location.
     * 3. Object number.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showNearestVehicles(array $params): WebfleetResponse;

    const showNearestVehicles = [
        "required" => ["latitude", "longitude"],
        "optional" => ["objectgroupname", "addrno", "priority", "maxdistance"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.4 showContracts
     *
     * This action shows contract and device data for selected devices.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showContracts(array $params = []): WebfleetResponse;

    const showContracts = [
        "required" => [],
        "optional" => ["objectno", "objectuid"],
        "limits" => [6, 60],
    ];

    /**
     * 4.2.5 updateVehicle
     *
     * This action allows the update of vehicle details.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function updateVehicle(array $params): WebfleetResponse;

    const updateVehicle = [
        "required" => ["objectuid"],
        "optional" => [
            "objectno",
            "vehicletype",
            "vehiclecolor",
            "identnumber",
            "registrationdate",
            "denotation",
            "licenseplatenumber",
            "speedlimit",
            "fuelconsumption",
            "fueltype",
            "netweight",
            "maxweight",
            "netload",
            "maxload",
            "numaxles",
            "length",
            "width",
            "height",
            "description",
            "power",
            "enginesize",
            "reset_fuelavg",
            "odometer",
            "rpmlimit",
            "ep_btaddress",
            "rll_btaddress",
            "externalid",
            "fueltanksize",
            "ep_type",
            "manufacturedyear",
            "fuelreference",
        ],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.6 showObjectGroups
     *
     * This actions retrieves a list of all object groups.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showObjectGroups(array $params = []): WebfleetResponse;

    const showObjectGroups = [
        "required" => [],
        "optional" => ["objectgroupname", "objectgroupuid"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.7 showObjectGroupObjects
     *
     * Lists the assignments of objects to object groups. Each object can be in no, one or more than one group.
     * Using both parameters objectgroupname and onbjectno only according matches are returned.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showObjectGroupObjects(
        array $params = [],
    ): WebfleetResponse;

    const showObjectGroupObjects = [
        "required" => [],
        "optional" => ["objectno", "objectgroupname", "objectuid"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.8 attachObjectToGroup
     *
     * This action assigns an object to a specific object group.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function attachObjectToGroup(array $params): WebfleetResponse;

    const attachObjectToGroup = [
        "required" => ["objectuid", "objectgroupname"],
        "optional" => ["objectno"],
        "limits" => [1000, 3600],
    ];

    /**
     * 4.2.9 detachObjectFromGroup
     *
     * This action detached an object from a specific object group.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function detachObjectFromGroup(array $params): WebfleetResponse;

    const detachObjectFromGroup = [
        "required" => ["objectuid", "objectgroupname"],
        "optional" => ["objectno"],
        "limits" => [1000, 3600],
    ];

    /**
     * 4.2.10 insertObjectGroup
     *
     * This action creates an object group. The group name must not start with “sys$”.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function insertObjectGroup(array $params): WebfleetResponse;

    const insertObjectGroup = [
        "required" => ["objectgroupname"],
        "optional" => [],
        "limits" => [100, 1800],
    ];

    /**
     * 4.2.11 deleteObjectGroup
     *
     * This action deletes an object group and the assignments of all objects assigned to that group.
     * The objects detached through this action are not being deleted.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function deleteObjectGroup(array $params): WebfleetResponse;

    const deleteObjectGroup = [
        "required" => ["objectgroupname"],
        "optional" => [],
        "limits" => [100, 1800],
    ];

    /**
     * 4.2.12 updateObjectGroup
     *
     * This action allows to update the name of the object group while retaining the assignment
     * of objects to that group. The group name must not start with “sys$”.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function updateObjectGroup(array $params): WebfleetResponse;

    const updateObjectGroup = [
        "required" => ["objectgroupname", "objectgroupname_old"],
        "optional" => [],
        "limits" => [100, 1800],
    ];

    /**
     * 4.2.13 switchOutput
     *
     * Using switchOutput you can control the digital output of the LINK classic and the
     * LINK 510 to be on or off (1 or 0). You first need to enable the digital output of the LINK classic/LINK
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function switchOutput(array $params): WebfleetResponse;

    const switchOutput = [
        "required" => ["objectuid", "status"],
        "optional" => ["objectno"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.14 showWakeupTimers
     *
     * This action returns a list of days and times that are configured on the TomTom LINK 5xx/4xx/3xx to wake up the
     * device.
     *
     * The TomTom LINK device can be set to wake up at several times per day.
     * The times defined apply to all the days that are enabled for wake-up.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function showWakeupTimers(array $params = []): WebfleetResponse;

    const showWakeupTimers = [
        "required" => ["objectuid"],
        "optional" => ["objectno"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.15 updateWakeupTimers
     *
     *Using updateWakeupTimers you can set and change the days and times the specified LINK 5xx/4xx/3xx device shall automatically wake up.
     *
     * The TomTom LINK device can be set to wake up at several times per day.
     * The times defined apply to all the days that are enabled for wake-up.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function updateWakeupTimers(array $params): WebfleetResponse;

    const updateWakeupTimers = [
        "required" => ["objectuid"],
        "optional" => [
            "objectno",
            "mon",
            "tue",
            "wed",
            "thu",
            "fri",
            "sat",
            "sun",
            "time1",
            "time2",
            "time3",
            "time4",
            "time5",
        ],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.16 getObjectFeatures
     *
     * getObjectFeatures returns all features (additional services) that are booked for the object.
     * If you specify a feature, getObjectFeatures returns all objects that have the indicated feature booked.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function getObjectFeatures(array $params = []): WebfleetResponse;

    const getObjectFeatures = [
        "required" => ["objectuid"],
        "optional" => ["objectno", "externalid", "feature"],
        "limits" => [10, 60],
    ];

    /**
     * 4.2.17 updateContractInfo
     *
     * Using updateContractInfo you can update data that refer to the contract.
     *
     * @param array $params
     *
     * @return \Webfleet\WebfleetResponse
     */
    public function updateContractInfo(array $params): WebfleetResponse;

    const updateContractInfo = [
        "required" => ["objectuid", "referenceno"],
        "optional" => ["objectno"],
        "limits" => [10, 60],
    ];
}
