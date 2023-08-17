<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SetControllerTest extends WebTestCase
{
    public ?KernelBrowser $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        $kernel = $this->client->getKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM App\Entity\Point as p')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Route as r')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Set as s')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\User as u')->execute();
        parent::tearDown();
    }

    public function testUpdatingFileUnauthorized(): void
    {
        $uploadedFile = new UploadedFile(
            dirname(__DIR__) . '/TestFiles/testSet.csv',
            'testSet.csv',
            'text/csv',
            null,
        );


        $crawler = $this->client->request('POST', '/set/create', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
        ],
        [
            'points' => $uploadedFile
        ]);

        self::assertResponseRedirects('http://localhost/login');
    }

    public function testUpdatingFileAuthorized(): void
    {
        $user = new User();
        $user->setEmail('test@email.com');
        $user->setPassword('test');
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $uploadedFile = new UploadedFile(
            dirname(__DIR__) . '/TestFiles/testSet.csv',
            'testSet.csv',
            'text/csv',
            null,
        );

        $this->client->loginUser($user);
        $crawler = $this->client->request('POST', '/set/create', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
        ],
            [
                'points' => $uploadedFile
            ]);

        self::assertResponseRedirects('/set');
    }
}
