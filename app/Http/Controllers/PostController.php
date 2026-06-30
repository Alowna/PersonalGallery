<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Http\Requests\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $user = $request->user(); // Get the authenticated user
        $post = new Post();
        $post->user_id = $user->id; // Only works with middleware auth, otherwise it will throw an error
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->image = $request->input('image'); // Get the image URL from the request
        $post->save();

        return redirect()->back()->with('success', 'Post added successfully.');
    }

    public function destroy(Post $post)
    {
    
        if ($post->user_id !== $post->user->id)
        {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }
}
