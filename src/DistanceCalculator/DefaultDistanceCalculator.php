<?php

namespace App\DistanceCalculator;

use App\Interfaces\Coordinates;

class DefaultDistanceCalculator implements DistanceCalculatorInterface
{

    public function calculateDistance(
        \Doctrine\Common\Collections\Collection $points,
        Coordinates $startPoint,
        Coordinates $endPoint
    ): int {

        $distance = 0;

        $distance += $this->calculateDistanceBetweenCords($startPoint, $points->first());

        for ($i = 1; $i < $points->count(); $i++) {
            $pointA = $points->get($i);
            $pointB = $points->get($i - 1);

            $distance += $this->calculateDistanceBetweenCords($pointA, $pointB);
        }

        $distance += $this->calculateDistanceBetweenCords($endPoint, $points->last());

        return $distance;
    }

    protected function calculateDistanceBetweenCords(Coordinates $coord1, Coordinates $coord2): int
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $lat1Rad = deg2rad($coord1->getX());
        $lon1Rad = deg2rad($coord1->getY());
        $lat2Rad = deg2rad($coord2->getX());
        $lon2Rad = deg2rad($coord2->getY());

        $deltaLat = $lat2Rad - $lat1Rad;
        $deltaLon = $lon2Rad - $lon1Rad;

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return (int) ($earthRadius * $c);
    }
}
