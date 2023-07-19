<?php

uses(\PHPUnit\Framework\TestCase::class);

it('should return an array of points', function () {
    $file = new \Symfony\Component\HttpFoundation\File\File(__DIR__ . '/../TestFiles/testSet.csv');

    $parser = new App\Parser\CsvParser();
    $array = $parser->parse($file);
    expect($array)->toBeArray()->toHaveCount(3)
        ->and($array[0])->toBeInstanceOf(App\Entity\Point::class)
        ->and($array[0]->getName())->toBe('Point')
        ->and($array[0]->getLat())->toBe(59.123)
        ->and($array[0]->getLon())->toBe(19.312)
        ->and($array[0]->getWeight())->toBe(300.0)
        ->and($array[1])->toBeInstanceOf(App\Entity\Point::class)
        ->and($array[1]->getName())->toBe('Point2')
        ->and($array[1]->getLat())->toBe(59.123)
        ->and($array[1]->getLon())->toBe(19.312)
        ->and($array[1]->getWeight())->toBe(400.0)
        ->and($array[2])->toBeInstanceOf(App\Entity\Point::class)
        ->and($array[2]->getName())->toBe('Grudziądz')
        ->and($array[2]->getLat())->toBe(53.483)
        ->and($array[2]->getLon())->toBe(18.766)
        ->and($array[2]->getWeight())->toBe(500.0);
});
