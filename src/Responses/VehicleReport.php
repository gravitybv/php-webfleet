<?php

declare(strict_types=1);

/**
 * VehicleReport Response Data Transfer Object
 *
 * @filesource   VehicleReport.php
 * @created      27.10.2025
 * @package      Webfleet\Responses
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\FuelType;
use Webfleet\Enums\EpType;
use Webfleet\Enums\FuelReference;
use Webfleet\Enums\VehicleColor;
use Webfleet\Enums\AccelerationVehicleType;

/**
 * Response structure for showVehicleReportExtern
 *
 * Contains all vehicle master data and configuration properties returned by the API.
 *
 * @property string $objectno Identifying number of an object. Unique within an account, case-sensitive. Max length: 10
 * @property string $objectname Display name of an object
 * @property string $licenseplatenumber License plate number
 * @property string $vehicletype Vehicle type (see updateVehicle for valid values)
 * @property string $width Vehicle width
 * @property string $length Vehicle length
 * @property string $height Vehicle height
 * @property string $maxweight Maximum weight
 * @property string $netweight Net weight
 * @property string $netload Net load
 * @property string $power Vehicle power
 * @property string $numaxes Number of axles
 * @property string $identnumber VIN (Vehicle Identification Number). Max length: 20. Read-only when connected to FMS/Tachograph/LINK 105/ecoPLUS
 * @property string $registrationdate Registration date
 * @property int $vh_avgfuelusage Vehicle-based fuel consumption reference value, in ml/100 km
 * @property int $ep_avgfuelusage ecoPLUS-based fuel consumption reference value, in ml/100 km
 * @property int $fl_avgfuelusage Fleet-based fuel consumption reference value, in ml/100km
 * @property int $vh_fueltype Vehicle configured fuel type (0-9, see FuelType enum)
 * @property int $ep_fueltype Fuel type determined by ecoPLUS (1-2, diesel/gasoline only)
 * @property int $fl_fueltype Fleet based fuel type (0-9, see FuelType enum)
 * @property int $enginesize Engine size in ccm
 * @property string $ep_btaddress ecoPLUS Bluetooth address (MAC-48/EUI-48). Max length: 17. Example: 00:13:6C:88:26:0B
 * @property float $speedlimit Speed limit in km/h, min: 0, max: 300
 * @property string $vehiclecolor Vehicle color (white, grey, black, red, orange, yellow, green, blue)
 * @property string $description Vehicle description. Max length: 500
 * @property string $objectuid Unique, unchangeable identifier. Max length: 30. Can be used alternatively to objectno
 * @property int $vh_rpmlimit Vehicle engine's maximum allowed RPM for RPM violation reporting (LINK 510/710 + FMS)
 * @property int $fl_rpmlimit Fleet-wide engine's maximum allowed RPM for RPM violation reporting (LINK 510/710 + FMS)
 * @property string $externalid For future use
 * @property string $obu_btaddress LINK device Bluetooth address (MAC-48/EUI-48). Max length: 17. Available for LINK 510/710/410 with firmware 3.4+
 * @property int $fueltanksize Size of the fuel tank in litres
 * @property int $ep_type Type of the OBDII dongle (1=ecoPLUS, 2=LINK 105)
 * @property int $manufacturedyear The year in which the vehicle was manufactured (optional)
 * @property int $fuelreference Fuel reference type (0=fleet, 1=individual vehicle, 2=ecoPLUS)
 * @property string $accelerationvehicletype Acceleration vehicle type (heavy_weight, medium_weight, light_weight)
 */
final class VehicleReport extends Container
{
    // Basic object identification
    public string $objectno = '';
    public string $objectname = '';
    public string $licenseplatenumber = '';
    public string $vehicletype = '';

    // Physical dimensions
    public string $width = '';
    public string $length = '';
    public string $height = '';

    // Weight information
    public string $maxweight = '';
    public string $netweight = '';
    public string $netload = '';

    // Vehicle specifications
    public string $power = '';
    public string $numaxes = '';
    public string $identnumber = '';
    public string $registrationdate = '';

    // Fuel consumption references (ml/100km)
    public int $vh_avgfuelusage = 0;
    public int $ep_avgfuelusage = 0;
    public int $fl_avgfuelusage = 0;

    // Fuel types
    public int $vh_fueltype = 0;
    public int $ep_fueltype = 0;
    public int $fl_fueltype = 0;

