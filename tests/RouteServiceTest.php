<?php

namespace App\Tests;

use App\Interfaces\Car;
use App\Service\PointService;
use App\Service\RouteService;
use App\Tests\Stubs\CarStub;
use App\Tests\Stubs\CoordinatesStub;
use App\Tests\Stubs\PointStub;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class RouteServiceTest extends TestCase
{
    /**
     * @dataProvider createRoute
     * @throws \Exception
     */
    public function test_create_route_for_car(array $points, Car $car, int $expectedPointsLeft, array $expectedRoute): void
    {
        $pointsCollection = new ArrayCollection($points);
        $routeServiceMock = $this->createPartialMock(RouteService::class, []);
        $pointServiceMock = $this->createPartialMock(PointService::class, []);

        $pointsCollection = $pointServiceMock->sortPointsByDistance($pointsCollection, $car->getCentroid());
        $route = $routeServiceMock->createRouteForCar($pointsCollection, $car);

        $this->assertEquals($expectedPointsLeft, $pointsCollection->count());
        $this->assertEquals($expectedRoute, $route);
    }

    public function createRoute()
    {
        return [
            [
                [
                    new PointStub(1,1, 10),
                    new PointStub(2,0, 10),
                    new PointStub(3,3, 10),
                    new PointStub(2,3, 10),
                    new PointStub(5,2, 10),
                ],
                new CarStub("Car1", 30, new CoordinatesStub(3,2)),
                2,
                [
                    new PointStub(3,3, 10),
                    new PointStub(2,3, 10),
                    new PointStub(5,2, 10),
                ]
            ]
        ];
    }


}
