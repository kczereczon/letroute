<?php

namespace App\RouteGenerator;

use App\DistanceCalculator\DistanceCalculatorInterface;
use App\Domain\CentroidRandomizerInterface;
use App\DurationCalculator\DurationCalculatorInterface;
use App\Entity\Route;
use App\Entity\Set;
use App\Factory\RouteFactory;
use App\Interfaces\Coordinates;
use App\Interfaces\Point;
use App\Models\Car;
use App\Models\Centroid;
use App\Repository\PointRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class KnnRouteGenerator implements RouteGeneratorInterface
{
    public function __construct(
        private PointRepository $pointRepository,
        private DurationCalculatorInterface $durationCalculator,
        private DistanceCalculatorInterface $distanceCalculator,
        private RouteFactory $routeFactory,
        private CentroidRandomizerInterface $centroidRandomizer
    ) {
    }

    /**
     * @param Set $set
     * @param Collection<Car> $cars
     * @param float $maximumDuration
     * @param float $maximumDistance
     * @return Collection<Route>
     * @throws NonUniqueResultException
     * @throws \Exception
     */
    public function generate(
        \App\Entity\Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance
    ): \Doctrine\Common\Collections\Collection {
        $points = $this->pointRepository->getPointsWithoutRoute($set);

        $triesCount = 0;

        $routes = new \Doctrine\Common\Collections\ArrayCollection();

        $counter = 0;

        while ($points->count() > 0 && $triesCount < 100) {
            /** @var Car $car */
            $car = clone $cars->current();
            $car->setCentroid($this->centroidRandomizer->getRandomCentroid(new Centroid(51.919438, 19.145136), 200));

            $routePoints = new ArrayCollection();

            while (true) {
                $points = $this->sortPointsByDistance($points, $car->getCentroid());
                $point = $points->first();

                if(!$car->canCarry($points->first()->getWeight())) {
                    break;
                }

                if($this->durationCalculator->calculateDuration(
                        $routePoints
                    ) > 200000) {
                    break;
                }

                if($this->distanceCalculator->calculateDistance($routePoints) > 30000) {
                    break;
                }

                $routePoints->add($point);
                $points->removeElement($point);
                $car->setCentroid($point);
            }

            if (!count($routePoints)) {
                $triesCount++;
            } else {
                $routes[] = $this->routeFactory->create($routePoints, $set, $counter);
                $routePoints->clear();
                $counter++;
            }
        }

        return $routes;
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
    public function sortPointsByDistance(Collection $points, Coordinates $coordinates): ArrayCollection
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