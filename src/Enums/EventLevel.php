<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Event level enumeration (parameter)
 * 
 * Represents the severity levels for filtering events
 */
enum EventLevel: int
{
    case MESSAGE = 0;
    case NOTICE = 1;
    case WARNING = 2;
    case ALARM_1 = 3;
    case ALARM_2 = 4;
    case ALARM_3 = 5;

    /**
     * Get a human-readable label for the event level
     */
    public function label(): string
    {
        return match ($this) {
            self::MESSAGE => 'Message',
            self::NOTICE => 'Notice/Information',
            self::WARNING => 'Warning',
            self::ALARM_1 => 'Alarm 1',
            self::ALARM_2 => 'Alarm 2',
            self::ALARM_3 => 'Alarm 3',
        };
    }

    /**
     * Check if this is an alarm level
     */
    public function isAlarm(): bool
    {
        return match ($this) {
            self::ALARM_1,
            self::ALARM_2,
            self::ALARM_3 => true,
            default => false,
        };
    }

    /**
     * Get severity ranking (higher = more severe)
     */
    public function severity(): int
    {
        return $this->value;
    }

    /**
     * Get CSS class for UI display
     */
    public function cssClass(): string
    {
        return match ($this) {
            self::MESSAGE => 'event-message',
            self::NOTICE => 'event-info',
            self::WARNING => 'event-warning',
            self::ALARM_1 => 'event-alarm-1',
            self::ALARM_2 => 'event-alarm-2',
            self::ALARM_3 => 'event-alarm-3',
        };
    }
}
