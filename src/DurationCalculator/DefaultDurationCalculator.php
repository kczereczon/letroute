<?php

namespace App\DurationCalculator;

use App\DistanceCalculator\DistanceCalculatorInterface;
use App\Interfaces\Coordinates;

class DefaultDurationCalculator implements DurationCalculatorInterface
{
    const AVG_METERS_PER_HOUR = 60000;

    public function __construct(private DistanceCalculatorInterface $distanceCalculator)
    {
    }

    public function calculateDuration(\Doctrine\Common\Collections\Collection $points, Coordinates $startPoint, Coordinates $endPoint): int
    {
        $metersPerSecond = self::AVG_METERS_PER_HOUR / 3600;

        $distance = $this->distanceCalculator->calculateDistance($points, $startPoint, $endPoint);
        return (int)($distance / $metersPerSecond);
    }
}