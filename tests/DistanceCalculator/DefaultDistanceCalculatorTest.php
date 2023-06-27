<?php

namespace App\Tests\DistanceCalculator;

use App\DistanceCalculator\DefaultDistanceCalculator;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class DefaultDistanceCalculatorTest extends TestCase
{
    /** @covers \App\DistanceCalculator\DefaultDistanceCalculator::calculateDistance */
    public function testCalculateDistance(): void
    {
        $calculator = $this->createPartialMock(DefaultDistanceCalculator::class, []);

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);
        $distance = 391309;

        $points = new ArrayCollection([$coordinates3]);


        $this->assertEquals($distance, $calculator->calculateDistance($points, $coordinates1, $coordinates2));

        $this->assertTrue(true);
    }
}
