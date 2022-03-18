<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class MemberController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function profile()
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode($_SERVER['REQUEST_URI']));
        }

        return view('member.profile', []);
    }
}
