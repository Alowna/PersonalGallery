<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteController;


Route::get('/', function () {
    return view('login');
});

Route::get( '/', [SiteController::class, 'index'])->name(name: 'site.index');
//LOGIN ROUTE
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);

//AUTH

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [SiteController::class, 'dashboard']);
    Route::post('/logout', [LoginController::class, 'logout']);
});


