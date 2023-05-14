<?php

namespace App\Helpers;

class UserPic
{
    static function main($row, $size = '200', $ext = 'webp'): string
    {
        if (!$row || !$row->pic) {
            return "/layout/noavatar_$size.1666414708.$ext";
        }

        return self::named($row->pic, $size, $ext);
    }

    static function named($name, $size = '200', $ext = 'webp'): string
    {
        return '/images/' . substr($name, 0, 4) . "/{$name}_$size.$ext";
    }

    static function placeholder(): string
    {
        return "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
    }
}
