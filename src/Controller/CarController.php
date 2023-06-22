<?php

namespace App\Controller;

use App\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('name', TextType::class, [
                'label' => "Nazwa robocza pojazdu"
            ])
            ->add('maxLoadWeight', IntegerType::class, [
                'label' => "Maksymalna ładowność pojazdu (kg)",
                'help' => "Ta wartość jest wykorzystywana podczas tworzenia tras."
            ])
            ->add(
                'registrationNumber',
                TextType::class,
                [
                    'required' => false,
                    'label' => "Numer rejestracyjny pojazdu",
                ]
            )
            ->add('averageSpeed', TextType::class, [
                'required' => false,
                'label' => "Średnia prędkośc pojazdu (km/h)",
                'help' => "Ta wartość pomaga podczas tworzenia tras, jeśli puste używana wartość to 60 km/h."
            ])
            ->add(
                'averageFuelConsumption',
                TextType::class,
                [
                    'required' => false,
                    'label' => "Średnie spalanie pojazdu (L/100km)",
                    'help' => "Ta wartość pomaga w wyliczaniu statystyk, jeśli puste używana wartość to 10L/100km."
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Utwórz samochód'])
            ->getForm();

        return $this->render('car/create.html.twig', [
            'form' => $form
        ]);
    }
}
