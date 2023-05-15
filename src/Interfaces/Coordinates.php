<?php
namespace App\Interfaces;

interface Coordinates
{
    public function getX(): float;
    public function getY(): float;
    public function setX(float $x): self;
    public function setY(float $y): self;
}