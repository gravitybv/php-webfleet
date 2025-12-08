<?php

declare(strict_types=1);

/**
 * TripMode Enumeration
 *
 * @filesource   TripMode.php
 * @created      08.12.2025
 * @package      Webfleet\Enums
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Trip mode/type enumeration.
 */
enum TripMode: int
{
    case UNKNOWN = 0;
    case PRIVATE = 1;
    case BUSINESS = 2;
    case COMMUTE = 3;
    case CORRECTION = 4;

    /**
     * Get the human-readable label for the trip mode.
     */
    public function label(): string
    {
        return match($this) {
            self::UNKNOWN => 'Unknown',
            self::PRIVATE => 'Private',
            self::BUSINESS => 'Business',
            self::COMMUTE => 'Commute',
            self::CORRECTION => 'Correction (manual odometer change)',
        };
    }
}
