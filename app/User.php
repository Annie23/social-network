<?php

namespace App;

use App\Models\Friend;
use App\Models\Image;
use App\Models\Message;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function sentMessage()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receivedMessage()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    //user send requests
    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friends',
            'user_id', 'friend_id');
    }

    //user's received requests from other users
    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friends',
            'friend_id', 'user_id');
    }

    //user all friends
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted', 1)->get()
            ->merge($this->friendOf()->wherePivot('accepted', 1)->get());
    }

    public function addFriend(User $user)
    {
        $this->friendsOfMine()->update(
            [
                'user_id' => $user->id,
                'accepted' => 0
            ]
        );
    }

    public function friendRequestsPending()
    {
        $requests = $this->friendOf()
            ->wherePivot('accepted', 0)
            ->get();

        return $requests->first() ? $requests->all() : null;
    }

    public function getFriendRequestsPendingAttribute()
    {
        return $this->friendRequestsPending();
    }

    public function acceptFriendRequest($user)
    {
        $this->friendOf()
            ->wherePivot('accepted', 0)
            ->wherePivot('user_id', $user->id)
            ->first()->pivot
            ->update([
                'accepted' => 1
            ]);
    }

    public function rejectFriendRequest($user)
    {
        $this->friendOf()->detach($user->id);
    }

    public function getProfilePic()
    {
        return $this->images()->where([
            ['user_id', $this->id],
            ['profile_pic', 1]
        ])->first();
    }

    public function getIsNotFriendAttribute()
    {
        return $this->friendsOfMine()->wherePivot('accepted','!==', 1)->get()
            ->merge($this->friendOf()->wherePivot('accepted', '!==',1)->get())->first();
    }
}
