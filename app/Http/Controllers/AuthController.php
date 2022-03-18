<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function login()
    {
        return view('auth.login', []);
    }

    public function loginPost(Request $req): JsonResponse
    {
        $validator = Validator::make($req->post(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        try {
            $validated = $validator->validate();
        } catch (Exception $e) {
            return response()->json(["message" => $validator->errors()->first()], 400);
        }

        if (!Auth::attempt($req->only(['email', 'password']))) {
            return response()->json(["message" => "Invalid login details"], 401);
        }

        $user = User::where('email', $validated['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'OK',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function register()
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

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'OK',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function forgot()
    {
        return view('auth.forgot', []);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
