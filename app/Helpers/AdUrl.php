<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AdUrl
{
    public static array $CATS = [
        1 => "property-for-sale",
        2 => "property-to-rent",
        3 => "property-to-share",
        4 => "garage-parking-for-sale",
        5 => "garage-parking-to-rent"
    ];

    static function canonical($row): string
    {
        $cat = self::$CATS[$row->category_id] ?? "";
        $title = Str::of($row->title)->words(8)->slug();
        return route("show-ad", ["cat" => $cat, "title" => $title, "id" => $row->id]);
    }
}
