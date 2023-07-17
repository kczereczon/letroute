<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SetControllerTest extends WebTestCase
{
    public function testUpdatingFile(): void
    {
        $uploadedFile = new UploadedFile(
            dirname(__DIR__) . '/TestFiles/testSet.csv',
            'testSet.csv',
            'text/csv',
            null,
        );

        $client = static::createClient();
        $crawler = $client->request('POST', '/set/create', [
            'headers' => ['Content-Type' => 'multipart/form-data'],
        ],
        [
            'points' => $uploadedFile
        ]);

        self::assertResponseRedirects('/set');
        self::assertSelectorExists('a.set');
    }
}
