<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetController extends AbstractController
{
    #[Route('/set', name: 'app_set')]
    public function index(): Response
    {
        return $this->render('set/index.html.twig', [
            'controller_name' => 'SetController',
        ]);
    }

    #[Route('/set/create', name: 'app_set_create', methods: ['POST'])]
    public function create(): Response
    {

    }
}
