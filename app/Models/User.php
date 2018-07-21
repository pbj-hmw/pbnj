<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'phone_number'
    ];

    public function authCode()
    {
        return $this->hasOne('App\Models\AuthCode');
    }
}
