<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires',
        'valid'
    ];

    protected $dates = [
        'expires'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
