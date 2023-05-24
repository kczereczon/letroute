<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpClient\HttpClient;

class MapboxService
{
    public function __construct(private HttpClient $client)
    {
    }

    public function getRouteData(Collection $collection)
    {
        
    }
}