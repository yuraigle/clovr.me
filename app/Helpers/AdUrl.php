<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AdUrl
{
    public static int $PROJECT_STARTED_TS = 1649173518;

    static function canonical($row): string
    {
        $cats = [
            1 => "property-for-sale",
            2 => "property-to-rent",
            3 => "property-to-share",
            4 => "parking-garage-for-sale",
            5 => "garage-parking-to-rent"
        ];

        $cat = $cats[$row->category_id] ?? "";
        $title = Str::of($row->title)->words(8)->slug();
        $id = $row->id + self::$PROJECT_STARTED_TS;

        return route("show-ad", ["cat" => $cat, "title" => $title, "id" => $id]);
    }
}
