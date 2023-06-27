<?php

namespace App\DurationCalculator;

use App\DistanceCalculator\DistanceCalculatorInterface;
use App\Interfaces\Coordinates;

class DefaultDurationCalculator implements DurationCalculatorInterface
{

    public function __construct(private readonly DistanceCalculatorInterface $distanceCalculator)
    {
    }

    public function calculateDuration(
        \Doctrine\Common\Collections\Collection $points,
        Coordinates $startPoint,
        Coordinates $endPoint,
        int $averageKilometersPerHour
    ): int {

        if($averageKilometersPerHour < 1) {
            return 0;
        }

        $metersPerHour = $averageKilometersPerHour * 1000;

        $distance = $this->distanceCalculator->calculateDistance($points, $startPoint, $endPoint);
        return (int) ($distance / $metersPerHour);
    }
}
