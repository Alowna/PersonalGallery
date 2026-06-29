<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('login');
});

Route::get( '/', [SiteController::class, 'index'])->name(name: 'site.index');
//LOGIN ROUTE
Route::get('/login', [LoginController::class, 'index'])->name('site.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.login');

//REGISTER ROUTE
Route::get('/register', [RegisterController::class, 'index'])->name('site.register');
Route::post('/register', [RegisterController::class, 'store'])->name('auth.register');

//AUTH

Route::middleware('auth')->group(function () {

    //login authenticated routes
    Route::get('/dashboard', [SiteController::class, 'dashboard'])->name('site.dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    //Comment Routes
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});


