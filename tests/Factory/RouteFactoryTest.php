<?php

namespace App\Tests\Factory;

use App\DistanceCalculator\DefaultDistanceCalculator;
use App\DurationCalculator\DefaultDurationCalculator;
use App\Entity\Point;
use App\Entity\Set;
use App\Factory\RouteFactory;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class RouteFactoryTest extends TestCase
{
    public function testCreateRoute(): void
    {
        $distanceCalculator = $this->createMock(DefaultDistanceCalculator::class);
        $distanceCalculator->expects($this->once())
            ->method('calculateDistance')
            ->willReturn(50);
        $durationCalculator = $this->createMock(DefaultDurationCalculator::class);
        $durationCalculator->expects($this->once())
            ->method('calculateDuration')
            ->willReturn(20);

        $routeFactory = new RouteFactory($distanceCalculator, $durationCalculator);

        $coordinates1 = new Point();
        $coordinates2 = new Point();
        $coordinates3 = new Point();
        $coordinates4 = new Point();

        $points = new ArrayCollection([$coordinates3, $coordinates4]);
        $set = new Set();

        $route = $routeFactory->create($points, $set, 1, $coordinates1, $coordinates2);

        $this->assertEquals(50, $route->getDistance());
        $this->assertEquals(20, $route->getDuration());
        $this->assertEquals($set, $route->getSet());
        $this->assertEquals('R-0001', $route->getName());
        $this->assertGreaterThan(dechex(0x000000), strlen($route->getColor()));
        $this->assertLessThan(dechex(0xFFFFFF), strlen($route->getColor()));
        $this->assertEquals($points->toArray(), $route->getPoints()->toArray());
    }
}
