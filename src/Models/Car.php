<?php

class Car
{
    private string $name;
    private int $allowedWeight;
    private int $currentWeight;
    private Centroid $centroid;

    /**
     * @param string $name
     * @param int $allowedWeight
     * @param int $currentWeight
     */
    public function __construct(string $name, int $allowedWeight, int $currentWeight)
    {
        $this->name = $name;
        $this->allowedWeight = $allowedWeight;
        $this->currentWeight = $currentWeight;
        $this->centroid = new Centroid(0,0);
    }

    /**
     * @return Centroid
     */
    public function getCentroid(): Centroid
    {
        return $this->centroid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAllowedWeight(): int
    {
        return $this->allowedWeight;
    }

    /**
     * @return int
     */
    public function getCurrentWeight(): int
    {
        return $this->currentWeight;
    }
}