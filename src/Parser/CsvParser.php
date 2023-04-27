<?php

namespace App\Parser;

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

        return $csv;
    }
}