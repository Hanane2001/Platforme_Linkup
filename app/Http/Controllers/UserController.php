<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user){
        $authUser = auth()->user();
        if ($authUser->id !== $user->id && ! $authUser->isFriendWith($user)) {
            abort(403);
        }
        return view('users.show', compact('user'));
    }
}
