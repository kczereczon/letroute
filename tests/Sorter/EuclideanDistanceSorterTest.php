<?php

namespace App\Tests\Sorter;

use App\Entity\Point;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class EuclideanDistanceSorterTest extends TestCase
{
    public function testSort(): void
    {
        $point = new Point();
        $point->setX(51.912096);
        $point->setY(19.344748);

        $point1 = new Point(); // 1
        $point1->setX(51.769870);
        $point1->setY(19.434911);
        $point2 = new Point(); // 0
        $point2->setX(51.888984);
        $point2->setY(19.237998);
        $point3 = new Point(); // 3
        $point3->setX(52.008142);
        $point3->setY(22.177633);
        $point4 = new Point(); // 2
        $point4->setX(51.271349);
        $point4->setY(20.498864);

        $collection = new ArrayCollection([
            $point1,
            $point2,
            $point3,
            $point4,
        ]);

        $euclideanDistanceSorter = new \App\Sorter\EuclideanDistanceSorter();
        $sortedCollection = $euclideanDistanceSorter->sort($collection, $point);

        $this->assertEquals([
            $point2,
            $point1,
            $point4,
            $point3,
        ], $sortedCollection->toArray());
    }
}
