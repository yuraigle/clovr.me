<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function home(Request $req): View|RedirectResponse
    {
        $loc = $req->query("loc");
        if ($loc && in_array($loc, $this->locationService->getTowns())) {
            return redirect('/')->withCookie(cookie("location", $loc, 60 * 24 * 10));
        }

        $town = $this->locationService->getTown();
        return view('home', [
            "towns" => $this->locationService->getTowns(),
            "town" => $town
        ]);
    }

    public function about(): View
    {
        return view('about.about-us', []);
    }

    public function terms(): View
    {
        return view('about.terms', []);
    }
}
