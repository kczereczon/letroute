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
use App\Sorter\EuclideanDistanceSorter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class KnnRouteGenerator implements RouteGeneratorInterface
{
    public function __construct(
        private readonly PointRepository $pointRepository,
        private readonly DurationCalculatorInterface $durationCalculator,
        private readonly DistanceCalculatorInterface $distanceCalculator,
        private readonly RouteFactory $routeFactory,
        private readonly CentroidRandomizerInterface $centroidRandomizer,
        private readonly EuclideanDistanceSorter $euclideanDistanceSorter,
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
        Set $set,
        Collection $cars,
        float $maximumDuration,
        float $maximumDistance,
        float $radius,
        Coordinates $startCentroid
    ): Collection {
        $points = $this->pointRepository->getPointsWithoutRoute($set);

        $triesCount = 0;

        $routes = new ArrayCollection();

        $counter = 0;

        while ($points->count() > 0 && $triesCount < 500) {
            /** @var Car $car */
            $car = clone $cars->current();
            $car->setCentroid($this->centroidRandomizer->getRandomCentroid($startCentroid, $radius));

            $routePoints = new ArrayCollection();

            while (true) {
                /** @var Collection<\App\Entity\Point> $points */
                $points = $this->euclideanDistanceSorter->sort($points, $car->getCentroid());
                /** @var Point $point */
                $point = $points->first();
                $routePoints->add($point);

                if (!$car->canCarry($point->getWeight())) {
                    $routePoints->removeElement($routePoints->last());
                    break;
                }

                if ($this->distanceCalculator->calculateDistance(
                    $routePoints,
                    $startCentroid,
                    $startCentroid
                ) > $maximumDistance
                ) {
                    $routePoints->removeElement($routePoints->last());
                    break;
                }

                if ($this->durationCalculator->calculateDuration(
                    $routePoints,
                    $startCentroid,
                    $startCentroid,
                    60000
                ) > $maximumDuration
                ) {
                    $routePoints->removeElement($routePoints->last());
                    break;
                }
                $points->removeElement($point);
                $car->setCentroid($point);
            }

            if (count($routePoints) > 1) {
                $routes[] = $this->routeFactory->create($routePoints, $set, $counter, $startCentroid, $startCentroid);
                $routePoints->clear();
                $counter++;
                $triesCount = 0;
            } else {
                $triesCount++;
            }
        }

        return $routes;
    }
}
