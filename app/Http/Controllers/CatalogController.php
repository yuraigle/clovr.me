<?php

namespace App\Http\Controllers;

use App\Helpers\AdUrl;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CatalogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function showAd(Request $req)
    {
        $id = $req->route()->parameter('id') - AdUrl::$PROJECT_STARTED_TS;

        $rowAd = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        abort_if(!$rowAd, 404);

        $rowUsr = DB::selectOne("select * from `users` where `id`=?", [$rowAd->user_id]);
        abort_if(!$rowUsr, 404);

        $pics = DB::select("select * from `pictures` where `ad_id`=? order by `ord`", [$id]);

        return view('catalog.show-ad', ["ad" => $rowAd, "usr" => $rowUsr, "pics" => $pics]);
    }
}
