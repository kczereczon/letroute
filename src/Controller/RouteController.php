<?php

namespace App\Controller;

use App\Models\Car;
use App\Models\Centroid;
use App\Repository\PointRepository;
use App\Repository\RouteRepository;
use App\Repository\SetRepository;
use App\Service\MapboxService;
use App\Service\RouteService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        Request $request,
        \App\Entity\Set $set,
        RouteService $routeService,
        SetRepository $setRepository
    ): Response {
        $setRepository->removeRoutes($set, true);

        $routeService->generateRoutes(
            $set,
            new ArrayCollection([new Car('car', 2100, 0)]),
            $request->get('maximum_duration'),
            $request->get('maximum_distance'),
            $request->get('radius'),
            new Centroid(19.145136, 51.919438)
        );

        return $this->redirectToRoute('app_set', parameters: [
            "setId" => $set->getId(),
            "maximum_distance" => $request->get('maximum_distance'),
            "maximum_duration" => $request->get('maximum_duration'),
            "radius" => $request->get('radius')
        ],);
    }
}
