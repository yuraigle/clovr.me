<?php

namespace App\Helpers;

class AdPriceFreq
{
    static function full($row,): string
    {
        if ($row->price_freq == "per_week") {
            return "per week";
        }
        if ($row->price_freq == 'per_month') {
            return "per month";
        }
        return "";
    }

    static function short($row): string
    {
        if ($row->price_freq == "per_week") {
            return "pw";
        }
        if ($row->price_freq == 'per_month') {
            return "pm";
        }
        return "";
    }
}
