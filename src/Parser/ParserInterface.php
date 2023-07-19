<?php

namespace App\Parser;

use App\Entity\Point;
use Symfony\Component\HttpFoundation\File\File;

interface ParserInterface
{
    /** @return Point[] */
    public function parse(File $file): array;
}