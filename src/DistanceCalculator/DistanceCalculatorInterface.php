<?php

namespace App\DistanceCalculator;

use App\Interfaces\Coordinates;

interface DistanceCalculatorInterface
{
    /**
     * @param \Doctrine\Common\Collections\Collection<int, \App\Entity\Point> $points
     * @return int Return integer in meters
     */
    public function calculateDistance(\Doctrine\Common\Collections\Collection $points, Coordinates $startPoint, Coordinates $endPoint): int;
}