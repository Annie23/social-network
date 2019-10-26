<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'profile_pic'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
