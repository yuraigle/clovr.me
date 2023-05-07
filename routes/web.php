<?php

use App\Helpers\AdUrl;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
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

Route::get('/profile/details', [ProfileController::class, 'details'])->name('profile');
Route::post('/profile/details', [ProfileController::class, 'detailsPost']);
Route::get('/profile/security', [ProfileController::class, 'security'])->name('security');
Route::get('/profile/my-items', [ProfileController::class, 'ads'])->name('my-items');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('favorites');
Route::get('/profile/messages', [ProfileController::class, 'messages'])->name('messages');

Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/terms', [PagesController::class, 'terms'])->name('terms');

Route::get('/new', [MemberController::class, 'newAd'])->name('new-ad');
Route::post('/new', [MemberController::class, 'newAdPost']);

Route::post('/image-upload', [MemberController::class, 'upload']);
Route::get('/activate', [PaymentController::class, 'activate']);
Route::get('/edit-ad/{id}', [MemberController::class, 'editAd'])
    ->where('id', '[0-9]+')->name('edit-ad');
Route::post('/edit-ad/{id}', [MemberController::class, 'editAdPost'])
    ->where('id', '[0-9]+');

Route::get('/', [CatalogController::class, 'home'])->name('home');

Route::get('/_/{cat}/{title}/{id}', [CatalogController::class, 'showAd'])
    ->where('cat', '[a-z\-]+')
    ->where('title', '[a-z0-9\-]+')
    ->where('id', '[0-9]+')
    ->name('show-ad');

Route::get('/{cat}/{propType?}', [CatalogController::class, 'showCat'])
    ->where('cat', join('|', AdUrl::$CATS))
    ->where('propType', 'house|flat|other|garage|parking')
    ->name('show-cat');

Route::get('/search', [CatalogController::class, 'search'])->name('search');
Route::get('/markers', [CatalogController::class, 'markers']);

Route::get('/member', function () {
    return redirect('/member/profile');
})->name('member');
Route::post('/member/avatar', [ProfileController::class, 'avatarUpload']);
