<?php

namespace App\Tests\Repository;

use App\Entity\Car;
use App\Entity\Localization;
use App\Repository\CarRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CarRepositoryTest extends KernelTestCase
{

    protected function tearDown(): void
    {
        parent::tearDown();

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM App\Entity\Car as c')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Localization as l')->execute();
    }

    public function testSave(): void
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $localization = new Localization();
        $localization->setName('test');
        $localization->setLat(51.919438);
        $localization->setLon(19.145136);
        $localization->setType('START');

        $entityManager->persist($localization);
        $entityManager->flush();

        $carCount = count($entityManager->createQuery('SELECT c FROM App\Entity\Car c')->getResult());
        $this->assertSame(0, $carCount);

        $car = new Car();
        $car->setName('test');
        $car->setAverageFuelConsumption(10);
        $car->setAverageSpeed(60);
        $car->setMaxLoadWeight(3000);
        $car->setRegistrationNumber('RLU00XX');
        $car->setStartLocalization($localization);
        $car->setEndLocalization($localization);

        /** @var CarRepository $carRepository */
        $carRepository = $entityManager->getRepository(Car::class);

        $carRepository->save($car, true);

        $carCount = count($entityManager->createQuery('SELECT c FROM App\Entity\Car c')->getResult());

        $this->assertSame(1, $carCount);
    }
}
