<?php

class DefaultDistanceCalculator implements DistanceCalculatorInterface
{

    public function calculateDistance(\Doctrine\Common\Collections\Collection $points): int
    {
        while ($points->count() )
        $pointA = $points->current();
        $pointB = $points->next();
    }

    private function coordinateToMeters(float $value): int
    {

    }
}