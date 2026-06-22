<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    //GET /login
    public function index()
    {
        return view( view: 'login');
    }
    //POST /login
    public function authenticate(Request $request)
    {
        //dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if(Auth::attempt($credentials))
            {
                $request->session()->regenerate();

                return redirect()->intended(route('site.index'));
            }


        
            return back()->withErrors([
                'email' , 'password' => 'Invalid Credentials',                 
            ]);
            
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('site.index'));
    }

    
}
