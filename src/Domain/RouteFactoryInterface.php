<?php

namespace App\Domain;

use App\Entity\Route;
use App\Entity\Set;
use Doctrine\Common\Collections\Collection;

interface RouteFactoryInterface
{
    public function create(Collection $collection, Set $set, int $number): Route;
}