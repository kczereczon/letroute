<?php

namespace App\Service;

use App\Entity\Point;
use Doctrine\Common\Collections\Collection;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MapboxService
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @param array<\App\Interfaces\Point> $points
     * @return void
     * @throws TransportExceptionInterface
     */
    public function getRouteData(array $points)
    {
        $coordinates = "";

        foreach ($points as $point) {
            $coordinates .= $point->getX() . ',' . $point->getY() . ';';
        }

        $coordinates = substr($coordinates, 0, -1);

        $accessToken = $_ENV['MAPBOX_ACCESS_TOKEN'];

        try {
            $response = $this->client->request(
                'GET',
                "https://api.mapbox.com/directions/v5/mapbox/driving/$coordinates?access_token=$accessToken&annotations=distance,duration&overview=full&geometries=geojson"
            );

            $content = $response->getContent();
            $json = json_decode($content);

            return [
                "geometry" => json_encode($json->routes[0]->geometry),
                "distance" => $json->routes[0]->distance,
                "duration" => $json->routes[0]->duration,
            ];
        } catch (\Exception $exception) {

        }
    }
}