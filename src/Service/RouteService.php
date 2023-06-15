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
    public function __construct(
        private RouteGeneratorInterface $routeGenerator,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function generateRoutes(
        Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance,
        float $radius,
        Coordinates $startCentroid
    ): \Doctrine\Common\Collections\Collection {
        $routes = $this->routeGenerator->generate(
            $set,
            $cars,
            $maximumDuration,
            $maximumDistance,
            $radius,
            $startCentroid
        );

        foreach ($routes as $route) {
            $this->entityManager->persist($route);
        }

        $this->entityManager->flush();
        return $routes;
    }
}