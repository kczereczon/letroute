<?php

namespace App\Tests\DistanceCalculator;

use App\DistanceCalculator\DefaultDistanceCalculator;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class DefaultDistanceCalculatorTest extends TestCase
{
    public function testCalculateDistanceOnlyOnePoint(): void
    {
        $calculator = new DefaultDistanceCalculator();

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);
        $distance = 391309;

        $points = new ArrayCollection([$coordinates3]);

        $this->assertEquals($distance, $calculator->calculateDistance($points, $coordinates1, $coordinates2));

        $this->assertTrue(true);
    }

    public function testCalculateDistanceMorePoints(): void
    {
        $calculator = new DefaultDistanceCalculator();

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);
        $coordinates4 = new CoordinatesStub(54, 19);
        $distance = 650042;

        $points = new ArrayCollection([$coordinates3, $coordinates4]);

        $this->assertEquals($distance, $calculator->calculateDistance($points, $coordinates1, $coordinates2));

        $this->assertTrue(true);
    }

    public function testCalculateDistanceBetweenPoints(): void
    {
        $calculator = new DefaultDistanceCalculator();

        $coordinates1 = new CoordinatesStub(0, 0);
        $coordinates2 = new CoordinatesStub(1, 1);
        $coordinates3 = new CoordinatesStub(2, 2);
        $distance = 471699;

        $points = new ArrayCollection([$coordinates3]);

        $this->assertEquals($distance, $calculator->calculateDistance($points, $coordinates1, $coordinates2));

        $this->assertTrue(true);
    }
}
