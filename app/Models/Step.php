<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuids;

class Step extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'description',
        'step_number',
        'show_id'
    ];

    public $dates = [
        'created_at',
        'updated_at'
    ];

    public function show()
    {
        return $this->belongsTo('App\Models\Show');
    }
}
