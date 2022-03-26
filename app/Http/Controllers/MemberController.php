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
            return redirect('/login?back=' . urlencode(route('profile', [], false)));
        }

        return view('member.profile', []);
    }

    public function ads()
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('my-ads', [], false)));
        }

        return view('member.ads');
    }

    public function favorites()
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('favorites', [], false)));
        }

        return view('member.favorites');
    }

    public function messages()
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('messages', [], false)));
        }

        return view('member.messages');
    }
}
