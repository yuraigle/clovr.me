<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AdUrl
{
    public static int $PROJECT_STARTED_TS = 1649173518;

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
        $id = $row->id + self::$PROJECT_STARTED_TS;

        return route("show-ad", ["cat" => $cat, "title" => $title, "id" => $id]);
    }
}
