<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualPayment extends Model
{
    protected $fillable = [
      'user_id',
      'amount',
      'description',
      'start_time',
      'status',
      'last_credited_at',
      'frequency',
      'monthly_day',
      'type',
      'plan_id'
  ];
}