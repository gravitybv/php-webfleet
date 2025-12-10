<?php

declare(strict_types=1);

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\EventSeverity;
use DateTimeImmutable;

/**
 * Response DTO for showEventReportExtern API call
 * 
 * Contains event notification information including severity levels,
 * acknowledgment status, location, and user tracking.
 */
final class EventReport extends Container
{
    // Event Identification
    public string $eventid = '';
    
    // Timestamps
    public string|null $msgtime = null;
    public string|null $eventtime = null;
    public string|null $pos_time = null;
    public string|null $restime = null;
    public string|null $acktime = null;
    
    // Object Information
    public string $objectno = '';
    public string $objectuid = '';
    
    // Event Content
    public string $msgtext = '';
    public string $postext = '';
    
    // Location (Formatted)
    public string $latitude = '';
    public string $longitude = '';
    
    // Location (Micro Degrees)
    public string|null $latitude_mdeg = null;
    public string|null $longitude_mdeg = null;
    
    // Event Severity Levels
    public string $eventlevel = '';        // Original level
    public string $eventlevel_cur = '';    // Current level
    public string $alarmlevel = '';
    
    // User Tracking
    public string $resuser = '';
    public string $ackuser = '';

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    /**
     * Get the original event level as enum
     */
    public function getEventLevel(): ?EventSeverity
    {
        if ($this->eventlevel === '') {
            return null;
        }

        return EventSeverity::tryFrom($this->eventlevel);
    }

    /**
     * Get the current event level as enum
     */
    public function getCurrentEventLevel(): ?EventSeverity
    {
        if ($this->eventlevel_cur === '') {
            return null;
        }

        return EventSeverity::tryFrom($this->eventlevel_cur);
    }

    /**
     * Get the alarm level as enum
     */
    public function getAlarmLevel(): ?EventSeverity
    {
        if ($this->alarmlevel === '') {
            return null;
        }

        return EventSeverity::tryFrom($this->alarmlevel);
    }

    /**
     * Get the original event level label
     */
    public function getEventLevelLabel(): string
    {
        return $this->getEventLevel()?->label() ?? 'Unknown';
    }

    /**
     * Get the current event level label
     */
    public function getCurrentEventLevelLabel(): string
    {
        return $this->getCurrentEventLevel()?->label() ?? 'Unknown';
    }

    /**
     * Check if the event severity has changed
     */
    public function hasSeverityChanged(): bool
    {
        return $this->eventlevel !== '' && 
               $this->eventlevel_cur !== '' && 
               $this->eventlevel !== $this->eventlevel_cur;
    }

    /**
     * Check if the event was downgraded (severity decreased)
     */
    public function wasDowngraded(): bool
    {
        if (!$this->hasSeverityChanged()) {
            return false;
        }

        $original = $this->getEventLevel();
        $current = $this->getCurrentEventLevel();

        if ($original === null || $current === null) {
            return false;
        }

        return $current->severity() < $original->severity();
    }

    /**
     * Check if the event was escalated (severity increased)
     */
    public function wasEscalated(): bool
    {
        if (!$this->hasSeverityChanged()) {
            return false;
        }

        $original = $this->getEventLevel();
        $current = $this->getCurrentEventLevel();

        if ($original === null || $current === null) {
            return false;
        }

        return $current->severity() > $original->severity();
    }

    /**
     * Check if the event is currently at alarm level
     */
    public function isAlarm(): bool
    {
        return $this->getCurrentEventLevel()?->isAlarm() ?? false;
    }

    /**
     * Check if the event requires attention
     */
    public function requiresAttention(): bool
    {
        return $this->getCurrentEventLevel()?->requiresAttention() ?? false;
    }

    /**
     * Check if the event has been resolved
     */
    public function isResolved(): bool
    {
        return $this->restime !== null && $this->restime !== '';
    }

    /**
     * Check if the event has been acknowledged
     */
    public function isAcknowledged(): bool
    {
        return $this->acktime !== null && $this->acktime !== '';
    }

    /**
     * Check if the event is pending (not resolved and not acknowledged)
     */
    public function isPending(): bool
    {
        return !$this->isResolved() && !$this->isAcknowledged();
    }

