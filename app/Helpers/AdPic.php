<?php

namespace App\Helpers;

class AdPic
{
    static function main($row, $size = 's', $ext = 'webp'): string
    {
        if (!$row || !$row->pic) {
            return "/${size}_noimg.$ext";
        }

        return '/images/' . substr($row->pic, 0, 4) . "/${size}_" . $row->pic . ".$ext";
    }

    static function placeholder(): string
    {
        return "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";
    }
}
