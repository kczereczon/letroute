<?php

namespace App\Tests\Repository;

use App\Entity\Car;
use App\Entity\Localization;
use App\Repository\CarRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
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

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        $this->localization = new Localization();
        $this->localization->setName('test');
        $this->localization->setLat(51.919438);
        $this->localization->setLon(19.145136);
        $this->localization->setType('START');

        $this->entityManager->persist($this->localization);
        $this->entityManager->flush();

        $this->car = new Car();
        $this->car->setName('test');
        $this->car->setAverageFuelConsumption(10);
        $this->car->setAverageSpeed(60);
        $this->car->setMaxLoadWeight(3000);
        $this->car->setRegistrationNumber('RLU00XX');
        $this->car->setStartLocalization($this->localization);
        $this->car->setEndLocalization($this->localization);
    }

    public function testSave(): void
    {
        /** @var CarRepository $carRepository */
        $carRepository = $this->entityManager->getRepository(Car::class);

        $carRepository->save($this->car, true);

        $carCount = count($this->entityManager->createQuery('SELECT c FROM App\Entity\Car c')->getResult());

        $this->assertSame(1, $carCount);
    }

    public function testRemoveCar(): void
    {
        /** @var CarRepository $carRepository */
        $carRepository = $this->entityManager->getRepository(Car::class);

        $carRepository->save($this->car, true);

        $carCount = count($this->entityManager->createQuery('SELECT c FROM App\Entity\Car c')->getResult());

        $this->assertSame(1, $carCount);

        $carRepository->remove($this->car, true);

        $carCount = count($this->entityManager->createQuery('SELECT c FROM App\Entity\Car c')->getResult());

        $this->assertSame(0, $carCount);
    }
}
