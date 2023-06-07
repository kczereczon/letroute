<?php

namespace App\DistanceCalculator;

interface DistanceCalculatorInterface
{
    /**
     * @param \Doctrine\Common\Collections\Collection<int, \App\Entity\Point> $points
     * @return int Return integer in meters
     */
    public function calculateDistance(\Doctrine\Common\Collections\Collection $points): int;
}