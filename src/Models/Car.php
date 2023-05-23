<?php

namespace App\Models;

use App\Interfaces\Coordinates;

class Car implements \App\Interfaces\Car
{
    private string $name;
    private int $allowedWeight;
    private int $currentWeight;
    private Coordinates $centroid;

    /**
     * @param string $name
     * @param int $allowedWeight
     * @param int $currentWeight
     */
    public function __construct(string $name, int $allowedWeight, int $currentWeight)
    {
        $this->name = $name;
        $this->allowedWeight = $allowedWeight;
        $this->currentWeight = $currentWeight;
        $this->centroid = new Centroid(0,0);
    }
    public function getCentroid(): Coordinates
    {
        return $this->centroid;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getAllowedWeight(): int
    {
        return $this->allowedWeight;
    }
    public function getCurrentWeight(): int
    {
        return $this->currentWeight;
    }

    public function addWeight(float $weight): self
    {
        $this->currentWeight += $weight;
        return $this;
    }

    public function canCarry(float $weight): bool
    {
        return $this->currentWeight + $weight <= $this->allowedWeight;
    }

    public function unload(): self
    {
        $this->currentWeight = 0;
        return $this;
    }

    public function setCentroid(Coordinates $centroid): self
    {
        $this->centroid = $centroid;
        return $this;
    }
}