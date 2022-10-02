<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function loginPost(Request $req): JsonResponse
    {
        $validator = Validator::make($req->post(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        try {
            $validator->validate();
        } catch (Exception $e) {
            return response()->json(["message" => $validator->errors()->first()], 400);
        }

        if (!Auth::attempt($req->only(['email', 'password']))) {
            return response()->json(["message" => "Invalid login details"], 401);
        }

        return response()->json(['status' => 'OK']);
    }

    public function register(): View
    {
        return view('auth.register', []);
    }

    public function registerPost(Request $req): JsonResponse
    {
        $validator = Validator::make($req->post(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        try {
            $validated = $validator->validate();
        } catch (Exception $e) {
            return response()->json(["message" => $validator->errors()->first()], 400);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return response()->json(['status' => 'OK']);
    }

    public function login(): View
    {
        return view('auth.login', []);
    }

    public function forgot(): View
    {
        return view('auth.forgot', []);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }

    public function fbRedirect(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function fbCallback(): RedirectResponse
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();
            $user = User::where('fb_id', $fbUser->id)->first();

            if (!$user) {
                $user = User::where('email', $fbUser->email)->first();
                if ($user) {
                    $user->fb_id = $fbUser->id;
                    $user->save();
                }
            }

            if (!$user) {
                $user = User::create([
                    'name' => $fbUser->name,
                    'email' => $fbUser->email,
                    'password' => Hash::make(substr(md5(rand()), 0, 10)),
                    'fb_id' => $fbUser->id,
                ]);
            }

            Auth::login($user);
            return redirect(route('profile'));
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
