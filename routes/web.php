<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/search', [IndexController::class, 'search'])->name('search')->middleware('auth:sanctum');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/terms', [IndexController::class, 'terms'])->name('terms');
Route::get('/new-ad', [AdController::class, 'newAd'])->name('new-ad');
Route::post('/new-ad', [AdController::class, 'postAd']);
Route::post('/image-upload', [AdController::class, 'upload']);
