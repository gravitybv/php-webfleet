<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Delay warning state enumeration
 * 
 * Warning state based on planned and estimated arrival time 
 * and the arrival time tolerance value
 */
enum DelayWarning: int
{
    case WITHIN_TOLERANCE = 1;
    case ABOVE_TOLERANCE = 2;

    /**
     * Get a human-readable label for the delay warning
     */
    public function label(): string
    {
        return match ($this) {
            self::WITHIN_TOLERANCE => 'Estimated Delay Within Tolerance',
            self::ABOVE_TOLERANCE => 'Estimated Delay Above Tolerance',
        };
    }

    /**
     * Check if the delay is critical (above tolerance)
     */
    public function isCritical(): bool
    {
        return $this === self::ABOVE_TOLERANCE;
    }

    /**
     * Get a severity level for the warning
     */
    public function severity(): string
    {
        return match ($this) {
            self::WITHIN_TOLERANCE => 'warning',
            self::ABOVE_TOLERANCE => 'critical',
        };
    }
}
