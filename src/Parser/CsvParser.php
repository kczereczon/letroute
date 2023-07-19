<?php

namespace App\Parser;

use App\Entity\Point;
use Symfony\Component\HttpFoundation\File\File;

class CsvParser implements ParserInterface
{
    /**
     * @throws \Exception
     */
    public function parse(File $file): array
    {
        $fileStream = fopen($file->getRealPath(), 'rb');

        $headers = fgetcsv($fileStream);

        foreach (['name', 'lat', 'lon', 'weight'] as $required) {
            if(!in_array($required, $headers)) {
                throw new \RuntimeException("$required column is required");
            }
        }

        $points = [];

        $i = 0;
        while (($data = fgetcsv($fileStream, 1000)) !== FALSE) {
            $point = [];
            foreach ($headers as $index => $header) {
                $point[$header] = $data[$index];
            }
            $points[] = $point;
        }

        fclose($fileStream);

        $pointEntities = [];

        if(count($points) === 0) {
            throw new \RuntimeException("File cannot be empty");
        }

        foreach ($points as $point) {
            $pointEntity = new Point();
            $pointEntity->setName($point['name']);
            $pointEntity->setLat((float)$point['lat']);
            $pointEntity->setLon((float)$point['lon']);
            $pointEntity->setWeight((float)$point['weight']);
            $pointEntities[] = $pointEntity;
        }

        return $pointEntities;
    }
}