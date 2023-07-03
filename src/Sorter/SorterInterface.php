<?php

interface SorterInterface
{
    public function sort(
        \Doctrine\Common\Collections\Collection $collection,
        \App\Interfaces\Coordinates $coordinates
    ): \Doctrine\Common\Collections\Collection;
}