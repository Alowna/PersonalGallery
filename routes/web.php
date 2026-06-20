<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return view('gallery');
});

//LOGIN ROUTE
Route::get('/login', [LoginController::class, 'index']);