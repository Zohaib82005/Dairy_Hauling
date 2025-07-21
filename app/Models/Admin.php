<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'address',
        'shipp_number',
        'role'
    ];
}
