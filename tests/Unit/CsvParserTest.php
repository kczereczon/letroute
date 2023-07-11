<?php

uses(\PHPUnit\Framework\TestCase::class);

it('should return an array of points', function () {
    $csv = <<<CSV
name,lat,lon,weight
Point,59.123,19.312,300
Point2,59.123,19.312,400
CSV;

    $parser = new App\Parser\CsvParser();
    $array = $parser->parse($csv);
    expect($array)->toBeArray()->toHaveCount(2)
        ->and($array[0])->toBeInstanceOf(App\Entity\Point::class)
        ->and($array[0]->getName())->toBe('Point')
        ->and($array[0]->getLat())->toBe(59.123)
        ->and($array[0]->getLon())->toBe(19.312)
        ->and($array[0]->getWeight())->toBe(300.0)
        ->and($array[1])->toBeInstanceOf(App\Entity\Point::class)
        ->and($array[1]->getName())->toBe('Point2')
        ->and($array[1]->getLat())->toBe(59.123)
        ->and($array[1]->getLon())->toBe(19.312)
        ->and($array[1]->getWeight())->toBe(400.0);
});
