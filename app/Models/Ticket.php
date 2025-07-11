<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'route_id',
        'truck_id',
        'trailer_id',
        'pickup_date',
        'signature',
        'status',
        'user_id'
    ];
}
