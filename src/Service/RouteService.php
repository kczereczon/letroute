<?php

namespace App\Service;

use App\Interfaces\Car;
use App\Interfaces\Point;
use Doctrine\Common\Collections\Collection;

class RouteService
{
    /**
     * @param Collection<Point> $points
     * @param Car $car
     * @return array<Point>
     */
    public function createRouteForCar(Collection $points, Car $car): array {
        $route = [];
        foreach ($points as $key => $point) {
            if($car->canCarry($point->getWeight())) {
                $car->addWeight($point->getWeight());
                $route[] = $point;
                $points->remove($key);
            }
        }

        return $route;
    }
}