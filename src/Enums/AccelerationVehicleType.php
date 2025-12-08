<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Acceleration vehicle type enumeration
 * 
 * By default determined by vehicle type, can be overwritten via updateVehicle.
 */
enum AccelerationVehicleType: string
{
    case HEAVY_WEIGHT = 'heavy_weight';
    case MEDIUM_WEIGHT = 'medium_weight';
    case LIGHT_WEIGHT = 'light_weight';

    /**
     * Get a human-readable label for the acceleration vehicle type
     */
    public function label(): string
    {
        return match ($this) {
            self::HEAVY_WEIGHT => 'Heavy Weight',
            self::MEDIUM_WEIGHT => 'Medium Weight',
            self::LIGHT_WEIGHT => 'Light Weight',
        };
    }

    /**
     * Get typical vehicle examples for this type
     */
    public function examples(): string
    {
        return match ($this) {
            self::HEAVY_WEIGHT => 'Trucks, large vans',
            self::MEDIUM_WEIGHT => 'Medium vans, SUVs',
            self::LIGHT_WEIGHT => 'Cars, small vans',
        };
    }
}
