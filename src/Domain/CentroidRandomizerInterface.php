<?php

namespace App\Domain;

use App\Interfaces\Coordinates;

interface CentroidRandomizerInterface
{
    public function getRandomCentroid(Coordinates $center, float $radius): Coordinates;
}