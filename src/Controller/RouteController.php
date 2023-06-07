<?php

namespace App\Controller;

use App\Models\Car;
use App\Repository\PointRepository;
use App\Repository\RouteRepository;
use App\Service\MapboxService;
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
        RouteService $pointService,
        RouteService $routeService,
        EntityManagerInterface $entityManager,
        MapboxService $mapboxService
    ): Response {
        $routeService->generateRoutes($set);
        return $this->redirectToRoute('app_set', parameters: ["setId" => $set->getId()]);
    }
}
