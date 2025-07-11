<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $fillable = [
        'name',
        'farm_id',
        'patron_id',
        'latitude',
        'longitude',
        'route_id'
    ];
}
