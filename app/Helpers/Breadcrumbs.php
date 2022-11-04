<?php

namespace App\Helpers;

class Breadcrumbs
{
    static function for($town, $cat, $ad = null): array
    {
        $arr = [];

        $c1 = str_contains($cat->name, "Garage") ? "Garages & Parking" : "Property";
        $arr[] = [
            "name" => "$c1 in $town",
            "path" => "/",
            "active" => false
        ];

        if (str_contains($cat->name, "To Rent")) {
            $cat1Name = "To Rent";
        } elseif (str_contains($cat->name, "To Share")) {
            $cat1Name = "To Share";
        } else {
            $cat1Name = "For Sale";
        }
        $arr[] = [
            "name" => $cat1Name,
            "path" => "/" . $cat->slug,
            "active" => false
        ];

        if ($ad && $ad->property_type) {
            $arr[] = [
                "name" => ucfirst($ad->property_type),
                "path" => "/" . $cat->slug . "/" . $ad->property_type,
                "active" => false
            ];
        }

        if ($ad) {
            $arr[] = [
                "name" => $ad->title,
                "path" => AdUrl::canonical($ad),
                "active" => false
            ];
        }

        $arr[count($arr) - 1]["active"] = true;

        return $arr;
    }
}
