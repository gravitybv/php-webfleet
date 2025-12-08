<?php

declare(strict_types=1);

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\WorkState;
use DateTimeImmutable;
use DateInterval;

/**
 * Response DTO for showDriverReportExtern API call
 * 
 * Contains comprehensive driver information including personal details,
 * contact information, current assignment, work state, and credentials.
 */
final class DriverReport extends Container
{
    // Driver Identification
    public string $driverno = '';
    public string $driveruid = '';
    
    // Driver Names
    public string $name1 = '';
    public string $name2 = '';
    public string $name3 = '';
    
    // Address Information
    public string $addrno = '';
    public string $state = '';
    public string $zip = '';
    public string $city = '';
    public string $street = '';
    public string|null $addr_latitude = null;
    public string|null $addr_longitude = null;
    
    // Contact Information
    public string $telmobile = '';
    public string $telprivate = '';
    public string $email = '';
    
    // Additional Details
    public string $description = '';
    public string $company = '';
    public string $pin = '';
    
    // Current Vehicle Assignment
    public string $objectno = '';
    public string $objectuid = '';
    public string|null $signontime = null;
    public string|null $manualassignment = null;
    
    // Driver Role
    public string|null $signonrole = null;
    
    // Digital Tachograph
    public string $dt_cardid = '';
    public string $dt_cardcountry = '';
    
    // Remote LINK
    public string $rll_buttonid = '';
    
    // Work State Tracking
    public string|null $current_workstate = null;
    public string|null $current_workingtimestart = null;
    public string|null $current_workingtimeend = null;
    public string|null $current_workingtime = null;
    
    // Complex JSON Fields
    public string $driver_keys = '';
    public string $driving_license = '';

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    /**
     * Get the full driver name combining name1, name2, and name3
     */
    public function getFullName(): string
    {
        return trim(implode(' ', array_filter([
            $this->name1,
            $this->name2,
            $this->name3,
        ])));
    }

    /**
     * Check if the driver is currently signed on to a vehicle
     */
    public function isSignedOn(): bool
    {
        return $this->objectno !== '' && $this->signontime !== null;
    }

