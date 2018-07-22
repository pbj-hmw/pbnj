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
        'runtime',
        'show_image_header',
        'calories',
        'started',
        'finished',
        'chat_sid'
    ];

    public $dates = [
        'created_at',
        'updated_at',
        'start_time'
    ];

    public function recipeItems()
    {
        return $this->belongsToMany('App\Models\RecipeItem');
    }

    public function steps()
    {
        return $this->hasMany('App\Models\Step')->orderBy('step_number', 'asc');
    }

    public function currentStep()
    {
        return $this->hasOne('App\Models\Step', 'id', 'current_step_id');
    }
}
