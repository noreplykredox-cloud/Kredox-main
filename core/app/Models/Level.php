<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'plan_id',
        'level',
        'amount',
        'percentage',
    ];
}