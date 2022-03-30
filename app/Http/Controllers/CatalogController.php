<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class CatalogController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function showAd($id)
    {
        $row = DB::selectOne("select * from `ads` where `id`=?", [$id]);
        abort_if(!$row, 404);

        return view('catalog.show-ad', ["row" => $row]);
    }
}
