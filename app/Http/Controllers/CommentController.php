<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post){
        $request->validate(['content' => 'required|string|max:500']);
        // $post->comments()->create(['user_id' => auth()->id(), 'content' => $request->content]);
        Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);
        return back();
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();
        return back();
    }
}
