<?php

namespace App\Tests\DurationCalculator;

use App\DistanceCalculator\DistanceCalculatorInterface;
use App\DurationCalculator\DefaultDurationCalculator;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class DefaultDurationCalculatorTest extends TestCase
{

    /** @covers \App\DurationCalculator\DefaultDurationCalculator::calculateDuration */
    public function testCalculateDuration(): void
    {
        $distanceCalculator = $this->createMock(DistanceCalculatorInterface::class);
        $distanceCalculator->method('calculateDistance')->willReturn(60000);

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);

        $points = new ArrayCollection([$coordinates3]);

        $durationCalculator = new DefaultDurationCalculator($distanceCalculator);

        $this->assertEquals(1, $durationCalculator->calculateDuration($points, $coordinates1, $coordinates2, 60));

        $this->assertTrue(true);
    }

    /** @covers \App\DurationCalculator\DefaultDurationCalculator::calculateDuration */
    public function testCalculateDurationWithZeroDistance(): void
    {
        $distanceCalculator = $this->createMock(DistanceCalculatorInterface::class);
        $distanceCalculator->method('calculateDistance')->willReturn(0);

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);

        $points = new ArrayCollection([$coordinates3]);

        $durationCalculator = new DefaultDurationCalculator($distanceCalculator);

        $this->assertEquals(0, $durationCalculator->calculateDuration($points, $coordinates1, $coordinates2, 60));

        $this->assertTrue(true);
    }

    /** @covers \App\DurationCalculator\DefaultDurationCalculator::calculateDuration */
    public function testCalculateDurationWithZeroAverageKilometers(): void
    {
        $distanceCalculator = $this->createMock(DistanceCalculatorInterface::class);
        $distanceCalculator->method('calculateDistance')->willReturn(60000);

        $coordinates1 = new CoordinatesStub(51, 16);
        $coordinates2 = new CoordinatesStub(52, 17);
        $coordinates3 = new CoordinatesStub(53, 18);

        $points = new ArrayCollection([$coordinates3]);

        $durationCalculator = new DefaultDurationCalculator($distanceCalculator);

        $this->assertEquals(0, $durationCalculator->calculateDuration($points, $coordinates1, $coordinates2, 0));

        $this->assertTrue(true);
    }

    /** @covers \App\DurationCalculator\DefaultDurationCalculator::__construct */
    public function testConstructor(): void
    {
        $distanceCalculator = $this->createMock(DistanceCalculatorInterface::class);

        $durationCalculator = new DefaultDurationCalculator($distanceCalculator);

        $this->assertInstanceOf(DefaultDurationCalculator::class, $durationCalculator);

        $this->assertTrue(true);
    }
}
