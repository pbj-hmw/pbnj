<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Uuids;

    protected $fillable = [
        'id',
        'username',
        'phone_number'
    ];

    public $incrementing = false;

    public function authCode()
    {
        return $this->hasMany('App\Models\AuthCode');
    }

    public function accessToken()
    {
        return $this->hasOne('App\Models\AccessToken');
    }
}
