<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteController;


Route::get('/', function () {
    return view('login');
});

Route::get( '/', [SiteController::class, 'index'])->name(name: 'site.index');
//LOGIN ROUTE
Route::get('/login', [LoginController::class, 'index'])->name('site.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.login');

//AUTH

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [SiteController::class, 'dashboard'])->name('site.dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');
});


