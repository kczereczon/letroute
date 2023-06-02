<?php

namespace App\Tests;

use App\Entity\Point;
use App\Interfaces\Coordinates;
use App\Service\RouteService;
use App\Tests\Stubs\CoordinatesStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PointServiceTest extends TestCase
{
    public function test_get_distance_between_points(): void
    {
        $pointServiceMock = $this->createPartialMock(RouteService::class, []);

        $aPoint = new CoordinatesStub(x: 0.0, y: 3.0);
        $bPoint = new CoordinatesStub(x: 4.0, y: 0.0);

        $distance = $pointServiceMock->getDistanceBetweenPoints($aPoint, $bPoint);

        $this->assertEquals(5, $distance);
    }

    /**
     * @dataProvider sortDataProvider
     * @param array<CoordinatesStub> $points
     * @param CoordinatesStub $centroid
     * @param CoordinatesStub $expected
     * @return void
     * @throws \Exception
     */
    public function test_sort_points_by_distance(
        array $points,
        CoordinatesStub $centroid,
        CoordinatesStub $expected
    ): void {
        $pointServiceMock = $this->createPartialMock(RouteService::class, []);
        $pointsArrayCollection = new ArrayCollection();

        foreach ($points as $point) {
            $pointEntity = new Point();
            $pointEntity->setX($point->getX())->setY($point->getY());
            $pointsArrayCollection->add($pointEntity);
        }

        $sorted = $pointServiceMock->sortPointsByDistance($pointsArrayCollection, $centroid);

        $this->assertEquals($expected->getX(), $sorted->first()->getX());
        $this->assertEquals($expected->getY(), $sorted->first()->getY());
    }

    public function sortDataProvider()
    {
        return [
            [
                [
                    new CoordinatesStub(x: 1.0, y: 1.0),
                    new CoordinatesStub(x: 1.0, y: 3.0),
                    new CoordinatesStub(x: 4.0, y: 4.0),
                    new CoordinatesStub(x: 8.0, y: 3.0),
                ],
                new CoordinatesStub(x: 3.0, y: 3.0),
                new CoordinatesStub(x: 4.0, y: 4.0)
            ],
            [
                [
                    new CoordinatesStub(x: 1.0, y: 1.0),
                    new CoordinatesStub(x: 1.0, y: 3.0),
                    new CoordinatesStub(x: 3.0, y: 3.0),
                    new CoordinatesStub(x: 8.0, y: 3.0),
                ],
                new CoordinatesStub(x: 4.0, y: 4.0),
                new CoordinatesStub(x: 3.0, y: 3.0)
            ]
        ];
    }
}
