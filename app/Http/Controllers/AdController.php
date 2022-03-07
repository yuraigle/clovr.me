<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newAd()
    {
        return view('new-ad-details', []);
    }

    public function postAd(Request $req)
    {
        $p = $req->post();
        return response()->json($p);
    }

    public function newAdLocation()
    {
        return view('new-ad-location', []);
    }
}
