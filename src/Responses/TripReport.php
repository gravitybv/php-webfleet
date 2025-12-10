<?php

declare(strict_types=1);

namespace Webfleet\Responses;

use Webfleet\Container;
use Webfleet\Enums\TripMode;
use Webfleet\Enums\FuelType;
use DateTimeImmutable;

/**
 * Response DTO for showTripReportExtern API call
 * 
 * Contains comprehensive trip information including distance, duration,
 * fuel/energy consumption, OptiDrive indicators, and location details.
 */
final class TripReport extends Container
{
    // Trip Identification
    public string $tripid = '';
    public string|null $tripmode = null;
    public string $externalid = '';

    // Object/Vehicle Information
    public string $objectno = '';
    public string $objectuid = '';
    public string $objectname = '';

    // Driver Information
    public string $driverno = '';
    public string $driveruid = '';
    public string $drivername = '';

    // Trip Start Information
    public string|null $start_time = null;
    public string|null $start_odometer = null;
    public string $start_postext = '';
    public string|null $start_longitude = null;
    public string|null $start_latitude = null;
    public string $start_formatted_longitude = '';
    public string $start_formatted_latitude = '';
    public string $start_addrno = '';

    // Trip End Information
    public string|null $end_time = null;
    public string|null $end_odometer = null;
    public string $end_postext = '';
    public string|null $end_longitude = null;
    public string|null $end_latitude = null;
    public string $end_formatted_longitude = '';
    public string $end_formatted_latitude = '';
    public string $end_addrno = '';

    // Trip Metrics
    public string|null $duration = null;
    public string|null $idle_time = null;
    public string|null $distance = null;
    public string|null $avg_speed = null;
    public string|null $max_speed = null;

    // Fuel Consumption (Combustion Vehicles)
    public string|null $fueltype = null;
    public string|null $fuel_usage = null;
    public string|null $co2 = null;
    public string|null $ep_distance = null;

    // Energy Consumption (Electric Vehicles)
    public string|null $energy_usage = null;
    public string|null $start_battery_level = null;
    public string|null $end_battery_level = null;
    public string|null $start_battery_energy = null;
    public string|null $end_battery_energy = null;
    public string|null $energy_consumption_driving = null;
    public string|null $energy_consumption_other = null;
    public string|null $enery_recovered = null;

    // OptiDrive Overall Indicator
    public string|null $optidrive_indicator = null;

