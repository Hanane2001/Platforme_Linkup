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

    public function friendsRelation(){
        $userId = $this->id;
        return User::whereIn('id', function ($query) use ($userId) {
            $query->select('receiver_id')
                ->from('friend_requests')
                ->where('sender_id', $userId)
                ->where('status', 'accepted')
                ->union(
                    DB::table('friend_requests')
                        ->select('sender_id')
                        ->where('receiver_id', $userId)
                        ->where('status', 'accepted')
                );
        });
    }
    public function friends(){
        return $this->friendsRelation()->get();
    }

    public function isFriendWith(User $user){
        return $this->friendsRelation()->where('id', $user->id)->exists();
    }

    public function hasPendingRequestTo(User $user){
        return FriendRequest::where('sender_id', $this->id)
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    public function sendFriendRequestTo(User $user): void{
        if ($this->id === $user->id) return;

        FriendRequest::firstOrCreate(['sender_id' => $this->id, 'receiver_id' => $user->id,], ['status' => 'pending']);
    }

    public function removeFriend(User $user): void{
        FriendRequest::where(function ($q) use ($user) {
            $q->where('sender_id', $this->id)
            ->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
            ->where('receiver_id', $this->id);
        })->where('status', 'accepted')->delete();
    }
}