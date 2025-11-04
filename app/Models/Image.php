<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=[
        'path',
        'size',
        'imageable_id',
        'imageable_type',

    ];

    // ^relacion p0olimorifica
    public function imageable()
    {
        return $this->morphTo();
    }
}
