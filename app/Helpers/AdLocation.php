<?php

namespace App\Helpers;

class AdLocation
{
    static function full($row): string
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
}
