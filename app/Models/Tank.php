<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $fillable = [
        'farm_id',
        'tank_id',
        'type',
        'height',
        'width',
        'radius',
        'length',
        'capacity'
    ];
}
