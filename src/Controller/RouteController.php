<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RouteController extends AbstractController
{
    #[Route('/route/generate/{id}', name: 'app_generate_routes', methods: ["POST"])]
    public function generate(\App\Entity\Route $route): Response
    {

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

        return $this->redirectToRoute('app_set', parameters: ["setId" => $route->getSet()?->getId()]);
    }
}
