<?php

declare(strict_types=1);

/**
 * FuelType Enumeration
 *
 * @filesource   FuelType.php
 * @created      27.10.2025
 * @package      Webfleet\Enums
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Fuel type enumeration for vehicle and fleet configurations.
 *
 * Valid values for vh_fueltype and fl_fueltype (0-9).
 * Valid values for ep_fueltype (1-2, diesel/gasoline only).
 */
enum FuelType: int
{
    case UNKNOWN = 0;
    case DIESEL = 1;
    case GASOLINE = 2;
    case LPG = 3;
    case HYBRID_PETROL = 4;
    case HYBRID_DIESEL = 5;
    case ELECTRIC = 6;
    case CNG = 7;
    case LNG = 8;
    case HYDROGEN = 9;

    /**
     * Get the human-readable label for the fuel type.
     */
    public function label(): string
    {
        return match($this) {
            self::UNKNOWN => 'Unknown',
            self::DIESEL => 'Diesel',
            self::GASOLINE => 'Gasoline',
            self::LPG => 'LPG',
            self::HYBRID_PETROL => 'Hybrid Petrol',
            self::HYBRID_DIESEL => 'Hybrid Diesel',
            self::ELECTRIC => 'Electric',
            self::CNG => 'CNG',
            self::LNG => 'LNG',
            self::HYDROGEN => 'Hydrogen',
        };
    }

    /**
     * Check if this fuel type is valid for ecoPLUS (diesel and gasoline only).
     */
    public function isValidForEcoPlus(): bool
    {
        return $this === self::DIESEL || $this === self::GASOLINE;
    }

    /**
     * Get all fuel type cases.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        return self::cases();
    }

    /**
     * Get ecoPLUS supported fuel types (diesel and gasoline only).
     *
     * @return array<self>
     */
    public static function ecoPlusTypes(): array
    {
        return [self::DIESEL, self::GASOLINE];
    }
}
