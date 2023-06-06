<?php

class DefaultDistanceCalculator implements DistanceCalculatorInterface
{

    public function calculateDistance(\Doctrine\Common\Collections\Collection $points): int
    {
        if($points->count() === 1) {
            return 0;
        }

        $distance = 0;

        for ($i = 1; $i < $points->count(); $i++) {
            $pointA = $points->get($i-1);
            $pointB = $points->get($i-2);

            $distance += $this->calculateDistanceBetweenCords($pointA, $pointB);
        }

        return $distance;
    }

    private function calculateDistanceBetweenCords(\App\Interfaces\Coordinates $coord1, \App\Interfaces\Coordinates $coord2): int
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

        return (int)($earthRadius * $c);
    }
}