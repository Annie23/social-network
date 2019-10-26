<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message'
    ];

    public function userSender()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function userReceiver()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }


}
