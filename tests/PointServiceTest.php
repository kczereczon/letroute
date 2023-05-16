<?php

namespace App\Tests;

use App\Entity\Point;
use App\Interfaces\Coordinates;
use App\Service\PointService;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PointServiceTest extends TestCase
{
    public function test_get_distance_between_points(): void
    {
        $pointServiceMock = $this->createPartialMock(PointService::class, []);
        $aPoint = $this->createMock(Coordinates::class);
        $aPoint->method('getY')->willReturn(3.0);
        $aPoint->method('getX')->willReturn(0.0);

        $bPoint = $this->createMock(Coordinates::class);
        $bPoint->method('getY')->willReturn(0.0);
        $bPoint->method('getX')->willReturn(4.0);

        $distance = $pointServiceMock->getDistanceBetweenPoints($aPoint, $bPoint);

        $this->assertEquals(5, $distance);
    }

//    /**
//     * @dataProvider sortDataProvider
//     * @return void
//     */
//    public function test_sort_points_by_distance(array $points, Coordinates): void
//    {
//        $pointServiceMock = $this->createPartialMock(PointService::class, []);
//        $points = new ArrayCollection();
//        $point1 = new Point();
//        $point1->setX(1);
//        $point1->setY(3);
//
//        $point1 = new Point();
//        $point1->setX(8);
//        $point1->setY(3);
//
//        $point1 = new Point();
//        $point1->setX(1);
//        $point1->setY(3);
//
//        $point1 = new Point();
//        $point1->setX(1);
//        $point1->setY(3);
//        $points->add(new Po);
//    }

    public function sortDataProvider()
    {
        return [

        ];
    }
}
