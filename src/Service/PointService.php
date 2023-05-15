<?php

namespace App\Service;

use App\Entity\Point;
use App\Interfaces\Coordinates;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class PointService
{
    public function getDistanceBetweenPoints(Coordinates $a, Coordinates $b): float
    {
        $xPow = (($b->getX() - $a->getX()) ** 2);
        $yPow = (($b->getY() - $a->getY()) ** 2);
        return sqrt($xPow + $yPow);
    }

    /**
     * @param ArrayCollection<int, Point> $points
     * @param Coordinates $coordinates
     * @return ArrayCollection<int, Point>
     * @throws \Exception
     */
    public function sortPointsByDistance(Collection $points , Coordinates $coordinates): ArrayCollection
    {
        $iterator = $points->getIterator();
        $iterator->uasort(function (Point $a, Point $b) use ($coordinates) {

            $aDistance = $this->getDistanceBetweenPoints($coordinates, $a);
            $bDistance = $this->getDistanceBetweenPoints($coordinates, $b);

            return $aDistance <=> $bDistance;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }
}