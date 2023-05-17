<?php

namespace App\Entity;

use App\Interfaces\Coordinates;
use App\Interfaces\Load;
use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point implements \JsonSerializable, \App\Interfaces\Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $lat = null;

    #[ORM\Column]
    private ?float $lon = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\ManyToOne(inversedBy: 'points')]
    private ?Set $set = null;

    #[ORM\ManyToOne(inversedBy: 'points')]
    private ?Route $route = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSet(): ?Set
    {
        return $this->set;
    }

    public function setSet(?Set $set): self
    {
        $this->set = $set;

        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'lat' => $this->getLat(),
            'lon' => $this->getLon()
        ];
    }

    public function getX(): float
    {
        return $this->getLon();
    }

    public function getY(): float
    {
        return $this->getLat();
    }

    public function setX(float $x): self
    {
        return $this->setLon($x);
    }

    public function setY(float $y): self
    {
        return $this->setLat($y);
    }
}
