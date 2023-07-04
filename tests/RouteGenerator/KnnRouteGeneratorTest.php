<?php

namespace App\Tests\RouteGenerator;

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
}
