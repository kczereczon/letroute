<?php

namespace App\Controller;

use App\Entity\Point;
use App\Entity\Set;
use App\Factory\FileParserFactory;
use App\Repository\PointRepository;
use App\Repository\RouteRepository;
use App\Repository\SetRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetController extends AbstractController
{
    private FileParserFactory $fileParserFactory;

    public function __construct(FileParserFactory $fileParserFactory)
    {
        $this->fileParserFactory = $fileParserFactory;
    }

    #[Route('/', name: 'app_set')]
    public function index(SetRepository $setRepository, RouteRepository $routeRepository, PointRepository $pointRepository, Request $request): Response
    {
        $sets = $setRepository->findAll();
        $points = [];
        $routes = [];
        $pointsWithoutRoutes = [];
        $route = null;

        $setId = $request->get('setId');

        if ($setId) {
            $set = $setRepository->find($setId);
            if ($set) {
                $routes = $set->getRoutes();
                $pointsWithoutRoutes = $pointRepository->getPointsWithoutRoute($set);
            }
        }

        $routeId = $request->get('routeId');

        if ($routeId) {
            $route = $routeRepository->find($routeId);
            if($route) {
                $points = $route->getPoints();
            }
        }

        return $this->render('set/index.html.twig', [
            'controller_name' => 'SetController',
            'sets' => $sets,
            'pointsWithoutRoutes' => $pointsWithoutRoutes,
            'route' => $route,
            'points' => $points,
            'routes' => $routes,
            'setId' => $setId,
            'routeId' => $routeId,
            "maximum_distance" => $request->get('maximum_distance'),
            "maximum_duration" => $request->get('maximum_duration'),
            "radius" => $request->get('radius')
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/set/create', name: 'app_set_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var File $file */
        $file = $request->files->get('points');
        $extension = $file->getClientOriginalExtension();

        $parser = $this->fileParserFactory->create($extension);
        $points = $parser->parse($file);

        $set = new Set();
        $set->setName("set - " . date('Y-m-d h:i:s'));
        $entityManager->persist($set);

        foreach ($points as $point) {
            $point->setSet($set);
            $entityManager->persist($point);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_set');
    }
}
