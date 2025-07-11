<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'route_number',
        'hauler_id',
        'destination_plant'
    ];
}
