<?php

beforeEach(function () {
//    $this->clearDatabase();
});

it('creates set with forwarded file', function () {

    $client = static::createClient();
    $crawler = $client->request('POST', '/set/create', [
        'name' => 'testowy zbiór',
        'file' => 'testowy plik',
    ]);

    $this->assertResponseIsSuccessful();
    $this->assertSelectorTextContains('body > div.flex.min-h-full > div.w-1\/2.bg-white.p-6 > div.flex.flex-row.w-full.max-w-full.gap-2.mb-2 > div > div', 'Nowy zbiór');
    $this->assertSelectorExists('#form_name');
    $this->assertSelectorExists('#form_file');
    $this->assertSelectorExists('#form_save');
});