<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Event severity enumeration (response)
 * 
 * Represents the severity categories returned in event reports
 */
enum EventSeverity: string
{
    case INFORMATION = 'I';
    case WARNING = 'W';
    case ALARM = 'A';

    /**
     * Get a human-readable label for the severity
     */
    public function label(): string
    {
        return match ($this) {
            self::INFORMATION => 'Information',
            self::WARNING => 'Warning',
            self::ALARM => 'Alarm',
        };
    }

    /**
     * Check if this is an alarm severity
     */
    public function isAlarm(): bool
    {
        return $this === self::ALARM;
    }

    /**
     * Check if this requires immediate attention
     */
    public function requiresAttention(): bool
    {
        return match ($this) {
            self::ALARM,
            self::WARNING => true,
            self::INFORMATION => false,
        };
    }

    /**
     * Get severity ranking (higher = more severe)
     */
    public function severity(): int
    {
        return match ($this) {
            self::INFORMATION => 1,
            self::WARNING => 2,
            self::ALARM => 3,
        };
    }

    /**
     * Get CSS class for UI display
     */
    public function cssClass(): string
    {
        return match ($this) {
            self::INFORMATION => 'severity-info',
            self::WARNING => 'severity-warning',
            self::ALARM => 'severity-alarm',
        };
    }

    /**
     * Get icon name for UI display
     */
    public function icon(): string
    {
        return match ($this) {
            self::INFORMATION => 'info-circle',
            self::WARNING => 'exclamation-triangle',
            self::ALARM => 'bell',
        };
    }
}
