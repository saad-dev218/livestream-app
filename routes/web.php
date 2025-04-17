<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\LivestreamController;
use App\Http\Controllers\HomeController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/livestream/{slug}', [FrontController::class, 'show'])->name('front.livestream.show');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('livestreams', LivestreamController::class);
});
