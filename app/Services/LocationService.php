<?php

namespace App\Services;

use Illuminate\Http\Request;

class LocationService
{
    private Request $request;

    private array $towns = [
        'Dublin', 'Cork', 'Limerick', 'Galway', 'Waterford',
        'Drogheda', 'Dundalk', 'Bray', 'Navan'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array|string[]
     */
    public function getTowns(): array
    {
        return $this->towns;
    }

    public function getTown(): string
    {
        $c = $this->request->cookie("location");

        if (!in_array($c, $this->towns)) {
            return "Dublin";
        }

        return $c;
    }

}
