<?php

namespace App\Randomizer;

use App\Interfaces\Coordinates;
use App\Models\Centroid;

class CircularCentroidRandomizer implements \App\Domain\CentroidRandomizerInterface
{
    /**
     * @throws \Exception
     */
    public function getRandomCentroid(Coordinates $center, float $radius): Coordinates
    {

        $radius = $radius / 111300;

        $w = $radius * sqrt(random_int(0, 10) / 10);
        $t = 2 * M_PI * (random_int(0, 10) / 10);
        $x = $w * cos($t);
        $y = $w * sin($t);

        $x = $x / cos($center->getY());

        return new Centroid($center->getX() + $x, $center->getY() + $y);
    }
}