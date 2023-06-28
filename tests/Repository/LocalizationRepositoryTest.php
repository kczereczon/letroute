<?php

namespace App\Tests\Repository;

use App\Entity\Car;
use App\Entity\Localization;
use App\Repository\LocalizationRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LocalizationRepositoryTest extends KernelTestCase
{

    protected function tearDown(): void
    {
        parent::tearDown();

        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM App\Entity\Localization as l')->execute();
    }

    public function testSave(): void
    {
        $kernel = self::bootKernel();

        $localization = new Localization();
        $localization->setName('test');
        $localization->setLat(51.919438);
        $localization->setLon(19.145136);
        $localization->setType('START');

        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        /** @var LocalizationRepository $localizationRepository */
        $localizationRepository = $entityManager->getRepository(Localization::class);
        $localizationRepository->save($localization, true);

        $localizationFromDatabase = $entityManager->createQuery('SELECT l FROM App\Entity\Localization l WHERE l.id = :id')
            ->setParameter('id', $localization->getId())
            ->getSingleResult();

        $this->assertNotNull($localizationFromDatabase);
        $this->assertEquals($localization->getId(), $localizationFromDatabase->getId());
        $this->assertEquals($localization->getName(), $localizationFromDatabase->getName());
        $this->assertEquals($localization->getLat(), $localizationFromDatabase->getLat());
        $this->assertEquals($localization->getLon(), $localizationFromDatabase->getLon());
        $this->assertEquals($localization->getType(), $localizationFromDatabase->getType());
    }

    public function testRemove(): void
    {
        $kernel = self::bootKernel();

        $localization = new Localization();
        $localization->setName('test');
        $localization->setLat(51.919438);
        $localization->setLon(19.145136);
        $localization->setType('START');

        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');

        /** @var LocalizationRepository $localizationRepository */
        $localizationRepository = $entityManager->getRepository(Localization::class);
        $localizationRepository->save($localization, true);
        $localizationRepository->remove($localization, true);

        $localizationFromDatabase = $entityManager->createQuery('SELECT l FROM App\Entity\Localization l WHERE l.id = :id')
            ->setParameter('id', $localization->getId())
            ->getOneOrNullResult();

        $this->assertNull($localizationFromDatabase);
    }
}
