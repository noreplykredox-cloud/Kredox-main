<?php

// app/Models/DailyReferralLevel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReferralLevel extends Model
{
    protected $fillable = ['plan_id', 'level', 'percentage'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}