<?php

namespace App\Helpers;

class AdPic
{
    static function main($row, $size = 's', $ext = 'webp'): string
    {
        if (!$row || !$row->pic) {
            return "/layout/${size}_noimg.$ext";
        }

        return self::named($row->pic, $size, $ext);
    }

    static function named($name, $size = 's', $ext = 'webp'): string
    {
        return '/images/' . substr($name, 0, 4) . "/${size}_$name.$ext";
    }

    static function placeholder(): string
    {
        return "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
    }
}
