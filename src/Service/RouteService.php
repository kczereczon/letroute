<?php

namespace App\Service;

use App\Interfaces\Car;
use App\Entity\Point;
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

            if($car->getCurrentWeight() >= $car->getAllowedWeight() * 0.8) {
                break;
            }
        }

        return $route;
    }
}