    /**
     * Get the sign-on time as DateTimeImmutable
     */
    public function getSignOnDateTime(): ?DateTimeImmutable
    {
        if ($this->signontime === null || $this->signontime === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->signontime);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the current work state as enum
     */
    public function getCurrentWorkState(): ?WorkState
    {
        if ($this->current_workstate === null || $this->current_workstate === '') {
            return null;
        }

        return WorkState::tryFrom((int)$this->current_workstate);
    }

    /**
     * Get the current work state description
     */
    public function getCurrentWorkStateLabel(): string
    {
        $workState = $this->getCurrentWorkState();
        return $workState?->description() ?? 'Unknown';
    }

    /**
     * Check if driver is currently working
     */
    public function isCurrentlyWorking(): bool
    {
        $workState = $this->getCurrentWorkState();
        return $workState?->isActiveWork() ?? false;
    }

    /**
     * Check if driver is currently resting
     */
    public function isCurrentlyResting(): bool
    {
        $workState = $this->getCurrentWorkState();
        return $workState?->isResting() ?? false;
    }

    /**
     * Get the current working time start as DateTimeImmutable
     */
    public function getCurrentWorkingTimeStart(): ?DateTimeImmutable
    {
        if ($this->current_workingtimestart === null || $this->current_workingtimestart === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->current_workingtimestart);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get the current working time end as DateTimeImmutable
     */
    public function getCurrentWorkingTimeEnd(): ?DateTimeImmutable
    {
        if ($this->current_workingtimeend === null || $this->current_workingtimeend === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->current_workingtimeend);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse ISO 8601 duration to seconds
     * Handles formats like PT362S or PT6M2S
     */
    public function getCurrentWorkingTimeSeconds(): ?int
    {
        if ($this->current_workingtime === null || $this->current_workingtime === '') {
            return null;
        }

        try {
            $interval = new DateInterval($this->current_workingtime);
            return ($interval->d * 86400) + 
                   ($interval->h * 3600) + 
                   ($interval->i * 60) + 
                   $interval->s;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get current working time in human-readable format (HH:MM:SS)
     */
    public function getCurrentWorkingTimeFormatted(): string
    {
        $seconds = $this->getCurrentWorkingTimeSeconds();
        if ($seconds === null) {
            return '00:00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get sign-on role description
     */
    public function getSignOnRole(): string
    {
        if ($this->signonrole === null || $this->signonrole === '') {
            return 'Unknown';
        }

        return match ((int)$this->signonrole) {
            1 => 'Driver',
            2 => 'Co-Driver',
            3 => 'Worker',
            default => 'Unknown',
        };
    }

    /**
     * Check if manually assigned to vehicle
     */
    public function isManuallyAssigned(): ?bool
    {
        if ($this->manualassignment === null || $this->manualassignment === '') {
            return null;
        }

        return (int)$this->manualassignment === 1;
    }

    /**
     * Get assignment type description
     */
    public function getAssignmentType(): string
    {
        $manual = $this->isManuallyAssigned();
        if ($manual === null) {
            return 'Not assigned';
        }

        return $manual ? 'Manual' : 'Automatic';
    }

    /**
     * Get latitude in degrees (from micro degrees)
     */
    public function getLatitudeDegrees(): ?float
    {
        if ($this->addr_latitude === null || $this->addr_latitude === '') {
            return null;
        }

        return (float)$this->addr_latitude / 1_000_000;
    }

    /**
     * Get longitude in degrees (from micro degrees)
     */
    public function getLongitudeDegrees(): ?float
    {
        if ($this->addr_longitude === null || $this->addr_longitude === '') {
            return null;
        }

        return (float)$this->addr_longitude / 1_000_000;
    }

    /**
     * Get full address as single string
     */
    public function getFullAddress(): string
    {
        $parts = array_filter([
            $this->street,
            $this->zip,
            $this->city,
            $this->state,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Check if driver has a digital tachograph card
     */
    public function hasDigitalTachographCard(): bool
    {
        return $this->dt_cardid !== '';
    }

    /**
     * Check if driver has a Remote LINK button
     */
    public function hasRemoteLinkButton(): bool
    {
        return $this->rll_buttonid !== '';
    }

    /**
     * Parse driver keys JSON
     * Returns array of driver key objects with type and value
     * 
     * @return array<int, array{driver_key_type: int, driver_key_value: string}>
     */
    public function getDriverKeys(): array
    {
        if ($this->driver_keys === '') {
            return [];
        }

        try {
            $decoded = json_decode($this->driver_keys, true, 512, JSON_THROW_ON_ERROR);
            return is_array($decoded) ? $decoded : [];
        } catch (\JsonException $e) {
            return [];
        }
    }

    /**
     * Get driver key type description
     */
    public function getDriverKeyTypeLabel(int $type): string
    {
        return match ($type) {
            1 => 'Remote LINK',
            2 => 'Generic identifier',
            default => 'Unknown',
        };
    }

    /**
     * Parse driving license JSON
     * 
     * @return array{
     *     number?: string,
     *     country?: string,
     *     state?: string,
     *     issue_date?: string,
     *     expiry_date?: string,
     *     types?: array<int, array{code: string, valid_from?: string, valid_to?: string}>
     * }|null
     */
    public function getDrivingLicense(): ?array
    {
        if ($this->driving_license === '') {
            return null;
        }

        try {
            $decoded = json_decode($this->driving_license, true, 512, JSON_THROW_ON_ERROR);
            return is_array($decoded) ? $decoded : null;
        } catch (\JsonException $e) {
            return null;
        }
    }

    /**
     * Get driving license number
     */
    public function getDrivingLicenseNumber(): ?string
    {
        $license = $this->getDrivingLicense();
        return $license['number'] ?? null;
    }

    /**
     * Check if driving license is expired
     */
    public function isDrivingLicenseExpired(): bool
    {
        $license = $this->getDrivingLicense();
        if (!isset($license['expiry_date'])) {
            return false;
        }

        try {
            $expiryDate = new DateTimeImmutable($license['expiry_date']);
            return $expiryDate < new DateTimeImmutable();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all driving license type codes (A, B, C, etc.)
     * 
     * @return string[]
     */
    public function getDrivingLicenseTypes(): array
    {
        $license = $this->getDrivingLicense();
        if (!isset($license['types']) || !is_array($license['types'])) {
            return [];
        }

        return array_map(
            fn(array $type): string => $type['code'] ?? '',
            $license['types']
        );
    }

    /**
     * Check if driver has a specific license type
     */
    public function hasDrivingLicenseType(string $code): bool
    {
        return in_array(strtoupper($code), $this->getDrivingLicenseTypes(), true);
    }
}
