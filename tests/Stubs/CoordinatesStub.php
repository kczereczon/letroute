<?php

namespace App\Tests\Stubs;

use App\Interfaces\Coordinates;

class CoordinatesStub implements Coordinates
{

    private float $x = 0;
    private float $y = 0;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
       return $this->y;
    }

    public function setX(float $x): Coordinates
    {
        $this->x = $x;

        return $this;
    }

    public function setY(float $y): Coordinates
    {
        $this->y = $y;

        return $this;
    }
}