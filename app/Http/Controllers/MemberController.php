<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function profile(Request $req): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('profile', [], false)));
        }

        return view('member.profile', [
            "user" => $req->user(),
        ]);
    }

    public function security(Request $req): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('security', [], false)));
        }

        return view('member.security', [
            "user" => $req->user(),
        ]);
    }

    public function ads(Request $req): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('my-ads', [], false)));
        }

        $rows = DB::select("select * from `ads` where `user_id` = ? order by `created_at` desc",
            [$req->user()->id]);

        return view('member.ads', [
            "rows" => $rows,
            "user" => $req->user(),
        ]);
    }

    public function favorites(Request $req): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('favorites', [], false)));
        }

        return view('member.favorites', [
            "user" => $req->user(),
        ]);
    }

    public function messages(Request $req): RedirectResponse|View
    {
        if (!Auth::check()) {
            return redirect('/login?back=' . urlencode(route('messages', [], false)));
        }

        return view('member.messages', [
            "user" => $req->user(),
        ]);
    }
}
