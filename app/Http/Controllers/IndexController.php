<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function home()
    {
        $rows = DB::select("select * from `ads` order by `id` desc limit 10");
        return view('home', ["rows" => $rows]);
    }

    public function about()
    {
        return view('about.about-us', []);
    }

    public function terms()
    {
        return view('about.terms', []);
    }

    public function search()
    {
        return view('search', []);
    }
}