    // Engine information
    public int $enginesize = 0;
    public int $vh_rpmlimit = 0;
    public int $fl_rpmlimit = 0;

    // Device addresses
    public string $ep_btaddress = '';
    public string $obu_btaddress = '';

    // Vehicle configuration
    public float $speedlimit = 0.0;
    public string $vehiclecolor = '';
    public string $description = '';

    // Identifiers
    public string $objectuid = '';
    public string $externalid = '';

    // Additional specifications
    public int $fueltanksize = 0;
    public int $ep_type = 0;
    public int $manufacturedyear = 0;
    public int $fuelreference = 0;
    public string $accelerationvehicletype = '';

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
     * Get vehicle fuel type as enum.
     */
    public function getVehicleFuelType(): ?FuelType
    {
        return FuelType::tryFrom($this->vh_fueltype);
    }

    /**
     * Get ecoPLUS fuel type as enum.
     */
    public function getEcoPlusFuelType(): ?FuelType
    {
        return FuelType::tryFrom($this->ep_fueltype);
    }

    /**
     * Get fleet fuel type as enum.
     */
    public function getFleetFuelType(): ?FuelType
    {
        return FuelType::tryFrom($this->fl_fueltype);
    }

    /**
     * Get eco periphery type as enum.
     */
    public function getEpType(): ?EpType
    {
        return EpType::tryFrom($this->ep_type);
    }

    /**
     * Get fuel reference as enum.
     */
    public function getFuelReference(): ?FuelReference
    {
        return FuelReference::tryFrom($this->fuelreference);
    }

    /**
     * Get vehicle color as enum.
     */
    public function getVehicleColor(): ?VehicleColor
    {
        return VehicleColor::tryFrom($this->vehiclecolor);
    }

    /**
     * Get acceleration vehicle type as enum.
     */
    public function getAccelerationVehicleType(): ?AccelerationVehicleType
    {
        return AccelerationVehicleType::tryFrom($this->accelerationvehicletype);
    }

    /**
     * Check if vehicle has ecoPLUS device.
     */
    public function hasEcoPlus(): bool
    {
        return $this->ep_type === 1;
    }

    /**
     * Check if vehicle has LINK 105 device.
     */
    public function hasLink105(): bool
    {
        return $this->ep_type === 2;
    }

    /**
     * Check if VIN is read-only (connected to FMS/Tachograph/LINK 105/ecoPLUS).
     */
    public function isVinReadOnly(): bool
    {
        return !empty($this->identnumber) && ($this->hasEcoPlus() || $this->hasLink105());
    }

    /**
     * Get fuel consumption reference based on fuel reference type.
     *
     * @return int Fuel consumption in ml/100km
     */
    public function getActiveFuelConsumption(): int
    {
        return match($this->fuelreference) {
            0 => $this->fl_avgfuelusage, // Fleet reference
            1 => $this->vh_avgfuelusage, // Vehicle reference
            2 => $this->ep_avgfuelusage, // ecoPLUS reference
            default => 0,
        };
    }

    /**
     * Get active fuel type based on fuel reference type.
     */
    public function getActiveFuelType(): ?FuelType
    {
        return match($this->fuelreference) {
            0 => $this->getFleetFuelType(),
            1 => $this->getVehicleFuelType(),
            2 => $this->getEcoPlusFuelType(),
            default => null,
        };
    }

    /**
     * Get active RPM limit (vehicle-specific takes precedence over fleet-wide).
     */
    public function getActiveRpmLimit(): int
    {
        return $this->vh_rpmlimit > 0 ? $this->vh_rpmlimit : $this->fl_rpmlimit;
    }

    /**
     * Convert fuel consumption from ml/100km to L/100km.
     */
    public function getFuelConsumptionLiters(int $mlPer100km): float
    {
        return $mlPer100km / 1000;
    }

    /**
     * Get vehicle fuel consumption in L/100km.
     */
    public function getVehicleFuelConsumptionLiters(): float
    {
        return $this->getFuelConsumptionLiters($this->vh_avgfuelusage);
    }

    /**
     * Get ecoPLUS fuel consumption in L/100km.
     */
    public function getEcoPlusFuelConsumptionLiters(): float
    {
        return $this->getFuelConsumptionLiters($this->ep_avgfuelusage);
    }

    /**
     * Get fleet fuel consumption in L/100km.
     */
    public function getFleetFuelConsumptionLiters(): float
    {
        return $this->getFuelConsumptionLiters($this->fl_avgfuelusage);
    }
}
