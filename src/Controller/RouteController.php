<?php

namespace App\Controller;

use App\Models\Car;
use App\Repository\PointRepository;
use App\Service\PointService;
use App\Service\RouteService;
use Doctrine\ORM\EntityManagerInterface;
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
        PointService $pointService,
        RouteService $routeService,
        EntityManagerInterface $entityManager
    ): Response {
        $points = $pointRepository->getPointsWithoutRoute($set);

        $cars = [
            new Car("car1", 1000, 0),
            new Car("car2", 1000, 0),
            new Car("car3", 1000, 0),
            new Car("car4", 1000, 0),
            new Car("car5", 1000, 0),
            new Car("car6", 1000, 0),
            new Car("car7", 1000, 0),
            new Car("car8", 1000, 0),
            new Car("car9", 1000, 0),
            new Car("car10", 1000, 0),
        ];

        foreach ($cars as $car) {
            $car->setCentroid($pointService->getRandomCentroid($set));
            $routePoints = $routeService->createRouteForCar($points, $car);

            $route = new \App\Entity\Route();
            foreach ($routePoints as $routePoint) {
                $route->setName($car->getName() . ' - route');
                $route->setColor(dechex(random_int(0,10000000)));
                $route->addPoint($routePoint);
                $route->setSet($set);
                $entityManager->persist($route);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_set', parameters: ["setId" => $set->getId()]);
    }
}
