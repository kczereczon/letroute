<?php

namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    protected function tearDown(): void
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine.orm.default_entity_manager');
        $entityManager->createQuery('DELETE FROM App\Entity\Car as c')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\User as u')->execute();
        parent::tearDown();
    }

    public function testGetCarRouteUnautorized(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car');

        self::assertResponseRedirects('http://localhost/login');
    }

    public function testGetCarEditRouteUnautorized(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car/edit');

        self::assertResponseRedirects('http://localhost/login');
    }

    public function testGetCarCreateRouteUnautorized(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car/create');

        self::assertResponseRedirects('http://localhost/login');
    }

    public function testGetCarRoute(): void
    {
        $client = static::createClient();

        $user = new User();
        $user->setEmail('test@email.com');
        $user->setPassword('test');
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $client->loginUser($user);
        $crawler = $client->request('GET', '/car');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('div.w-1\/2.flex-auto', 'Samochody');
    }

    public function testGetCarEditRoute(): void
    {
        $client = static::createClient();


        $user = new User();
        $user->setEmail('test@email.com');
        $user->setPassword('test');
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $client->loginUser($user);

        $crawler = $client->request('GET', '/car/edit');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('div.w-1\/2.flex-auto', 'Samochody');
    }

    public function testGetCarCreateRoute(): void
    {
        $client = static::createClient();


        $user = new User();
        $user->setEmail('test@email.com');
        $user->setPassword('test');
        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $client->loginUser($user);

        $crawler = $client->request('GET', '/car/create');

        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains(
            'body > div.flex.min-h-full > div.w-1\/2.bg-white.p-6 > div.flex.flex-row.w-full.max-w-full.gap-2.mb-2 > div > div',
            'Nowy samochód'
        );
        self::assertSelectorExists('#form_name');
        self::assertSelectorExists('#form_maxLoadWeight');
        self::assertSelectorExists('#form_registrationNumber');
        self::assertSelectorExists('#form_averageSpeed');
        self::assertSelectorExists('#form_averageFuelConsumption');
        self::assertSelectorExists('#form_save');
    }
}
