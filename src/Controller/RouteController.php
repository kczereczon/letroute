<?php

namespace App\Controller;

use App\Repository\PointRepository;
use App\Service\PointService;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    #[Route('/route/generate/{id}', name: 'app_generate_routes', methods: ["POST"])]
    public function generate(
        \App\Entity\Set $set,
        PointRepository $pointRepository,
        PointService $pointService
    ): Response {
        $points = $set->getPoints();

        $cars = [
            new \Car("car1", 1000, 0),
            new \Car("car2", 1000, 0),
            new \Car("car3", 1000, 0),
            new \Car("car4", 1000, 0),
            new \Car("car5", 1000, 0),
            new \Car("car6", 1000, 0),
            new \Car("car7", 1000, 0),
            new \Car("car8", 1000, 0),
            new \Car("car9", 1000, 0),
            new \Car("car10", 1000, 0),
        ];

        $biggestLat = $pointRepository->findBiggestLat($set);
        $biggestLon = $pointRepository->findBiggestLon($set);
        $smallestLat = $pointRepository->findSmallestLat($set);
        $smallestLon = $pointRepository->findSmallestLon($set);

        foreach ($cars as $car) {
            $x = random_int($smallestLon->getLon() * 1000, $biggestLon->getLon() * 1000) / 1000;
            $y = random_int($smallestLat->getLon() * 1000, $biggestLat->getLon() * 1000) / 1000;

            $car->getCentroid()->setX($x);
            $car->getCentroid()->setY($y);


        }


        return $this->redirectToRoute('app_set', parameters: ["setId" => $set->getId()]);
    }
}
