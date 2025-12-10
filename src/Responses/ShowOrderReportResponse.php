<?php

declare(strict_types=1);

namespace Webfleet\Responses;

use DateTimeImmutable;

/**
 * DTO for the showOrderReportExtern response.
 */
final class ShowOrderReportResponse
{
    public string $orderid;
    public ?string $ordertext = null;
    public ?int $ordertype = null;
    public ?string $objectno = null;
    public ?string $objectname = null;
    public ?int $longitude = null;
    public ?int $latitude = null;
    public ?int $orderstate = null;
    public ?DateTimeImmutable $orderdate = null;
    public ?DateTimeImmutable $orderstate_time = null;
    public ?int $orderstate_longitude = null;
    public ?int $orderstate_latitude = null;
    public ?string $contact = null;
    public ?string $contacttel = null;
    public ?string $contactemail = null;
    public ?string $driverno = null;
    public ?string $drivername = null;
    public ?string $drivertelmobile = null;
    public ?int $waypointcount = null;
    public ?string $addrnr = null;
    public ?string $country = null;
    public ?string $zip = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $objectuid = null;
    public ?string $driveruid = null;
    public ?string $mapcode = null;

    /**
     * Constructor to initialize the DTO.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(
        array $data,
    ) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        // Convert date strings to DateTimeImmutable
        if (isset($data['orderdate']) && is_string($data['orderdate'])) {
            $this->orderdate = new DateTimeImmutable($data['orderdate']);
        }

        if (isset($data['orderstate_time']) && is_string($data['orderstate_time'])) {
            $this->orderstate_time = new DateTimeImmutable($data['orderstate_time']);
        }
    }

    /**
     * Helper to get a human-readable order state.
     */
    public function getOrderStateDescription(): ?string
    {
        return match ($this->orderstate) {
            0 => 'Not yet sent',
            100 => 'Sent',
            101 => 'Received',
            102 => 'Read',
            103 => 'Accepted',
            201 => 'Service order started',
            202 => 'Arrived at destination',
            203 => 'Work started',
            204 => 'Work finished',
            205 => 'Departed from destination',
            207 => 'Proof of delivery (service order type)',
            221 => 'Pickup order started',
            222 => 'Arrived at pick up location',
            223 => 'Pick up started',
            224 => 'Pick up finished',
            225 => 'Departed from pick up location',
            227 => 'Proof of delivery (pick up order type)',
            241 => 'Delivery order started',
            242 => 'Arrived at delivery location',
            243 => 'Delivery started',
            244 => 'Delivery finished',
            245 => 'Departed from delivery location',
            247 => 'Proof of delivery (delivery order type)',
            298 => 'Resumed',
            299 => 'Suspended',
            301 => 'Cancelled',
            302 => 'Rejected',
            401 => 'Finished',
            default => null,
        };
    }
}