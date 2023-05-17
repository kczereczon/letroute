<?php

namespace App\Interfaces;

interface Load
{
    public function getWeight(): float;
    public function setWeight(float $weight): self;
}