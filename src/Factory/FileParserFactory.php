<?php

namespace App\Factory;

use App\Parser\CsvParser;
use App\Parser\ParserInterface;

class FileParserFactory
{
    private CsvParser $csvParser;

    public function __construct(CsvParser $csvParser)
    {
        $this->csvParser = $csvParser;
    }

    public function create(string $extension): ParserInterface {
        return match ($extension) {
            "csv" => $this->csvParser
        };
    }
}