<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $fillable = [
        'plant_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'email'
        
    ];
}
