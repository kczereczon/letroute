<?php

namespace App\Tests\Repository;

use App\Entity\Route;
use App\Entity\Set;
use App\Repository\SetRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SetRepositoryTest extends KernelTestCase
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

        /** @var SetRepository $setRepository */
        $setRepository = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Set::class);

        $this->assertEquals(0, $setRepository->count([]));

        $set = new Set();
        $set->setName('test');

        $setRepository->save($set, true);

        $this->assertEquals(1, $setRepository->count([]));
    }

    public function testRemove(): void
    {
        $kernel = self::bootKernel();

        /** @var SetRepository $setRepository */
        $setRepository = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Set::class);

        $set = new Set();
        $set->setName('test');

        $setRepository->save($set, true);

        $this->assertEquals(1, $setRepository->count([]));

        $setRepository->remove($set, true);
    }

    public function testRemoveRoutes(): void
    {
        $kernel = self::bootKernel();

        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        /** @var SetRepository $setRepository */
        $setRepository = $entityManager
            ->getRepository(Set::class);

        $set = new Set();
        $set->setName('test');

        $setRepository->save($set, true);

        $this->assertEquals(1, $setRepository->count([]));

        for ($i = 0; $i < 10; $i++) {
            $route = new Route();
            $route->setName('test');
            $route->setDistance(100);
            $route->setColor('white');
            $route->setDuration(200);
            $route->setRouteData(['data' => 'test']);
            $route->setSet($set);

            $entityManager->persist($route);
            $entityManager->flush();
        }

        $entityManager->refresh($set);

        $this->assertEquals(10, $set->getRoutes()->count());

        $setRepository->removeRoutes($set, true);

        $entityManager->refresh($set);

        $this->assertEquals(0, $set->getRoutes()->count());
    }
}
