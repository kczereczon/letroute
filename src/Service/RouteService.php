<?php

namespace App\Service;

use App\Interfaces\Car;
use App\Entity\Point;
use App\Interfaces\Coordinates;
use App\Models\Centroid;
use Doctrine\Common\Collections\Collection;

class RouteService
{

    public function __construct(private PointService $pointService)
    {
    }

    /**
     * @param Collection<Point> $points
     * @param Car $car
     * @return array<Point>
     * @throws \Exception
     */
    public function createRouteForCar(Collection &$points, Car $car): array {
        $route = [];
        $points = $this->pointService->sortPointsByDistance($points, $car->getCentroid());
        foreach ($points as $key => $point) {
            $points = $this->pointService->sortPointsByDistance($points, $car->getCentroid());

            if($car->canCarry($point->getWeight())) {
                $car->setCentroid($point);
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