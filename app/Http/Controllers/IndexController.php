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
        if ($loc = $req->query("loc")) {
            $isCorrect = $this->locationService->getTownByName($loc);
            $loc = $isCorrect ? urlencode($loc) : "Dublin";
            return redirect('/')->withCookie(cookie("location", $loc, 60 * 24 * 10));
        }

        return view('home', [
            "towns" => $this->locationService->getTowns(),
            "town" => $this->locationService->getTownFromCookie()->getName()
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
