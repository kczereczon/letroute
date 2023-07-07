<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarControllerTest extends WebTestCase
{
    public function testGetCarRoute(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.w-1\/2.flex-auto', 'Samochody');
    }

    public function testGetCarEditRoute(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.w-1\/2.flex-auto', 'Samochody');
    }

    public function testGetCarCreateRoute(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/car/create');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body > div.flex.min-h-full > div.w-1\/2.bg-white.p-6 > div.flex.flex-row.w-full.max-w-full.gap-2.mb-2 > div > div', 'Nowy samochód');
        $this->assertSelectorExists('#form_name');
        $this->assertSelectorExists('#form_maxLoadWeight');
        $this->assertSelectorExists('#form_registrationNumber');
        $this->assertSelectorExists('#form_averageSpeed');
        $this->assertSelectorExists('#form_averageFuelConsumption');
        $this->assertSelectorExists('#form_save');
    }
}
