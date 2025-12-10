<?php

declare(strict_types=1);

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\OrderType;
use Webfleet\Enums\OrderState;
use Webfleet\Enums\DelayWarning;
use DateTimeImmutable;

/**
 * Response DTO for showOrderReportExtern API call
 * 
 * Contains comprehensive order information including scheduling,
 * location tracking, state management, and contact details.
 */
final class OrderReport extends Container
{
    // Order Identification
    public string $orderid = '';
    public string|null $orderdate = null;
    public string $ordertext = '';
    public string|null $ordertype = null;

    // Object Assignment
    public string $objectno = '';
    public string $objectuid = '';
    public string $objectname = '';

    // Driver Assignment
    public string $driverno = '';
    public string $driveruid = '';
    public string $drivername = '';
    public string $drivertelmobile = '';

    // Destination Location
    public string|null $longitude = null;
    public string|null $latitude = null;
    public string $destination = '';
    public string $mapcode = '';

    // Destination Address
    public string $addrnr = '';
    public string $country = '';
    public string $zip = '';
    public string $city = '';
    public string $street = '';

    // Order State Tracking
    public string|null $orderstate = null;
    public string|null $orderstate_time = null;
    public string|null $orderstate_longitude = null;
    public string|null $orderstate_latitude = null;
    public string $orderstate_postext = '';
    public string $orderstate_msgtext = '';

    // Timing
    public string|null $planned_arrival_time = null;
    public string|null $estimated_arrival_time = null;
    public string|null $arrivaltolerance = null;

    // Notifications
    public string|null $notify_enabled = null;
    public string|null $notify_leadtime = null;
    public string|null $delay_warnings = null;

    // Contact Information
    public string $contact = '';
    public string $contacttel = '';
    public string $contactemail = '';

    // Waypoints
    public string|null $waypointcount = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    /**
     * Get the order type as enum
     */
    public function getOrderType(): ?OrderType
    {
        if ($this->ordertype === null || $this->ordertype === '') {
            return null;
        }

        return OrderType::tryFrom((int)$this->ordertype);
    }

    /**
     * Get the order type label
     */
    public function getOrderTypeLabel(): string
    {
        return $this->getOrderType()?->label() ?? 'Unknown';
    }

    /**
     * Get the order state as enum
     */
    public function getOrderState(): ?OrderState
    {
        if ($this->orderstate === null || $this->orderstate === '') {
            return null;
        }

        return OrderState::tryFrom((int)$this->orderstate);
    }

    /**
     * Get the order state label
     */
    public function getOrderStateLabel(): string
    {
        return $this->getOrderState()?->label() ?? 'Unknown';
    }

    /**
     * Check if the order is in a terminal state
     */
    public function isTerminal(): bool
    {
        return $this->getOrderState()?->isTerminal() ?? false;
    }

    /**
     * Check if the order is active
     */
    public function isActive(): bool
    {
        return $this->getOrderState()?->isActive() ?? false;
    }

    /**
     * Check if the order is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->getOrderState() === OrderState::CANCELLED;
    }

    /**
     * Check if the order is finished
     */
    public function isFinished(): bool
    {
        return $this->getOrderState() === OrderState::FINISHED;
    }

    /**
     * Check if the driver has arrived
     */
    public function hasArrived(): bool
    {
        return $this->getOrderState()?->hasArrived() ?? false;
    }

    /**
     * Check if work has started
     */
    public function hasWorkStarted(): bool
    {
        return $this->getOrderState()?->hasWorkStarted() ?? false;
    }

    /**
     * Check if proof of delivery has been provided
     */
    public function hasProofOfDelivery(): bool
    {
        return $this->getOrderState()?->hasProofOfDelivery() ?? false;
    }

