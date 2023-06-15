<?php

namespace App\Domain;

use App\Entity\Set;
use App\Interfaces\Coordinates;
use Doctrine\Common\Collections\Collection;

interface RouteServiceInterface
{
    public function generateRoutes(
        Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance,
        float $radius,
        Coordinates $startCentroid
    ): \Doctrine\Common\Collections\Collection;
}