<?php

namespace App\Tests\Core;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class FeatureTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    private EntityManager $entityManager;

    protected function clearDatabase(): void
    {
        $this->entityManager->createQuery('DELETE FROM App\Entity\Point as p')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Route as r')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Set as s')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Localization as l')->execute();
        $this->entityManager->createQuery('DELETE FROM App\Entity\Car as c')->execute();
    }
}