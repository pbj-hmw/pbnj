<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\Uuids;

class RecipeItem extends Model
{
    use Uuids;

    public $incrementing = false;

    public $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'description',
        'image_link'
    ];

    public $dates = [
        'created_at',
        'updated_at'
    ];

    public function shows() {
        return $this->belongsToMany('App\Models\Show');
    }
}
