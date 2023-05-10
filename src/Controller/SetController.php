<?php

namespace App\Controller;

use App\Entity\Point;
use App\Entity\Set;
use App\Factory\FileParserFactory;
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

    #[Route('/set', name: 'app_set')]
    public function index(SetRepository $setRepository, RouteRepository $routeRepository, Request $request): Response
    {
        $sets = $setRepository->findAll();
        $points = [];
        $routes = [];

        $setId = $request->get('setId');

        if ($setId) {
            $set = $setRepository->find($setId);
            if ($set) {
                $routes = $set->getRoutes();
                $points = $set->getPoints();
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
            'points' => $points,
            'routes' => $routes,
            'setId' => $setId,
            'routeId' => $routeId
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
        $extension = $file->guessExtension();

        $parser = $this->fileParserFactory->create($extension);
        $points = $parser->parse($file->getContent());

        $set = new Set();
        $set->setName("test set - " . date('Y-m-d h:i:s'));
        $entityManager->persist($set);

        foreach ($points as $point) {
            $pointEntity = new Point();
            $pointEntity->setName($point['name']);
            $pointEntity->setLat($point['lat']);
            $pointEntity->setLon($point['lon']);
            $pointEntity->setWeight($point['weight']);
            $pointEntity->setSet($set);
            $entityManager->persist($pointEntity);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_set');
    }
}
