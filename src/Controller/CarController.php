<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }

    #[Route('/car/edit', name: 'app_car_edit')]
    public function edit(): Response
    {
        return $this->render('car/edit.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }

    #[Route('/car/create', name: 'app_car_create')]
    public function create(): Response
    {
        $car = new Car();


        $form = $this->createFormBuilder($car)
            ->add('name', TextType::class)
            ->add('maxLoadWeight', IntegerType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        return $this->render('car/create.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
}
