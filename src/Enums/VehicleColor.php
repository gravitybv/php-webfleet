<?php

declare(strict_types=1);

/**
 * VehicleColor Enumeration
 *
 * @filesource   VehicleColor.php
 * @created      27.10.2025
 * @package      Webfleet\Enums
 * @author       GitHub Copilot
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Vehicle color enumeration.
 *
 * Valid color values for vehicle configuration.
 */
enum VehicleColor: string
{
    case WHITE = 'white';
    case GREY = 'grey';
    case BLACK = 'black';
    case RED = 'red';
    case ORANGE = 'orange';
    case YELLOW = 'yellow';
    case GREEN = 'green';
    case BLUE = 'blue';

    /**
     * Get all vehicle color cases.
     *
     * @return array<self>
     */
    public static function all(): array
    {
        return self::cases();
    }
}
