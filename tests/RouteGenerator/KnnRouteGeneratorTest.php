<?php

namespace App\Tests\RouteGenerator;

use App\Entity\Point;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class KnnRouteGeneratorTest extends TestCase
{
    public function testSortPointsByDistanceNoPointsFound(): void
    {
        $pointRepository = $this->createMock(\App\Repository\PointRepository::class);
        $pointRepository->expects($this->once())
            ->method('getPointsWithoutRoute')
            ->willReturn(new ArrayCollection([]));

        $knnRouteGenerator = new \App\RouteGenerator\KnnRouteGenerator(
            $pointRepository,
            $this->createMock(\App\DurationCalculator\DurationCalculatorInterface::class),
            $this->createMock(\App\DistanceCalculator\DistanceCalculatorInterface::class),
            $this->createMock(\App\Factory\RouteFactory::class),
            $this->createMock(\App\Domain\CentroidRandomizerInterface::class),
            $this->createMock(\App\Sorter\EuclideanDistanceSorter::class)
        );

        $this->assertEquals([], $knnRouteGenerator->generate(
            $this->createMock(\App\Entity\Set::class),
            new \Doctrine\Common\Collections\ArrayCollection(),
            0,
            0,
            0,
            $this->createMock(\App\Interfaces\Coordinates::class)
        )->toArray());
    }

    public function testLoopEndsWhenTriesExceededCantCarry()
    {
        $point = new Point();
        $point->setX(51.912096);
        $point->setY(19.344748);
        $point->setWeight(2000);

        $car = new \App\Models\Car(
            'test',
            1000,
            1000,
        );

        $sorter = $this->createMock(\App\Sorter\EuclideanDistanceSorter::class);
        $sorter
            ->method('sort')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $pointRepository = $this->createMock(\App\Repository\PointRepository::class);
        $pointRepository->expects($this->once())
            ->method('getPointsWithoutRoute')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $distanceCalculator = $this->createMock(\App\DistanceCalculator\DistanceCalculatorInterface::class);

        $durationCalculator = $this->createMock(\App\DurationCalculator\DurationCalculatorInterface::class);

        $knnRouteGenerator = new \App\RouteGenerator\KnnRouteGenerator(
            $pointRepository,
            $durationCalculator,
            $distanceCalculator,
            $this->createMock(\App\Factory\RouteFactory::class),
            $this->createMock(\App\Domain\CentroidRandomizerInterface::class),
            $sorter
        );

        $this->assertEquals([], $knnRouteGenerator->generate(
            $this->createMock(\App\Entity\Set::class),
            new \Doctrine\Common\Collections\ArrayCollection([
                $car
            ]),
            0,
            0,
            0,
            $this->createMock(\App\Interfaces\Coordinates::class)
        )->toArray());
    }
    public function testLoopEndsWhenTriesExceededTooFar()
    {
        $point = new Point();
        $point->setX(51.912096);
        $point->setY(19.344748);
        $point->setWeight(300);

        $car = new \App\Models\Car(
            'test',
            1000,
            0,
        );

        $sorter = $this->createMock(\App\Sorter\EuclideanDistanceSorter::class);
        $sorter
            ->method('sort')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $pointRepository = $this->createMock(\App\Repository\PointRepository::class);
        $pointRepository->expects($this->once())
            ->method('getPointsWithoutRoute')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $distanceCalculator = $this->createMock(\App\DistanceCalculator\DistanceCalculatorInterface::class);
        $distanceCalculator->expects($this->atLeastOnce())
            ->method('calculateDistance')
            ->willReturn(1000);

        $durationCalculator = $this->createMock(\App\DurationCalculator\DurationCalculatorInterface::class);

        $knnRouteGenerator = new \App\RouteGenerator\KnnRouteGenerator(
            $pointRepository,
            $durationCalculator,
            $distanceCalculator,
            $this->createMock(\App\Factory\RouteFactory::class),
            $this->createMock(\App\Domain\CentroidRandomizerInterface::class),
            $sorter
        );

        $this->assertEquals([], $knnRouteGenerator->generate(
            $this->createMock(\App\Entity\Set::class),
            new \Doctrine\Common\Collections\ArrayCollection([
                $car
            ]),
            0,
            0,
            0,
            $this->createMock(\App\Interfaces\Coordinates::class)
        )->toArray());
    }
    public function testLoopEndsWhenTriesExceededTooMuchTime()
    {
        $point = new Point();
        $point->setX(51.912096);
        $point->setY(19.344748);
        $point->setWeight(300);

        $car = new \App\Models\Car(
            'test',
            1000,
            0,
        );

        $sorter = $this->createMock(\App\Sorter\EuclideanDistanceSorter::class);
        $sorter
            ->method('sort')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $pointRepository = $this->createMock(\App\Repository\PointRepository::class);
        $pointRepository->expects($this->once())
            ->method('getPointsWithoutRoute')
            ->willReturn(new ArrayCollection([
                $point
            ]));

        $distanceCalculator = $this->createMock(\App\DistanceCalculator\DistanceCalculatorInterface::class);
        $distanceCalculator->expects($this->atLeastOnce())
            ->method('calculateDistance')
            ->willReturn(1000);

        $durationCalculator = $this->createMock(\App\DurationCalculator\DurationCalculatorInterface::class);
        $durationCalculator->expects($this->atLeastOnce())
            ->method('calculateDuration')
            ->willReturn(1000);

        $knnRouteGenerator = new \App\RouteGenerator\KnnRouteGenerator(
            $pointRepository,
            $durationCalculator,
            $distanceCalculator,
            $this->createMock(\App\Factory\RouteFactory::class),
            $this->createMock(\App\Domain\CentroidRandomizerInterface::class),
            $sorter
        );

        $this->assertEquals([], $knnRouteGenerator->generate(
            $this->createMock(\App\Entity\Set::class),
            new \Doctrine\Common\Collections\ArrayCollection([
                $car
            ]),
            0,
            1100,
            0,
            $this->createMock(\App\Interfaces\Coordinates::class)
        )->toArray());
    }
    public function testCreateRoute()
    {
        $point = new Point();
        $point->setX(51.912096);
        $point->setY(19.344748);
        $point->setWeight(300);

        $point2 = new Point();
        $point2->setX(51.912096);
        $point2->setY(19.344748);
        $point2->setWeight(300);

        $car = new \App\Models\Car(
            'test',
            1000,
            0,
        );

        $sorter = $this->createMock(\App\Sorter\EuclideanDistanceSorter::class);
        $sorter
            ->method('sort')
            ->willReturn(new ArrayCollection([
                $point,
                $point2
            ]));

        $pointRepository = $this->createMock(\App\Repository\PointRepository::class);
        $pointRepository->expects($this->once())
            ->method('getPointsWithoutRoute')
            ->willReturn(new ArrayCollection([
                $point,
                $point2
            ]));

        $distanceCalculator = $this->createMock(\App\DistanceCalculator\DistanceCalculatorInterface::class);
        $distanceCalculator->expects($this->atLeastOnce())
            ->method('calculateDistance')
            ->willReturn(300);

        $durationCalculator = $this->createMock(\App\DurationCalculator\DurationCalculatorInterface::class);
        $durationCalculator->expects($this->atLeastOnce())
            ->method('calculateDuration')
            ->willReturn(300);

        $knnRouteGenerator = new \App\RouteGenerator\KnnRouteGenerator(
            $pointRepository,
            $durationCalculator,
            $distanceCalculator,
            $this->createMock(\App\Factory\RouteFactory::class),
            $this->createMock(\App\Domain\CentroidRandomizerInterface::class),
            $sorter
        );

        $this->assertEquals(1, count($knnRouteGenerator->generate(
            $this->createMock(\App\Entity\Set::class),
            new \Doctrine\Common\Collections\ArrayCollection([
                $car
            ]),
            1100,
            1100,
            0,
            $this->createMock(\App\Interfaces\Coordinates::class)
        )->toArray()));
    }
}
