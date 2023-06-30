<?php

namespace App\Tests\Repository;

use App\Entity\Route;
use App\Entity\Set;
use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RouteRepositoryTest extends KernelTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM App\Entity\Route as r')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Set as s')->execute();
    }

    public function testSave(): void
    {
        $kernel = self::bootKernel();

        /** @var RouteRepository $routeRepository */
        $routeRepository = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Route::class);

        $this->assertEquals(0, $routeRepository->count([]));

        $set = new Set();
        $set->setName('test');

        $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')->persist($set);
        $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')->flush();

        $route = new Route();
        $route->setName('test');
        $route->setDistance(100);
        $route->setColor('white');
        $route->setDuration(200);
        $route->setRouteData(['data' => 'test']);
        $route->setSet($set);

        $routeRepository->save($route, true);

        $this->assertEquals(1, $routeRepository->count([]));

        $fetchedRoute = $routeRepository->find($route->getId());

        $this->assertEquals($route->getId(), $fetchedRoute->getId());
        $this->assertEquals('test', $fetchedRoute->getName());
        $this->assertEquals(100, $fetchedRoute->getDistance());
        $this->assertEquals('white', $fetchedRoute->getColor());
        $this->assertEquals(200, $fetchedRoute->getDuration());
        $this->assertEquals(['data' => 'test'], $fetchedRoute->getRouteData());
        $this->assertEquals($set->getId(), $fetchedRoute->getSet()->getId());

        $this->assertNotNull($route->getId());
    }

    public function testRemove(): void
    {
        $kernel = self::bootKernel();

        /** @var RouteRepository $routeRepository */
        $routeRepository = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Route::class);

        $route = new Route();
        $route->setName('test');
        $route->setDistance(100);
        $route->setColor('white');
        $route->setDuration(200);
        $route->setRouteData(['data' => 'test']);

        $routeRepository->save($route, true);

        $this->assertEquals(1, $routeRepository->count([]));

        $routeRepository->remove($route, true);

        $this->assertEquals(0, $routeRepository->count([]));
    }
}
