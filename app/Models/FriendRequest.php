<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class FriendRequest extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'status',];
    
    public function sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function isPending(): bool{
        return $this->status == 'pending';
    }

    public function isAccepted(): bool{
        return $this->status == 'accepted';
    }

    public function isRejected(): bool{
        return $this->status == 'rejected';
    }

    public function accept(): void
    {
        $this->update(['status' => 'accepted']);
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }
}
