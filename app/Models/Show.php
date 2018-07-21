<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'created_at',
        'updated_at',
        'start_time',
        'title',
        'description',
        'run_time_in_minutes',
        'show_image_header'
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'start_time'
    ];
}
