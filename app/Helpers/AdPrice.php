<?php

namespace App\Helpers;

class AdPrice
{
    static function full($row, $precision = 2): string
    {
        $s = "";

        if ($row && $row->price) {
            $s .= "&euro;";
            $s .= number_format($row->price, $precision);

            if ($row->price_freq) {
                $s .= " " . preg_replace('|_|', ' ', $row->price_freq);
            }
        }

        return $s;
    }
}
