<?php

namespace App\Parser;

use App\Entity\Point;

interface ParserInterface
{
    /** @return Point[] */
    public function parse(string $data): array;
}