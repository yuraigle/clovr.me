<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PagesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(
        private readonly LocationService $locationService,
    )
    {
    }

    public function about(): View
    {
        return view('pages.about', []);
    }

    public function terms(): View
    {
        return view('pages.terms', []);
    }
}
