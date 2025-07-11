<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farm_stop_scan extends Model
{
    protected $fillable = [
        'tracking_id',
        'tank_id',
        'farm_id',
        'patron_id',
        'collected_milk',
        'ticket_id',
        'method',
        'temprature',
        'user_id',
        'created_at'
    ];
}