    // OptiDrive Component Indicators
    public string|null $speeding_indicator = null;
    public string|null $drivingevents_indicator = null;
    public string|null $idling_indicator = null;
    public string|null $fuelusage_indicator = null;
    public string|null $coasting_indicator = null;
    public string|null $constant_speed_indicator = null;
    public string|null $green_speed_indicator = null;
    public string|null $high_revving_indicator = null;
    public string|null $energy_consumption_indicator = null;
    public string|null $cruise_control_indicator = null;
    public string|null $video_indicator = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value ?? '';
            }
        }
    }

    /**
     * Get the trip mode as enum
     */
    public function getTripMode(): ?TripMode
    {
        if ($this->tripmode === null || $this->tripmode === '') {
            return null;
        }

        return TripMode::tryFrom((int)$this->tripmode);
    }

    /**
     * Get the trip mode label
     */
    public function getTripModeLabel(): string
    {
        return $this->getTripMode()?->label() ?? 'Unknown';
    }

    /**
     * Get the fuel type as enum
     */
    public function getFuelType(): ?FuelType
    {
        if ($this->fueltype === null || $this->fueltype === '') {
            return null;
        }

        return FuelType::tryFrom((int)$this->fueltype);
    }

    /**
     * Get the fuel type label
     */
    public function getFuelTypeLabel(): string
    {
        return $this->getFuelType()?->label() ?? 'Unknown';
    }

    /**
     * Check if this is an electric vehicle trip
     */
    public function isElectricVehicle(): bool
    {
        return $this->getFuelType() === FuelType::ELECTRIC;
    }

    /**
     * Check if this is a hybrid vehicle trip
     */
    public function isHybridVehicle(): bool
    {
        $fuelType = $this->getFuelType();
        return $fuelType === FuelType::HYBRID_PETROL || 
               $fuelType === FuelType::HYBRID_DIESEL;
    }

    /**
     * Get trip start time as DateTimeImmutable
     */
    public function getStartTime(): ?DateTimeImmutable
    {
        if ($this->start_time === null || $this->start_time === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->start_time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get trip end time as DateTimeImmutable
     */
    public function getEndTime(): ?DateTimeImmutable
    {
        if ($this->end_time === null || $this->end_time === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($this->end_time);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get trip duration in seconds
     */
    public function getDurationSeconds(): ?int
    {
        if ($this->duration === null || $this->duration === '') {
            return null;
        }

        return (int)$this->duration;
    }

    /**
     * Get trip duration in human-readable format (HH:MM:SS)
     */
    public function getDurationFormatted(): string
    {
        $seconds = $this->getDurationSeconds();
        if ($seconds === null) {
            return '00:00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get idle time in seconds
     */
    public function getIdleTimeSeconds(): ?int
    {
        if ($this->idle_time === null || $this->idle_time === '') {
            return null;
        }

        return (int)$this->idle_time;
    }

    /**
     * Get idle time in human-readable format (HH:MM:SS)
     */
    public function getIdleTimeFormatted(): string
    {
        $seconds = $this->getIdleTimeSeconds();
        if ($seconds === null) {
            return '00:00:00';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Get idle time as percentage of total trip duration
     */
    public function getIdleTimePercentage(): ?float
    {
        $duration = $this->getDurationSeconds();
        $idleTime = $this->getIdleTimeSeconds();

        if ($duration === null || $idleTime === null || $duration === 0) {
            return null;
        }

        return round(($idleTime / $duration) * 100, 2);
    }

    /**
     * Get distance in meters
     */
    public function getDistanceMeters(): ?int
    {
        if ($this->distance === null || $this->distance === '') {
            return null;
        }

        return (int)$this->distance;
    }

    /**
     * Get distance in kilometers
     */
    public function getDistanceKm(): ?float
    {
        $meters = $this->getDistanceMeters();
        return $meters !== null ? round($meters / 1000, 2) : null;
    }

    /**
     * Get average speed in km/h
     */
    public function getAverageSpeed(): ?int
    {
        if ($this->avg_speed === null || $this->avg_speed === '') {
            return null;
        }

        return (int)$this->avg_speed;
    }

    /**
     * Get maximum speed in km/h
     */
    public function getMaxSpeed(): ?int
    {
        if ($this->max_speed === null || $this->max_speed === '') {
            return null;
        }

        return (int)$this->max_speed;
    }

    /**
     * Get fuel usage in liters
     */
    public function getFuelUsageLiters(): ?float
    {
        if ($this->fuel_usage === null || $this->fuel_usage === '') {
            return null;
        }

        return (float)$this->fuel_usage;
    }

    /**
     * Get fuel consumption in L/100km
     */
    public function getFuelConsumptionPer100Km(): ?float
    {
        $fuel = $this->getFuelUsageLiters();
        $distance = $this->getDistanceKm();

        if ($fuel === null || $distance === null || $distance === 0.0) {
            return null;
        }

        return round(($fuel / $distance) * 100, 2);
    }

    /**
     * Get CO2 emissions in grams
     */
    public function getCO2Grams(): ?int
    {
        if ($this->co2 === null || $this->co2 === '') {
            return null;
        }

        return (int)$this->co2;
    }

    /**
     * Get CO2 emissions in kilograms
     */
    public function getCO2Kg(): ?float
    {
        $grams = $this->getCO2Grams();
        return $grams !== null ? round($grams / 1000, 2) : null;
    }

    /**
     * Get ecoPLUS distance in meters
     */
    public function getEcoPlusDistanceMeters(): ?int
    {
        if ($this->ep_distance === null || $this->ep_distance === '') {
            return null;
        }

        return (int)$this->ep_distance;
    }

    /**
     * Get ecoPLUS distance in kilometers
     */
    public function getEcoPlusDistanceKm(): ?float
    {
        $meters = $this->getEcoPlusDistanceMeters();
        return $meters !== null ? round($meters / 1000, 2) : null;
    }

    /**
     * Get energy usage in kWh
     */
    public function getEnergyUsageKwh(): ?float
    {
        if ($this->energy_usage === null || $this->energy_usage === '') {
            return null;
        }

        return (float)$this->energy_usage;
    }

    /**
     * Get energy consumption in kWh/100km
     */
    public function getEnergyConsumptionPer100Km(): ?float
    {
        $energy = $this->getEnergyUsageKwh();
        $distance = $this->getDistanceKm();

        if ($energy === null || $distance === null || $distance === 0.0) {
            return null;
        }

        return round(($energy / $distance) * 100, 2);
    }

    /**
     * Get battery level change (percentage points)
     */
    public function getBatteryLevelChange(): ?int
    {
        if ($this->start_battery_level === null || 
            $this->start_battery_level === '' ||
            $this->end_battery_level === null || 
            $this->end_battery_level === '') {
            return null;
        }

        return (int)$this->end_battery_level - (int)$this->start_battery_level;
    }

    /**
     * Get battery energy change in Wh
     */
    public function getBatteryEnergyChange(): ?float
    {
        if ($this->start_battery_energy === null || 
            $this->start_battery_energy === '' ||
            $this->end_battery_energy === null || 
            $this->end_battery_energy === '') {
            return null;
        }

        return (float)$this->end_battery_energy - (float)$this->start_battery_energy;
    }

    /**
     * Get energy used for driving in kWh
     */
    public function getEnergyConsumptionDriving(): ?float
    {
        if ($this->energy_consumption_driving === null || $this->energy_consumption_driving === '') {
            return null;
        }

        return (float)$this->energy_consumption_driving;
    }

    /**
     * Get energy used for other purposes (heating, climate, etc.) in kWh
     */
    public function getEnergyConsumptionOther(): ?float
    {
        if ($this->energy_consumption_other === null || $this->energy_consumption_other === '') {
            return null;
        }

        return (float)$this->energy_consumption_other;
    }

    /**
     * Get energy recovered from braking in kWh
     */
    public function getEnergyRecovered(): ?float
    {
        if ($this->enery_recovered === null || $this->enery_recovered === '') {
            return null;
        }

        return (float)$this->enery_recovered;
    }

    /**
     * Get start longitude in degrees (from micro degrees)
     */
    public function getStartLongitudeDegrees(): ?float
    {
        if ($this->start_longitude === null || $this->start_longitude === '') {
            return null;
        }

        return (float)$this->start_longitude / 1_000_000;
    }

    /**
     * Get start latitude in degrees (from micro degrees)
     */
    public function getStartLatitudeDegrees(): ?float
    {
        if ($this->start_latitude === null || $this->start_latitude === '') {
            return null;
        }

        return (float)$this->start_latitude / 1_000_000;
    }

    /**
     * Get end longitude in degrees (from micro degrees)
     */
    public function getEndLongitudeDegrees(): ?float
    {
        if ($this->end_longitude === null || $this->end_longitude === '') {
            return null;
        }

        return (float)$this->end_longitude / 1_000_000;
    }

    /**
     * Get end latitude in degrees (from micro degrees)
     */
    public function getEndLatitudeDegrees(): ?float
    {
        if ($this->end_latitude === null || $this->end_latitude === '') {
            return null;
        }

        return (float)$this->end_latitude / 1_000_000;
    }

    /**
     * Get overall OptiDrive indicator (0-1)
     */
    public function getOptiDriveIndicator(): ?float
    {
        if ($this->optidrive_indicator === null || $this->optidrive_indicator === '') {
            return null;
        }

        return (float)$this->optidrive_indicator;
    }

    /**
     * Get OptiDrive indicator as percentage (0-100)
     */
    public function getOptiDrivePercentage(): ?float
    {
        $indicator = $this->getOptiDriveIndicator();
        return $indicator !== null ? round($indicator * 100, 1) : null;
    }

    /**
     * Get OptiDrive rating based on indicator value
     */
    public function getOptiDriveRating(): string
    {
        $indicator = $this->getOptiDriveIndicator();
        if ($indicator === null) {
            return 'N/A';
        }

        return match (true) {
            $indicator >= 0.9 => 'Excellent',
            $indicator >= 0.8 => 'Very Good',
            $indicator >= 0.7 => 'Good',
            $indicator >= 0.6 => 'Fair',
            $indicator >= 0.5 => 'Poor',
            default => 'Very Poor',
        };
    }

    /**
     * Get speeding indicator (0-1)
     */
    public function getSpeedingIndicator(): ?float
    {
        if ($this->speeding_indicator === null || $this->speeding_indicator === '') {
            return null;
        }

        return (float)$this->speeding_indicator;
    }

    /**
     * Get driving events indicator (0-1)
     */
    public function getDrivingEventsIndicator(): ?float
    {
        if ($this->drivingevents_indicator === null || $this->drivingevents_indicator === '') {
            return null;
        }

        return (float)$this->drivingevents_indicator;
    }

    /**
     * Get idling indicator (0-1)
     */
    public function getIdlingIndicator(): ?float
    {
        if ($this->idling_indicator === null || $this->idling_indicator === '') {
            return null;
        }

        return (float)$this->idling_indicator;
    }

    /**
     * Get fuel usage indicator (0-1)
     */
    public function getFuelUsageIndicator(): ?float
    {
        if ($this->fuelusage_indicator === null || $this->fuelusage_indicator === '') {
            return null;
        }

        return (float)$this->fuelusage_indicator;
    }

    /**
     * Get all OptiDrive indicators as array
     * 
     * @return array<string, float|null>
     */
    public function getAllOptiDriveIndicators(): array
    {
        return [
            'overall' => $this->getOptiDriveIndicator(),
            'speeding' => $this->getSpeedingIndicator(),
            'driving_events' => $this->getDrivingEventsIndicator(),
            'idling' => $this->getIdlingIndicator(),
            'fuel_usage' => $this->getFuelUsageIndicator(),
            'coasting' => $this->coasting_indicator !== null && $this->coasting_indicator !== '' 
                ? (float)$this->coasting_indicator : null,
            'constant_speed' => $this->constant_speed_indicator !== null && $this->constant_speed_indicator !== '' 
                ? (float)$this->constant_speed_indicator : null,
            'green_speed' => $this->green_speed_indicator !== null && $this->green_speed_indicator !== '' 
                ? (float)$this->green_speed_indicator : null,
            'high_revving' => $this->high_revving_indicator !== null && $this->high_revving_indicator !== '' 
                ? (float)$this->high_revving_indicator : null,
            'energy_consumption' => $this->energy_consumption_indicator !== null && $this->energy_consumption_indicator !== '' 
                ? (float)$this->energy_consumption_indicator : null,
            'cruise_control' => $this->cruise_control_indicator !== null && $this->cruise_control_indicator !== '' 
                ? (float)$this->cruise_control_indicator : null,
            'video' => $this->video_indicator !== null && $this->video_indicator !== '' 
                ? (float)$this->video_indicator : null,
        ];
    }

    /**
     * Check if trip has driver assigned
     */
    public function hasDriver(): bool
    {
        return $this->driverno !== '';
    }

    /**
     * Check if trip has start coordinates
     */
    public function hasStartCoordinates(): bool
    {
        return $this->start_longitude !== null && 
               $this->start_longitude !== '' && 
               $this->start_latitude !== null && 
               $this->start_latitude !== '';
    }

    /**
     * Check if trip has end coordinates
     */
    public function hasEndCoordinates(): bool
    {
        return $this->end_longitude !== null && 
               $this->end_longitude !== '' && 
               $this->end_latitude !== null && 
               $this->end_latitude !== '';
    }

    /**
     * Calculate trip distance using coordinates (Haversine formula)
     * Returns distance in meters
     */
    public function getCoordinateDistance(): ?float
    {
        if (!$this->hasStartCoordinates() || !$this->hasEndCoordinates()) {
            return null;
        }

        $lat1 = $this->getStartLatitudeDegrees();
        $lon1 = $this->getStartLongitudeDegrees();
        $lat2 = $this->getEndLatitudeDegrees();
        $lon2 = $this->getEndLongitudeDegrees();

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
     * Get straight-line distance between start and end in kilometers
     */
    public function getCoordinateDistanceKm(): ?float
    {
        $meters = $this->getCoordinateDistance();
        return $meters !== null ? round($meters / 1000, 2) : null;
    }
}
