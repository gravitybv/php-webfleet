<?php

declare(strict_types=1);

namespace Webfleet\Enums;

/**
 * Order type enumeration
 * 
 * Represents the three types of orders supported by Webfleet
 */
enum OrderType: int
{
    case SERVICE = 1;
    case PICKUP = 2;
    case DELIVERY = 3;

    /**
     * Get a human-readable label for the order type
     */
    public function label(): string
    {
        return match ($this) {
            self::SERVICE => 'Service Order',
            self::PICKUP => 'Pickup Order',
            self::DELIVERY => 'Delivery Order',
        };
    }

    /**
     * Get a short description of the order type
     */
    public function description(): string
    {
        return match ($this) {
            self::SERVICE => 'Service order for maintenance or repair work',
            self::PICKUP => 'Order to pick up goods or items',
            self::DELIVERY => 'Order to deliver goods or items',
        };
    }
}
