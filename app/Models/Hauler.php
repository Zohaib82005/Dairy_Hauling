<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hauler extends Model
{
    protected $fillable = [
        'name',
        'address',
        'shipp_number'
    ];
}
