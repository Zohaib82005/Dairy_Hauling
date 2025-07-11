<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    protected $fillable = [
        'hauler_id',
        'trailer_id',
        'capacity'
    ];
}
