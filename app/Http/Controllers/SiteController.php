<?php 

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;


class SiteController extends Controller
{
    public function dashboard()
    {
        return view(view: 'dashboard');
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        $comments = Comment::with('user')->latest()->get();

        return view('gallery', compact('posts', 'comments'));
    }

}



?>