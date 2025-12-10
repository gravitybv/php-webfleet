<?php

declare(strict_types=1);

/**
 * FuelReference Enumeration
 *
 * @filesource   FuelReference.php
 * @created      27.10.2025
 * @package      Webfleet\Enums
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Fuel reference type enumeration.
 *
 * Indicates which type of fuel reference to refer to.
 */
enum FuelReference: int
{
    case FLEET = 0;
    case VEHICLE = 1;
    case ECO_PLUS = 2;

    /**
     * Get the human-readable label for the fuel reference type.
     */
    public function label(): string
    {
        return match($this) {
            self::FLEET => 'Fleet reference',
            self::VEHICLE => 'Individual vehicle reference',
            self::ECO_PLUS => 'ecoPLUS reference',
        };
    }

    /**
     * Get all fuel reference type cases.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        return self::cases();
    }
}
