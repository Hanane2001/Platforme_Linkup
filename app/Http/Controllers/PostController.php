<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request){
        $request->validate(['description' => 'nullable|string|max:1000', 'post_photo' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048']);
        $path = null;
        if($request->hasFile('post_photo')){
            $path = $request->file('post_photo')->store('posts', 'public');
        }
        auth()->user()->posts()->create(['description' => $request->description, 'post_photo' => $path]);
        return back();
    }

    public function destroy(Post $post){
        if($post->user_id !== auth()->id()){
            abort(403);
        }
        $post->delete();
        return back()->with('success', 'Post supprimé');
    }
}
