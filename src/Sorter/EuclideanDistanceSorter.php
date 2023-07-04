<?php

namespace App\Sorter;

use App\Interfaces\Coordinates;
use App\Interfaces\Point;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class EuclideanDistanceSorter implements SorterInterface
{

    /**
     * @param ArrayCollection<int, Point> $collection
     * @throws Exception
     */
    public function sort(
        \Doctrine\Common\Collections\Collection $collection,
        \App\Interfaces\Coordinates $coordinates
    ): \Doctrine\Common\Collections\Collection {
        $array = $collection->toArray();

        usort($array, function (Point $a, Point $b) use ($coordinates) {
            $aDistance = $this->getDistanceBetweenPoints($coordinates, $a);
            $bDistance = $this->getDistanceBetweenPoints($coordinates, $b);

            return $aDistance > $bDistance;
        });

        return new ArrayCollection($array);
    }

    private function getDistanceBetweenPoints(Coordinates $a, Coordinates $b): float
    {
        $xPow = (($b->getX() - $a->getX()) ** 2);
        $yPow = (($b->getY() - $a->getY()) ** 2);
        return sqrt($xPow + $yPow);
    }
}