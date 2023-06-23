<?php

namespace App\Factory;

use App\DistanceCalculator\DistanceCalculatorInterface;
use App\Domain\RouteFactoryInterface;
use App\DurationCalculator\DurationCalculatorInterface;
use App\Entity\Route;
use App\Entity\Set;
use App\Interfaces\Coordinates;
use App\Interfaces\Point;
use App\Repository\RouteRepository;
use App\RouteGenerator\RouteGeneratorInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;

class RouteFactory implements RouteFactoryInterface
{
    public function __construct(private DistanceCalculatorInterface $distanceCalculator, private DurationCalculatorInterface $durationCalculator)
    {
    }

    public function create(Collection $routePoints, Set $set, int $number, Coordinates $startPoint, Coordinates $endPoint): Route
    {
        $route = new Route();
        $color = dechex(random_int(0x000000, 0xFFFFFF));
        $route->setColor($color);
        $route->setName("R-" . sprintf("%'.04d\n", $number));
        $route->setSet($set);
        $route->setDuration($this->durationCalculator->calculateDuration($routePoints, $startPoint, $endPoint, 60000));
        $route->setDistance($this->distanceCalculator->calculateDistance($routePoints, $startPoint, $endPoint));

        /** @var Point $point */
        foreach ($routePoints as $point) {
            $route->addPoint($point);
        }

        return $route;
    }
}
