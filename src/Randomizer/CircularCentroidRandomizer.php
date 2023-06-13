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
        $angle = random_int(0, 359) * (M_PI / 180);

        // Calculate the coordinates of the point on the circle
        $x = $center->getX() + $radius * cos($angle);
        $y = $center->getY() + $radius * sin($angle);

        return new Centroid($x, $y);
    }
}