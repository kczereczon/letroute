<?php

namespace App\Tests\Factory;

use App\Factory\FileParserFactory;
use App\Parser\CsvParser;
use PHPUnit\Framework\TestCase;

class FileParserFactoryTest extends TestCase
{
    /**
     * @covers \App\Factory\FileParserFactory::create
     * @covers \App\Factory\FileParserFactory::__construct
     */
    public function testCsvFileParserCreating(): void
    {
        $csvParser = $this->createMock(CsvParser::class);

        $fileParser = new FileParserFactory($csvParser);
        $this->assertInstanceOf(FileParserFactory::class, $fileParser);

        $parser = $fileParser->create("csv");

        $this->assertInstanceOf(CsvParser::class, $parser);
    }
}
