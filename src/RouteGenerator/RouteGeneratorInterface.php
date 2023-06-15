<?php

namespace App\RouteGenerator;

use App\Interfaces\Coordinates;
use Doctrine\Common\Collections\Collection;

interface RouteGeneratorInterface
{
    public function generate(
        \App\Entity\Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance,
        float $radius,
        Coordinates $startCentroid
    ): \Doctrine\Common\Collections\Collection;
}