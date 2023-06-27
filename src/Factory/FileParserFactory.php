<?php

namespace App\Factory;

use App\Parser\CsvParser;
use App\Parser\ParserInterface;

class FileParserFactory
{
    public function __construct(private CsvParser $csvParser)
    {
    }

    public function create(string $extension): ParserInterface {
        return match ($extension) {
            "csv" => $this->csvParser
        };
    }
}