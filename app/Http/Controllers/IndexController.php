<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home()
    {
        return view('home', []);
    }

    public function about()
    {
        return view('about.about-us', []);
    }

    public function terms()
    {
        return view('about.terms', []);
    }

    public function search(Request $req)
    {
        return $req->user();
//        return view('search', []);
    }
}
