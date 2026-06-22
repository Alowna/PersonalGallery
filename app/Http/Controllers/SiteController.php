<?php 

namespace App\Http\Controllers;


class SiteController extends Controller
{
    public function dashboard()
    {
        return view(view: 'dashboard');
    }

    public function index()
    {
        return view(view: '/gallery');
    }
}






?>