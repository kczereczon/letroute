<?php

namespace App\RouteGenerator;

use Doctrine\Common\Collections\Collection;

interface RouteGeneratorInterface
{
    public function generate(
        \App\Entity\Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance
    ): \Doctrine\Common\Collections\Collection;
}