<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;


class CommentController extends Controller
{


    
    public function store(CommentRequest $request)
    {
        $user = $request->user(); // Get the authenticated user
        $comment = new Comment();
        $comment->user_id = $user->id; // Only works with middleware auth, otherwise it will throw an error
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
    
        if ($comment->user_id !== $comment->user->id)
        {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
