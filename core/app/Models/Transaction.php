<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Searchable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function trans()
    {
        return $this->hasMany(Transaction::class,'ref_by')->where('remark', 'Like', '%plan_purchase%');
    }

    public function transallReferrals(){
        return $this->trans()->with('transallReferrals');
    }

}
