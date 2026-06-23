<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    public function index()
    {
        return view(view: 'register');
    }

    public function store(RegisterRequest $request)
    {
        
        $gender = $request->input('gender');

        if ($gender === 'other') {
            $gender = $request->input('gender_other');
        }
        $user = User::query()->create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'gender' => $gender,
        ]);

        Auth::login($user);

        return redirect()->route('site.index');

    }
}
