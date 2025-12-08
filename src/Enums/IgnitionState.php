<?php

declare(strict_types=1);

/**
 * IgnitionState Enumeration
 *
 * @filesource   IgnitionState.php
 * @created      08.12.2025
 * @package      Webfleet\Enums
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Vehicle ignition state enumeration.
 */
enum IgnitionState: int
{
    case OFF = 0;
    case ON = 1;

    /**
     * Get the human-readable label for the ignition state.
     */
    public function label(): string
    {
        return match($this) {
            self::OFF => 'Off',
            self::ON => 'On',
        };
    }

    /**
     * Check if ignition is on.
     */
    public function isOn(): bool
    {
        return $this === self::ON;
    }
}
