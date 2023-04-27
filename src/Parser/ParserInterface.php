<?php

namespace App\Parser;

interface ParserInterface
{
    public function parse(String $data): array;
}