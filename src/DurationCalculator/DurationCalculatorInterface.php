<?php

namespace App\DurationCalculator;

use App\Interfaces\Coordinates;

interface DurationCalculatorInterface
{

    /**
     * @param \Doctrine\Common\Collections\Collection<int, \App\Entity\Point> $points
     * @return int Duration in seconds
     */
    public function calculateDuration(\Doctrine\Common\Collections\Collection $points, Coordinates $startPoint, Coordinates $endPoint): int;
}