    /**
     * Get the order date as DateTimeImmutable
     */
    public function getOrderDate(): ?DateTimeImmutable
    {
        if ($this->orderdate === null || $this->orderdate === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->orderdate);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the order state time as DateTimeImmutable
     */
    public function getOrderStateTime(): ?DateTimeImmutable
    {
        if ($this->orderstate_time === null || $this->orderstate_time === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->orderstate_time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get destination longitude in degrees (from micro degrees)
     */
    public function getLongitudeDegrees(): ?float
    {
        if ($this->longitude === null || $this->longitude === '') {
            return null;
        }

        return (float)$this->longitude / 1_000_000;
    }

    /**
     * Get destination latitude in degrees (from micro degrees)
     */
    public function getLatitudeDegrees(): ?float
    {
        if ($this->latitude === null || $this->latitude === '') {
            return null;
        }

        return (float)$this->latitude / 1_000_000;
    }

    /**
     * Get order state longitude in degrees (from micro degrees)
     */
    public function getOrderStateLongitudeDegrees(): ?float
    {
        if ($this->orderstate_longitude === null || $this->orderstate_longitude === '') {
            return null;
        }

        return (float)$this->orderstate_longitude / 1_000_000;
    }

    /**
     * Get order state latitude in degrees (from micro degrees)
     */
    public function getOrderStateLatitudeDegrees(): ?float
    {
        if ($this->orderstate_latitude === null || $this->orderstate_latitude === '') {
            return null;
        }

        return (float)$this->orderstate_latitude / 1_000_000;
    }

    /**
     * Get full destination address as single string
     */
    public function getFullAddress(): string
    {
        $parts = array_filter([
            $this->street,
            $this->zip,
            $this->city,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Check if notifications are enabled
     */
    public function isNotifyEnabled(): bool
    {
        if ($this->notify_enabled === null || $this->notify_enabled === '') {
            return false;
        }

        return filter_var($this->notify_enabled, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get notification lead time in seconds
     */
    public function getNotifyLeadTimeSeconds(): ?int
    {
        if ($this->notify_leadtime === null || $this->notify_leadtime === '') {
            return null;
        }

        return (int)$this->notify_leadtime;
    }

    /**
     * Get delay warning as enum
     */
    public function getDelayWarning(): ?DelayWarning
    {
        if ($this->delay_warnings === null || $this->delay_warnings === '') {
            return null;
        }

        return DelayWarning::tryFrom((int)$this->delay_warnings);
    }

    /**
     * Get delay warning label
     */
    public function getDelayWarningLabel(): string
    {
        return $this->getDelayWarning()?->label() ?? 'No Warning';
    }

    /**
     * Check if delay is critical
     */
    public function hasDelayWarning(): bool
    {
        return $this->getDelayWarning() !== null;
    }

    /**
     * Check if delay is above tolerance
     */
    public function isDelayCritical(): bool
    {
        return $this->getDelayWarning()?->isCritical() ?? false;
    }

    /**
     * Get waypoint count
     */
    public function getWaypointCount(): int
    {
        if ($this->waypointcount === null || $this->waypointcount === '') {
            return 0;
        }

        return (int)$this->waypointcount;
    }

    /**
     * Check if order has waypoints
     */
    public function hasWaypoints(): bool
    {
        return $this->getWaypointCount() > 0;
    }

    /**
     * Check if order has a driver assigned
     */
    public function hasDriver(): bool
    {
        return $this->driverno !== '';
    }

    /**
     * Check if order has an object (vehicle) assigned
     */
    public function hasObject(): bool
    {
        return $this->objectno !== '';
    }

    /**
     * Check if destination is defined by address number
     */
    public function hasAddressNumber(): bool
    {
        return $this->addrnr !== '';
    }

    /**
     * Check if destination has coordinates
     */
    public function hasCoordinates(): bool
    {
        return $this->longitude !== null && 
               $this->longitude !== '' && 
               $this->latitude !== null && 
               $this->latitude !== '';
    }

    /**
     * Check if order state has coordinates
     */
    public function hasOrderStateCoordinates(): bool
    {
        return $this->orderstate_longitude !== null && 
               $this->orderstate_longitude !== '' && 
               $this->orderstate_latitude !== null && 
               $this->orderstate_latitude !== '';
    }

    /**
     * Get distance between destination and order state position in meters
     * Uses Haversine formula for great-circle distance
     */
    public function getDistanceToOrderState(): ?float
    {
        if (!$this->hasCoordinates() || !$this->hasOrderStateCoordinates()) {
            return null;
        }

        $lat1 = $this->getLatitudeDegrees();
        $lon1 = $this->getLongitudeDegrees();
        $lat2 = $this->getOrderStateLatitudeDegrees();
        $lon2 = $this->getOrderStateLongitudeDegrees();

        if ($lat1 === null || $lon1 === null || $lat2 === null || $lon2 === null) {
            return null;
        }

        $earthRadius = 6371000; // meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Get distance to order state in kilometers
     */
    public function getDistanceToOrderStateKm(): ?float
    {
        $meters = $this->getDistanceToOrderState();
        return $meters !== null ? round($meters / 1000, 2) : null;
    }
}
