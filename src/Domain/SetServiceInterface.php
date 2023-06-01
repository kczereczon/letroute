<?php

namespace App\Domain;

use App\Entity\Set;

interface SetServiceInterface
{
    public function removeRoutes(Set $set): self;
}