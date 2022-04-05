<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/auth/fb-redirect', [AuthController::class, 'fbRedirect']);
Route::get('/auth/fb-callback', [AuthController::class, 'fbCallback']);
Route::get('/member/profile', [MemberController::class, 'profile'])->name('profile');
Route::get('/member/ads', [MemberController::class, 'ads'])->name('my-ads');
Route::get('/member/favorites', [MemberController::class, 'favorites'])->name('favorites');
Route::get('/member/messages', [MemberController::class, 'messages'])->name('messages');

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/terms', [IndexController::class, 'terms'])->name('terms');
Route::get('/new-ad', [AdController::class, 'newAd'])->name('new-ad');
Route::post('/new-ad', [AdController::class, 'newAdPost']);
Route::post('/image-upload', [AdController::class, 'upload']);
Route::get('/activate', [PaymentController::class, 'activate']);
Route::get('/edit-ad/{id}', [AdController::class, 'editAd'])
    ->where('id', '[0-9]+')->name('edit-ad');
Route::post('/edit-ad/{id}', [AdController::class, 'editAdPost'])
    ->where('id', '[0-9]+');

Route::get('/_/{cat}/{title}/{id}', [CatalogController::class, 'showAd'])
    ->where('cat', '[a-z\-]+')
    ->where('title', '[a-z0-9\-]+')
    ->where('id', '[0-9]+')
    ->name('show-ad');
