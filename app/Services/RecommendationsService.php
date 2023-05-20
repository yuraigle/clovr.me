<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RecommendationsService
{
    public function fetchForAd($aid, $num = 5, $seed = null): array
    {
        assert(is_int($num));

        if (!$seed) {
            $seed = 9_999_999_999;
        }

        return DB::select("
            select a.*
            from `ads` a
                left join `ads` a0 on a0.`id` = ?
            where a.`pic` is not null
                and a.`id` != a0.`id`
                and a.`category_id` = a0.`category_id`
                and a.`price` >= a0.`price` * .75 and a.`price` <= a0.`price` * 1.5
                and a.`id` < ?
            order by `id` desc
            limit ?
            ",
            [$aid, $seed, $num]
        );
    }
}
