<?php 

namespace App\Http\Controllers;

use App\Models\Comment;


class SiteController extends Controller
{
    public function dashboard()
    {
        return view(view: 'dashboard');
    }

    public function index()
    {
        $comments = Comment::with('user')->latest()->get();

        return view('gallery', compact('comments'));
    }

}



?>