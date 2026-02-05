<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(Post $post){
        $existingLike = $post->likes()->where('user_id', auth()->id())->first();
        
        if (!$existingLike) {
            $post->likes()->create(['user_id' => auth()->id()]);
        }
        
        return back();
    }

    public function destroy(Post $post){
        $post->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}
