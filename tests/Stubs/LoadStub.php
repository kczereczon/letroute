<?php

namespace App\Tests\Stubs;

use App\Interfaces\Coordinates;
use App\Interfaces\Load;

class LoadStub implements Coordinates, Load
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

    public function setX(float $x): self
    {
        $this->x = $x;
        return $this;
    }

    public function setY(float $y): self
    {
        $this->y = $y;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
        return $this;
    }
}