<?php

namespace App\Models;

class Centroid implements \App\Interfaces\Coordinates
{
    private float $x;
    private float $y;

    /**
     * @param float $x
     * @param float $y
     */
    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @param float $x
     */
    public function setX(float $x): self
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @param float $y
     */
    public function setY(float $y): self
    {
        $this->y = $y;
        return $this;
    }
}