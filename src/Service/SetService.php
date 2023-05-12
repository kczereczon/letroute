<?php

namespace App\Service;

use App\Entity\Set;
use App\Repository\PointRepository;

class SetService
{
    private PointRepository $pointRepository;

    public function __construct(PointRepository $pointRepository)
    {
        $this->pointRepository = $pointRepository;
    }
}