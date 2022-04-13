<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private array $towns = ['Dublin', 'Cork', 'Limerick', 'Galway',
        'Waterford', 'Drogheda', 'Dundalk', 'Bray', 'Navan'];

    public function home(Request $req)
    {
        $loc = $req->query("loc");
        if ($loc && in_array($loc, $this->towns)) {
            return redirect('/')->withCookie(cookie("location", $loc, 60 * 24 * 10));
        }

        $town = $this->getTown($req->cookie("location"));
        $rows = DB::select("select * from `ads` order by `id` desc limit 10");
        return view('home', ["rows" => $rows, "towns" => $this->towns, "town" => $town]);
    }

    private function getTown($c): string
    {
        if (!in_array($c, $this->towns)) {
            return "Dublin";
        }
        return $c;
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
