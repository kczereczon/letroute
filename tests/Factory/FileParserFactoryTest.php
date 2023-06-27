<?php

namespace App\Tests\Factory;

use App\Factory\FileParserFactory;
use App\Parser\CsvParser;
use PHPUnit\Framework\TestCase;

class FileParserFactoryTest extends TestCase
{

    /** @covers FileParserFactory::create  */
    public function testCsvFileParserCreating(): void
    {
        $csvParser = $this->createMock(CsvParser::class);

        $fileParser = new FileParserFactory($csvParser);
        $parser = $fileParser->create("csv");

        $this->assertInstanceOf(CsvParser::class, $parser);
    }
}
