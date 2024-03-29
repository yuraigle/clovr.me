<?php

namespace App\Models;

class Town
{
    private int $id;
    private string $name;
    private float $lng;
    private float $lat;
    private int $zoom;

    /**
     * @param int $id
     * @param string $name
     * @param float $lng
     * @param float $lat
     * @param int $zoom
     */
    public function __construct(int $id, string $name, float $lng, float $lat, int $zoom = 11)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lng = $lng;
        $this->lat = $lat;
        $this->zoom = $zoom;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getLng(): float
    {
        return $this->lng;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return int
     */
    public function getZoom(): int
    {
        return $this->zoom;
    }

    public function __toString(): string
    {
        return json_encode([
            "id" => $this->id,
            "name" => $this->name,
            "lng" => $this->lng,
            "lat" => $this->lat,
            "zoom" => $this->zoom,
        ]);
    }
}
