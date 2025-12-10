<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Order state enumeration
 * 
 * Represents all possible states an order can be in during its lifecycle
 */
enum OrderState: int
{
    // Initial states
    case NOT_YET_SENT = 0;
    case SENT = 100;
    case RECEIVED = 101;
    case READ = 102;
    case ACCEPTED = 103;

    // Service order states (201-207)
    case SERVICE_STARTED = 201;
    case SERVICE_ARRIVED = 202;
    case SERVICE_WORK_STARTED = 203;
    case SERVICE_WORK_FINISHED = 204;
    case SERVICE_DEPARTED = 205;
    case SERVICE_PROOF_OF_DELIVERY = 207;

    // Pickup order states (221-227)
    case PICKUP_STARTED = 221;
    case PICKUP_ARRIVED = 222;
    case PICKUP_WORK_STARTED = 223;
    case PICKUP_WORK_FINISHED = 224;
    case PICKUP_DEPARTED = 225;
    case PICKUP_PROOF_OF_DELIVERY = 227;

    // Delivery order states (241-247)
    case DELIVERY_STARTED = 241;
    case DELIVERY_ARRIVED = 242;
    case DELIVERY_WORK_STARTED = 243;
    case DELIVERY_WORK_FINISHED = 244;
    case DELIVERY_DEPARTED = 245;
    case DELIVERY_PROOF_OF_DELIVERY = 247;

    // Control states
    case RESUMED = 298;
    case SUSPENDED = 299;
    case CANCELLED = 301;
    case REJECTED = 302;
    case FINISHED = 401;

    /**
     * Get a human-readable label for the order state
     */
    public function label(): string
    {
        return match ($this) {
            self::NOT_YET_SENT => 'Not Yet Sent',
            self::SENT => 'Sent',
            self::RECEIVED => 'Received',
            self::READ => 'Read',
            self::ACCEPTED => 'Accepted',
            
            self::SERVICE_STARTED => 'Service Order Started',
            self::SERVICE_ARRIVED => 'Arrived at Destination',
            self::SERVICE_WORK_STARTED => 'Work Started',
            self::SERVICE_WORK_FINISHED => 'Work Finished',
            self::SERVICE_DEPARTED => 'Departed from Destination',
            self::SERVICE_PROOF_OF_DELIVERY => 'Proof of Delivery',
            
            self::PICKUP_STARTED => 'Pickup Order Started',
            self::PICKUP_ARRIVED => 'Arrived at Pickup Location',
            self::PICKUP_WORK_STARTED => 'Pickup Started',
            self::PICKUP_WORK_FINISHED => 'Pickup Finished',
            self::PICKUP_DEPARTED => 'Departed from Pickup Location',
            self::PICKUP_PROOF_OF_DELIVERY => 'Proof of Delivery',
            
            self::DELIVERY_STARTED => 'Delivery Order Started',
            self::DELIVERY_ARRIVED => 'Arrived at Delivery Location',
            self::DELIVERY_WORK_STARTED => 'Delivery Started',
            self::DELIVERY_WORK_FINISHED => 'Delivery Finished',
            self::DELIVERY_DEPARTED => 'Departed from Delivery Location',
            self::DELIVERY_PROOF_OF_DELIVERY => 'Proof of Delivery',
            
            self::RESUMED => 'Resumed',
            self::SUSPENDED => 'Suspended',
            self::CANCELLED => 'Cancelled',
            self::REJECTED => 'Rejected',
            self::FINISHED => 'Finished',
        };
    }

    /**
     * Check if the order is in a terminal state (completed, cancelled, or rejected)
     */
    public function isTerminal(): bool
    {
        return match ($this) {
            self::CANCELLED,
            self::REJECTED,
            self::FINISHED => true,
            default => false,
        };
    }

    /**
     * Check if the order is active (in progress)
     */
    public function isActive(): bool
    {
        return !$this->isTerminal() && 
               !in_array($this, [self::NOT_YET_SENT, self::SENT, self::SUSPENDED], true);
    }

    /**
     * Check if this is a service order state
     */
    public function isServiceState(): bool
    {
        return $this->value >= 201 && $this->value <= 207;
    }

    /**
     * Check if this is a pickup order state
     */
    public function isPickupState(): bool
    {
        return $this->value >= 221 && $this->value <= 227;
    }

    /**
     * Check if this is a delivery order state
     */
    public function isDeliveryState(): bool
    {
        return $this->value >= 241 && $this->value <= 247;
    }

    /**
     * Check if the driver has arrived at location
     */
    public function hasArrived(): bool
    {
        return match ($this) {
            self::SERVICE_ARRIVED,
            self::PICKUP_ARRIVED,
            self::DELIVERY_ARRIVED => true,
            default => false,
        };
    }

    /**
     * Check if work has started
     */
    public function hasWorkStarted(): bool
    {
        return match ($this) {
            self::SERVICE_WORK_STARTED,
            self::PICKUP_WORK_STARTED,
            self::DELIVERY_WORK_STARTED => true,
            default => false,
        };
    }

    /**
     * Check if work has finished
     */
    public function hasWorkFinished(): bool
    {
        return match ($this) {
            self::SERVICE_WORK_FINISHED,
            self::PICKUP_WORK_FINISHED,
            self::DELIVERY_WORK_FINISHED => true,
            default => false,
        };
    }

    /**
     * Check if proof of delivery has been provided
     */
    public function hasProofOfDelivery(): bool
    {
        return match ($this) {
            self::SERVICE_PROOF_OF_DELIVERY,
            self::PICKUP_PROOF_OF_DELIVERY,
            self::DELIVERY_PROOF_OF_DELIVERY => true,
            default => false,
        };
    }
}
