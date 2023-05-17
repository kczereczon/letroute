<?php

namespace App\Interfaces;

use App\Models\Centroid;

interface Car
{
    /**
     * @return Coordinates
     */
    public function getCentroid(): Coordinates;
    public function setCentroid(Coordinates $coordinates): self;
    public function getName(): string;
    public function getAllowedWeight(): int;
    public function getCurrentWeight(): int;

    public function addWeight(float $weight): self;
    public function canCarry(float $weight): bool;
    public function unload(): self;


}