<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RecommendationsService
{
    public function fetchForAd($ad, $num = 5): array
    {
        assert(is_int($num));

        return DB::select("
            select *
            from `ads`
            where `pic` is not null
                and `id` != ?
                and `category_id` = ?
                and `price` >= ? and `price` <= ?
            order by `created_at` desc
            limit ?
            ",
            [
                $ad->id,
                $ad->category_id,
                $ad->price * .75,
                $ad->price * 1.5,
                $num
            ]
        );
    }
}
