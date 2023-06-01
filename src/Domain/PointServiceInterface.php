<?php

namespace App\Domain;

use App\Entity\Set;
use Doctrine\Common\Collections\Collection;

interface PointServiceInterface
{
    public function generateRoutes(Set $set): \Doctrine\Common\Collections\Collection;
    public function setCars(Collection $cars): self;
    public function setMaximumDistance(float $distance): self;
    public function setMaximumDuration(float $duration): self;
}