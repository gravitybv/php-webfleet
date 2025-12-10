<?php

declare(strict_types=1);

/**
 * GpsStatus Enumeration
 *
 * @filesource   GpsStatus.php
 * @created      08.12.2025
 * @package      Webfleet\Enums
 * @license      MIT
 */

namespace Webfleet\Enums;

/**
 * GPS signal status indicator enumeration.
 */
enum GpsStatus: string
{
    case OK = 'A';
    case WARNING = 'V';
    case LAST_KNOWN = 'L';
    case INVALID = '0';

    /**
     * Get the human-readable label for the GPS status.
     */
    public function label(): string
    {
        return match($this) {
            self::OK => 'OK - Current GPS fix available',
            self::WARNING => 'Warning - GPS fix available but might be inaccurate',
            self::LAST_KNOWN => 'Last known - No current fix, using last known position',
            self::INVALID => 'Invalid - No GPS fix available',
        };
    }

    /**
     * Check if GPS has a valid current fix.
     */
    public function hasCurrentFix(): bool
    {
        return $this === self::OK || $this === self::WARNING;
    }
}
