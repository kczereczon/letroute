<?php

interface DurationCalculatorInterface
{

    /**
     * @param \Doctrine\Common\Collections\Collection<int, \App\Entity\Point> $points
     * @return int Duration in seconds
     */
    public function calculateDuration(\Doctrine\Common\Collections\Collection $points): int;
}