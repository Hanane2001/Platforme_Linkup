<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;

class FriendController extends Controller
{
    public function send($id){
        if($id == auth()->id()){
            return back();
        }
        $exists = FriendRequest::where(function ($q) use ($id){
            $q->where('sender_id', auth()->id())->where('receiver_id', $id);
        })->orwhere(function ($q) use($id){
            $q->where('sender_id', $id)->where('receiver_id', auth()->id());
        })->exists();
        if($exists){
            return back();
        }
        FriendRequest::create(['sender_id' => auth()->id(), 'receiver_id' => $id, 'status' => 'pending']);
        return back();
    }

    public function accept($id){
        $friendRequest = FriendRequest::where('id', $id)->where('receiver_id', auth()->id())->firstOrFail();
        $friendRequest->accept();
        return back();
    }

    public function reject($id){
        $friendRequest = FriendRequest::where('id', $id)->where('reciever_id', auth()->id())->firstOrFail();
        $friendRequest->reject();
        return back();
    }
}
