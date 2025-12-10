<?php

declare(strict_types=1);

/**
 * WorkState Enumeration
 *
 * @filesource   WorkState.php
 * @created      08.12.2025
 * @package      Webfleet\Enums
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * Driver/co-driver work state enumeration.
 *
 * Represents the current working state of a driver or vehicle.
 */
enum WorkState: int
{
    case UNKNOWN = 0;
    case FREE_TIME = 1;
    case PAUSE = 2;
    case STANDBY = 3;
    case WORKING = 4;
    case DRIVING = 5;
    case OTHER_WORK = 6;

    /**
     * Get the human-readable label for the work state.
     */
    public function label(): string
    {
        return match($this) {
            self::UNKNOWN => 'Unknown',
            self::FREE_TIME => 'Free time',
            self::PAUSE => 'Pause',
            self::STANDBY => 'Standby',
            self::WORKING => 'Working',
            self::DRIVING => 'Driving',
            self::OTHER_WORK => 'Other work',
        };
    }

    /**
     * Check if the state indicates active work.
     */
    public function isActiveWork(): bool
    {
        return $this === self::WORKING 
            || $this === self::DRIVING 
            || $this === self::OTHER_WORK;
    }

    /**
     * Check if the state indicates rest/break.
     */
    public function isResting(): bool
    {
        return $this === self::FREE_TIME 
            || $this === self::PAUSE 
            || $this === self::STANDBY;
    }

    /**
     * Get description with device context.
     */
    public function description(): string
    {
        return match($this) {
            self::UNKNOWN => 'Unknown',
            self::FREE_TIME => 'Free time (PND only)',
            self::PAUSE => 'Pause (PND and digital tachograph)',
            self::STANDBY => 'Standby (digital tachograph only)',
            self::WORKING => 'Working (PND only)',
            self::DRIVING => 'Driving (digital tachograph only)',
            self::OTHER_WORK => 'Other work (digital tachograph only)',
        };
    }
}
