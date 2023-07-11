<?php

namespace App\Parser;

use App\Entity\Point;

class CsvParser implements ParserInterface
{
    public function parse(string $data): array
    {
        $explodedString = preg_split('/\R/', $data);
        $csv = array_map('str_getcsv', $explodedString);
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);

        $points = [];

        foreach ($csv as $point) {
            $pointEntity = new Point();
            $pointEntity->setName($point['name']);
            $pointEntity->setLat($point['lat']);
            $pointEntity->setLon($point['lon']);
            $pointEntity->setWeight($point['weight']);
            $points[] = $pointEntity;
        }

        return $points;
    }
}