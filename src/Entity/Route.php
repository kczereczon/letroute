<?php

namespace App\Entity;

use App\Repository\RouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RouteRepository::class)]
class Route
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("route")]
    private ?int $id = null;

    #[Groups("route")]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups("route")]
    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[Groups("set_details")]
    #[ORM\ManyToOne(inversedBy: 'routes')]
    private ?Set $set = null;

    #[Groups("route")]
    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Point::class)]
    private Collection $points;

    #[ORM\Column(nullable: false, options: ['default' => '""'])]
    private array $routeData = [];

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    private ?int $distance = null;

    public function __construct()
    {
        $this->points = new ArrayCollection();
    }

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    /**
     * @return Collection<int, Point>
     */
    public function getPoints(): Collection
    {
        return $this->points;
    }

    public function addPoint(Point $point): self
    {
        if (!$this->points->contains($point)) {
            $this->points->add($point);
            $point->setRoute($this);
        }

        return $this;
    }

    public function removePoint(Point $point): self
    {
        if ($this->points->removeElement($point)) {
            // set the owning side to null (unless already changed)
            if ($point->getRoute() === $this) {
                $point->setRoute(null);
            }
        }

        return $this;
    }

    public function getRouteData(): array
    {
        return $this->routeData;
    }

    public function setRouteData(?array $routeData): self
    {
        $this->routeData = $routeData;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
