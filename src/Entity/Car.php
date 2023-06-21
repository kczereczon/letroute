<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $maxLoadWeight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationNumber = null;

    #[ORM\Column(nullable: true)]
    private ?int $averageSpeed = null;

    #[ORM\ManyToOne]
    private ?Localization $startLocalization = null;

    #[ORM\ManyToOne]
    private ?Localization $endLocalization = null;

    #[ORM\Column(nullable: true)]
    private ?float $averageFuelConsumption = null;

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

    public function getMaxLoadWeight(): ?int
    {
        return $this->maxLoadWeight;
    }

    public function setMaxLoadWeight(int $maxLoadWeight): self
    {
        $this->maxLoadWeight = $maxLoadWeight;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getAverageSpeed(): ?int
    {
        return $this->averageSpeed;
    }

    public function setAverageSpeed(?int $averageSpeed): self
    {
        $this->averageSpeed = $averageSpeed;

        return $this;
    }

    public function getStartLocalization(): ?Localization
    {
        return $this->startLocalization;
    }

    public function setStartLocalization(?Localization $startLocalization): self
    {
        $this->startLocalization = $startLocalization;

        return $this;
    }

    public function getEndLocalization(): ?Localization
    {
        return $this->endLocalization;
    }

    public function setEndLocalization(?Localization $endLocalization): self
    {
        $this->endLocalization = $endLocalization;

        return $this;
    }

    public function getAverageFuelConsumption(): ?float
    {
        return $this->averageFuelConsumption;
    }

    public function setAverageFuelConsumption(?float $averageFuelConsumption): self
    {
        $this->averageFuelConsumption = $averageFuelConsumption;

        return $this;
    }
}
