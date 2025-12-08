<?php

declare(strict_types=1);

/**
 * CompassDirection Enumeration
 *
 * @filesource   CompassDirection.php
 * @created      08.12.2025
 * @package      Webfleet\Enums
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Cardinal and intercardinal compass directions enumeration.
 */
enum CompassDirection: int
{
    case NORTH = 1;
    case NORTHEAST = 2;
    case EAST = 3;
    case SOUTHEAST = 4;
    case SOUTH = 5;
    case SOUTHWEST = 6;
    case WEST = 7;
    case NORTHWEST = 8;

    /**
     * Get the human-readable label for the compass direction.
     */
    public function label(): string
    {
        return match($this) {
            self::NORTH => 'North',
            self::NORTHEAST => 'Northeast',
            self::EAST => 'East',
            self::SOUTHEAST => 'Southeast',
            self::SOUTH => 'South',
            self::SOUTHWEST => 'Southwest',
            self::WEST => 'West',
            self::NORTHWEST => 'Northwest',
        };
    }

    /**
     * Get the abbreviated direction label.
     */
    public function abbreviation(): string
    {
        return match($this) {
            self::NORTH => 'N',
            self::NORTHEAST => 'NE',
            self::EAST => 'E',
            self::SOUTHEAST => 'SE',
            self::SOUTH => 'S',
            self::SOUTHWEST => 'SW',
            self::WEST => 'W',
            self::NORTHWEST => 'NW',
        };
    }
}
