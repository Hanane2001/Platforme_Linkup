<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\User;

class FriendController extends Controller
{
    public function send(User $user){
        auth()->user()->sendFriendRequestTo($user);
        return back();
    }

    public function accept(FriendRequest $friendRequest){
        if ($friendRequest->receiver_id !== auth()->id()) {
            abort(403);
        }
        $friendRequest->accept();
        return back()->with('success', 'Demande acceptée');
    }

    public function reject(FriendRequest $friendRequest){
        if ($friendRequest->receiver_id !== auth()->id()) {
            abort(403);
        }
        $friendRequest->reject();
        return back()->with('success', 'Demande refusée');
    }

    public function remove(User $user){
        $authUser = auth()->user();
        if (! $authUser->isFriendWith($user)) {
            return redirect()->route('dashboard')->with('error', 'Vous n’êtes pas amis.');
        }
        $authUser->removeFriend($user);
        return redirect()->route('dashboard')->with('success', 'Ami supprimé avec succès.');
    }
}
