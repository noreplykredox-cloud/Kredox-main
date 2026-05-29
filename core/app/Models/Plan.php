<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Level;
use App\Models\DailyReferralLevel;
use App\Traits\GlobalStatus;

class Plan extends Model
{
    use GlobalStatus;

    public function level()
    {
        return $this->hasMany(Level::class);
    }

    public function dailyReferralLevels()
    {
        return $this->hasMany(DailyReferralLevel::class);
    }

    public function sumLevelOfCommission($planId, $amount = 0)
    {
        $general = gs();
        $totalPercentage = Level::where('plan_id', $planId)
                    ->where('level', '<=', $general->matrix_height)
                    ->sum('percentage');
        
        if ($amount > 0) {
            return ($amount * $totalPercentage / 100);
        }
        return $totalPercentage;
    }

    public function totalLevel($planId)
    {
        $general = gs();
        return Level::where('plan_id', $planId)
                    ->where('level', '<=', $general->matrix_height)
                    ->get();
    }
}