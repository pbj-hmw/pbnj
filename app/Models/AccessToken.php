<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $fillable = [
        'user_id',
        'access_token',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
