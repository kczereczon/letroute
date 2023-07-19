<?php

namespace App\Parser;

use App\Entity\Point;

class CsvParser implements ParserInterface
{
    /**
     * @throws \Exception
     */
    public function parse(string $data): array
    {

        $explodedString = preg_split('/\R/', $data);

        iconv(mb_detect_encoding($explodedString, mb_detect_order(), true), "UTF-8", $text);
        $points = array_map('str_getcsv', $explodedString);
        array_walk($points, function(&$a) use ($points) {
            $a = array_combine($points[0], $a);
        });
        array_shift($points);

        $pointEntities = [];

        if(count($points) === 0) {
            throw new \RuntimeException("File cannot be empty");
        }

        foreach (['name', 'lat', 'lon', 'weight'] as $required) {
            if(!isset($points[0][$required])) {
                throw new \RuntimeException("$required column is required");
            }
        }

        foreach ($points as $point) {
            $pointEntity = new Point();
            $pointEntity->setName($point['name']);
            $pointEntity->setLat($point['lat']);
            $pointEntity->setLon($point['lon']);
            $pointEntity->setWeight($point['weight']);
            $pointEntities[] = $pointEntity;
        }



        return $pointEntities;
    }
}