    /**
     * Get message time as DateTimeImmutable
     */
    public function getMessageTime(): ?DateTimeImmutable
    {
        if ($this->msgtime === null || $this->msgtime === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->msgtime);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get event time as DateTimeImmutable
     */
    public function getEventTime(): ?DateTimeImmutable
    {
        if ($this->eventtime === null || $this->eventtime === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->eventtime);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get position time as DateTimeImmutable
     */
    public function getPositionTime(): ?DateTimeImmutable
    {
        if ($this->pos_time === null || $this->pos_time === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->pos_time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get resolve time as DateTimeImmutable
     */
    public function getResolveTime(): ?DateTimeImmutable
    {
        if ($this->restime === null || $this->restime === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->restime);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get acknowledge time as DateTimeImmutable
     */
    public function getAcknowledgeTime(): ?DateTimeImmutable
    {
        if ($this->acktime === null || $this->acktime === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->acktime);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get time elapsed since event occurred (in seconds)
     */
    public function getTimeSinceEvent(): ?int
    {
        $eventTime = $this->getEventTime();
        if ($eventTime === null) {
            return null;
        }

        $now = new DateTimeImmutable();
        return $now->getTimestamp() - $eventTime->getTimestamp();
    }

    /**
     * Get time taken to resolve (in seconds)
     */
    public function getTimeToResolve(): ?int
    {
        $eventTime = $this->getEventTime();
        $resolveTime = $this->getResolveTime();

        if ($eventTime === null || $resolveTime === null) {
            return null;
        }

        return $resolveTime->getTimestamp() - $eventTime->getTimestamp();
    }

    /**
     * Get time taken to acknowledge (in seconds)
     */
    public function getTimeToAcknowledge(): ?int
    {
        $eventTime = $this->getEventTime();
        $ackTime = $this->getAcknowledgeTime();

        if ($eventTime === null || $ackTime === null) {
            return null;
        }

        return $ackTime->getTimestamp() - $eventTime->getTimestamp();
    }

    /**
     * Get latitude in degrees (from micro degrees)
     */
    public function getLatitudeDegrees(): ?float
    {
        if ($this->latitude_mdeg === null || $this->latitude_mdeg === '') {
            return null;
        }

        return (float)$this->latitude_mdeg / 1_000_000;
    }

    /**
     * Get longitude in degrees (from micro degrees)
     */
    public function getLongitudeDegrees(): ?float
    {
        if ($this->longitude_mdeg === null || $this->longitude_mdeg === '') {
            return null;
        }

        return (float)$this->longitude_mdeg / 1_000_000;
    }

    /**
     * Check if event has coordinates
     */
    public function hasCoordinates(): bool
    {
        return $this->latitude_mdeg !== null && 
               $this->latitude_mdeg !== '' && 
               $this->longitude_mdeg !== null && 
               $this->longitude_mdeg !== '';
    }

    /**
     * Check if event has location text
     */
    public function hasLocationText(): bool
    {
        return $this->postext !== '';
    }

    /**
     * Check if event has formatted coordinates
     */
    public function hasFormattedCoordinates(): bool
    {
        return $this->latitude !== '' && $this->longitude !== '';
    }

    /**
     * Get formatted coordinates as string
     */
    public function getFormattedCoordinates(): string
    {
        if (!$this->hasFormattedCoordinates()) {
            return '';
        }

        return trim($this->latitude . ' ' . $this->longitude);
    }

    /**
     * Check if event has object assigned
     */
    public function hasObject(): bool
    {
        return $this->objectno !== '';
    }

    /**
     * Check if event has a resolver user
     */
    public function hasResolver(): bool
    {
        return $this->resuser !== '';
    }

    /**
     * Check if event has an acknowledger user
     */
    public function hasAcknowledger(): bool
    {
        return $this->ackuser !== '';
    }

    /**
     * Get event status summary
     */
    public function getStatusSummary(): string
    {
        if ($this->isResolved()) {
            return 'Resolved';
        }

        if ($this->isAcknowledged()) {
            return 'Acknowledged';
        }

        return 'Pending';
    }

    /**
     * Get a combined display string for the event
     */
    public function getSummary(): string
    {
        $parts = [];

        if ($this->objectno !== '') {
            $parts[] = "Object: {$this->objectno}";
        }

        $parts[] = "Level: {$this->getCurrentEventLevelLabel()}";
        $parts[] = "Status: {$this->getStatusSummary()}";

        if ($this->msgtext !== '') {
            $parts[] = $this->msgtext;
        }

        return implode(' | ', $parts);
    }

    /**
     * Get event priority score (higher = more urgent)
     * Based on severity, acknowledgment status, and age
     */
    public function getPriorityScore(): int
    {
        $score = 0;

        // Severity score (0-30 points)
        $currentLevel = $this->getCurrentEventLevel();
        if ($currentLevel !== null) {
            $score += $currentLevel->severity() * 10;
        }

        // Unacknowledged alarm bonus (20 points)
        if ($this->isAlarm() && !$this->isAcknowledged()) {
            $score += 20;
        }

        // Pending status bonus (10 points)
        if ($this->isPending()) {
            $score += 10;
        }

        // Age score (up to 20 points for events older than 1 hour)
        $timeSince = $this->getTimeSinceEvent();
        if ($timeSince !== null) {
            $hoursOld = $timeSince / 3600;
            $score += min(20, (int)$hoursOld);
        }

        return $score;
    }
}
