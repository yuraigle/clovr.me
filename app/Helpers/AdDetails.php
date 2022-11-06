<?php

namespace App\Helpers;

class AdDetails
{
    static function locationFull($row): string
    {
        $parts = [];
        $parts[] = $row->location ?: "";
        $parts[] = $row->town ?: "";
        $parts[] = self::region($row);

        return join(", ", $parts);
    }

    static function region($row): string
    {
        $parts = [];
        $parts[] = $row->county ?: "";
        $parts[] = $row->postcode ?: "";

        return trim(join(" ", $parts));
    }

    static function priceShort($row, $precision = 0): string
    {
        if ($row && $row->price) {
            return "&euro;" . number_format($row->price, $precision);
        }

        return "";
    }

    static function priceFull($row, $precision = 2): string
    {
        $s = self::priceShort($row, $precision);
        if ($row->price_freq) {
            $s .= " " . self::freqFull($row);
        }

        return $s;
    }

    static function freqShort($row): string
    {
        if ($row->price_freq == "per_week") {
            return "pw";
        }
        if ($row->price_freq == 'per_month') {
            return "pm";
        }
        return "";
    }

    static function freqFull($row): string
    {
        if ($row->price_freq == "per_week") {
            return "per week";
        }
        if ($row->price_freq == 'per_month') {
            return "per month";
        }
        return "";
    }

    static function propType($row): string
    {
        if ($row->property_type) {
            return ucfirst($row->property_type);
        }

        return "";
    }

    static function numBeds($row): string
    {
        if ($row->num_beds == 1) {
            return $row->num_beds . ' bedroom';
        } elseif ($row->num_beds > 1) {
            return $row->num_beds . ' bedrooms';
        } elseif ($row->num_beds == 0 && $row->property_type == 'flat') {
            return "Studio";
        }

        return "";
    }

    static function roomType($row): string
    {
        if ($row->room_type == 'couch') {
            return "Couch Surf";
        } elseif ($row->room_type) {
            return ucfirst($row->room_type) . " room";
        }

        return "";
    }
}
