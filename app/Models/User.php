<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\FriendRequest;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'pseudo',
        'bio',
        'email',
        'profile_photo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sentFriendRequests(){
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function receiveFriendRequests(){
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

    public function friends(){
        return User::whereIn('id', function ($query) {
            $query->select('receiver_id')
                ->from('friend_requests')
                ->where('sender_id', auth()->id())
                ->where('status', 'accepted')
                ->union(DB::table('friend_requests')
                        ->select('sender_id')
                        ->where('receiver_id', auth()->id())
                        ->where('status', 'accepted'));
        })->get();
    }
}