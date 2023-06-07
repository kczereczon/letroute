<?php

namespace App\Service;

use App\Domain\RouteServiceInterface;
use App\Entity\Route;
use App\Entity\Set;
use App\Interfaces\Coordinates;
use App\Interfaces\Point;
use App\Models\Car;
use App\Models\Centroid;
use App\Repository\PointRepository;
use App\RouteGenerator\RouteGeneratorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class RouteService implements RouteServiceInterface
{
    public Collection $cars;
    public float $maximumDistance;
    public float $maximumDuration;

    public function __construct(
        private RouteGeneratorInterface $routeGenerator,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function generateRoutes(Set $set): \Doctrine\Common\Collections\Collection
    {
        $routesPoints = $this->routeGenerator->generate(
            $set,
            new ArrayCollection([new Car('car', 1100, 0)]),
            20000,
            300000
        );

        $routes = new ArrayCollection();

        $i = 0;
        foreach ($routesPoints as $routePoints) {
            $route = new Route();
            $route->setColor('#' . dechex(random_int(0x000000, 0xFFFFFF)));
            $route->setName("R-" . sprintf("%'.04d\n", $i));
            $route->setSet($set);
            /** @var Point $point */
            foreach ($routePoints as $point) {
                $route->addPoint($point);
            }

            $i++;

            $routes[] = $route;

            $this->entityManager->persist($route);
        }

        $this->entityManager->flush();
        return $routes;
    }

    public function setCars(Collection $cars): RouteServiceInterface
    {
        $this->cars = $cars;
        return $this;
    }

    public function setMaximumDistance(float $distance): RouteServiceInterface
    {
        $this->maximumDistance = $distance;
        return $this;
    }

    public function setMaximumDuration(float $duration): RouteServiceInterface
    {
        $this->maximumDuration = $duration;
        return $this;
    }
}