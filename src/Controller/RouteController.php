<?php

namespace App\Controller;

use App\Models\Car;
use App\Repository\PointRepository;
use App\Repository\RouteRepository;
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
        RouteRepository $routeRepository,
        PointService $pointService,
        RouteService $routeService,
        EntityManagerInterface $entityManager
    ): Response {
        $routes = $set->getRoutes();
        $points = $set->getPoints();

        foreach ($routes as $route) {
            $set->getRoutes()->removeElement($route);
            $entityManager->remove($route);
        }

        foreach($points as $point) {
            $point->setRoute(null);
            $entityManager->persist($point);
        }

        $entityManager->flush();

        $points = $pointRepository->getPointsWithoutRoute($set);

        $triesCount = 0;

        while ($points->count() > 0 && $triesCount < 3) {
            $car = new Car("car1", 1000, 0);
            $car->setCentroid($pointService->getRandomCentroid($set));
            $routePoints = $routeService->createRouteForCar($points, $car);

            if (!count($routePoints)) {
                $triesCount++;
                continue;
            }

            $route = new \App\Entity\Route();
            foreach ($routePoints as $routePoint) {
                $route->setName($car->getName() . ' - route');
                $route->setColor(sprintf('%06X', random_int(0, 0xFFFFFF)));
                $route->addPoint($routePoint);
                $route->setSet($set);
                $entityManager->persist($route);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_set', parameters: ["setId" => $set->getId()]);
    }
}
