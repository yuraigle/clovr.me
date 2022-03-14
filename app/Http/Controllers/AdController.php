<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AdController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function newAd()
    {
        // step 1 : details form
        return view('new-ad-details', []);
    }

    public function postAdDetails(Request $req): JsonResponse
    {
        $p = $req->post();
        // TODO backend validation
        return response()->json(["status" => "OK"]);
    }

}
