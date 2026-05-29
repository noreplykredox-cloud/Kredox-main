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

    public function getDetailsAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        // Format Plan Investment (e.g. Limitless Wealth Plan investment made -> Successfully Invested in Limitless Wealth Plan)
        if (preg_match('/(.*?) investment made/i', $value, $matches)) {
            return "Successfully Invested in " . trim($matches[1]);
        }

        // Format Deposit Via (e.g. Deposit Via BEP 20 -> Deposit Credited Successfully via BEP 20)
        if (preg_match('/Deposit Via (.*)/i', $value, $matches)) {
            return "Deposit Credited Successfully via " . trim($matches[1]);
        }

        // Format Withdrawal (e.g. 10.00 USDT Withdraw Via BEP 20 -> Withdrawal via BEP 20 (From: Active Investment | Remaining Investment: 400.00 USDT))
        if (preg_match('/(.*?) Withdraw Via (.*)/i', $value, $matches)) {
            $method = trim($matches[2]);
            $general = gs();
            $curText = $general ? $general->cur_text : 'USD';
            
            if ($this->remark === 'investment_withdrawal') {
                if ($this->id) {
                    $invested = Transaction::where('user_id', $this->user_id)
                        ->where('remark', 'like', '%plan_purchase%')
                        ->where('id', '<=', $this->id)
                        ->sum('amount');
                    
                    $withdrawn = Transaction::where('user_id', $this->user_id)
                        ->where('remark', 'investment_withdrawal')
                        ->where('id', '<=', $this->id)
                        ->sum('amount');
                    $rejected = Transaction::where('user_id', $this->user_id)
                        ->where('remark', 'investment_withdraw_reject')
                        ->where('id', '<=', $this->id)
                        ->sum('amount');
                    $remaining = $invested - ($withdrawn - $rejected);
                } else {
                    $user = (auth()->check() && auth()->id() == $this->user_id) ? auth()->user() : $this->user;
                    $remaining = $user ? $user->invest_amount : 0;
                }
                
                $remainingStr = showAmount($remaining);
                return "Withdrawal via {$method} (From: Active Investment | Remaining Investment: {$remainingStr} {$curText})";
            } else {
                return "Withdrawal via {$method} (From: Current Balance)";
            }
        }

        if (stripos($value, 'Plan ROI') !== false) {
            $parts = explode(':', $value);
            $prefix = trim($parts[0]);
            
            $dateStr = $this->created_at ? $this->created_at->format('d M Y') : now()->format('d M Y');
            
            $user = (auth()->check() && auth()->id() == $this->user_id) ? auth()->user() : $this->user;
            $general = gs();
            
            $investAmount = $user ? showAmount($user->invest_amount) : '0.00';
            $curText = $general ? $general->cur_text : 'USD';
            
            return "{$prefix} (Credited on: {$dateStr} | Your Investment: {$investAmount} {$curText})";
        }

        if (preg_match('/Direct Income from (\w+)\s*\(([\d\.]+)\s*(\w+)\s*Invested\)/i', $value, $matches)) {
            $username = $matches[1];
            $amount = $matches[2];
            $currency = $matches[3];
            return "Direct Referral Income (From: {$username} | Invested: {$amount} {$currency})";
        }

        // Remove " - Ref Trx #..."
        $value = preg_replace('/\s*-\s*Ref\s*Trx\s*#\d+/i', '', $value);
        
        // Remove ": Success! ..."
        return preg_replace('/:\s*Success!.*/i', '', $value);
    }


}
