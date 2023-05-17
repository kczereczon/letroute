<?php

namespace App\Tests\Stubs;

use App\Interfaces\Coordinates;
use App\Interfaces\Load;
use App\Interfaces\Point;

class PointStub implements Point
{

    public function __construct(private float $x, private float $y, private float $weight)
    {
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function setX(float $x): \App\Interfaces\Coordinates
    {
        $this->x = $x;
        return $this;
    }

    public function setY(float $y): \App\Interfaces\Coordinates
    {
        $this->y = $y;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): \App\Interfaces\Load
    {
        $this->weight = $weight;
        return $this;
    }
}