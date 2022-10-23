<?php

namespace App\Services;

use App\Models\Town;
use Illuminate\Http\Request;

class LocationService
{
    private Request $request;

    private array $towns = [];

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->towns[] = new Town(1, "Dublin", -6.29726611, 53.34677576);
        $this->towns[] = new Town(2, "Cork", -8.4743419, 51.8923571, 12);
        $this->towns[] = new Town(3, "Limerick", -8.6258872, 52.6636266, 12);
        $this->towns[] = new Town(4, "Galway", -9.0586647, 53.2721161, 13);
        $this->towns[] = new Town(5, "Waterford", -7.1038815, 52.2553227, 13);
        $this->towns[] = new Town(6, "Drogheda", -6.3547815, 53.7151655, 13);
        $this->towns[] = new Town(7, "Dundalk", -6.4057031, 54.0010227, 13);
        $this->towns[] = new Town(8, "Bray", -6.1100293, 53.2003348, 13);
        $this->towns[] = new Town(9, "Navan", -6.6840745, 53.6518022, 13);
    }

    /**
     * @return array
     */
    public function getTowns(): array
    {
        return $this->towns;
    }

    /**
     * @return Town
     */
    public function getTownFromCookie(): Town
    {
        $c = $this->request->cookie("location", "Dublin");
        return $this->getTownByName($c, $this->towns[0]);

    }

    /**
     * @param string $name
     * @param Town|null $default
     * @return Town|null
     */
    public function getTownByName(string $name, Town $default = null): ?Town
    {
        $found = array_filter($this->towns, function (Town $t) use ($name) {
            return $t->getName() == $name;
        });

        return $found ? reset($found) : $default;
    }

}
