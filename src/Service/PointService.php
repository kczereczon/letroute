<?php

namespace App\Service;

use App\Entity\Set;
use App\Interfaces\Coordinates;
use App\Interfaces\Point;
use App\Models\Centroid;
use App\Repository\PointRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;

class PointService
{
    public function __construct(private PointRepository $pointRepository)
    {
    }

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

    /**
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    public function getRandomCentroid(Set $set): Coordinates
    {
        $biggestLat = $this->pointRepository->findBiggestLat($set);
        $biggestLon = $this->pointRepository->findBiggestLon($set);
        $smallestLat = $this->pointRepository->findSmallestLat($set);
        $smallestLon = $this->pointRepository->findSmallestLon($set);

        $x = random_int($smallestLon->getLon() * 1000, $biggestLon->getLon() * 1000) / 1000;
        $y = random_int($smallestLat->getLon() * 1000, $biggestLat->getLon() * 1000) / 1000;

        return new Centroid($x, $y);
    }
}