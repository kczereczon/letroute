<?php

namespace App\Tests\Stubs;

use App\Interfaces\Car;
use App\Interfaces\Coordinates;

class CarStub implements Car
{

    private float $currentWeight;

    public function __construct(private readonly string $name, private readonly float $allowedWeight, private Coordinates $coordinatesStub)
    {
        $this->currentWeight = 0;
    }

    public function getCentroid(): Coordinates
    {
        return $this->coordinatesStub;
    }
    public function setCentroid(Coordinates $coordinates): self {
        $this->coordinatesStub = $coordinates;
        return $this;
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

    public function addWeight(float $weight): Car
    {
        $this->currentWeight += $weight;
        return $this;
    }

    public function canCarry(float $weight): bool
    {
        return $this->currentWeight + $weight <=$this->allowedWeight;
    }

    public function unload(): Car
    {
        $this->currentWeight = 0;
        return $this;
    }
}