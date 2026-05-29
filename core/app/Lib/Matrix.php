<?php

namespace App\Lib;

use App\Models\Transaction;
use App\Models\User;
use Exception;

class Matrix
{
    /**
    * User who purchase the plan
    *
    * @var object
    */
    private $user;


    /**
    * Plan which has purchased by the user
    *
    * @var object
    */
    private $plan;


    /**
    * Matrix height
    *
    * @var integer
    */
    private $height;


    /**
    * Matrix width
    *
    * @var integer
    */
    private $width;


    /**
    * Investment amount
    *
    * @var decimal
    */
    private $amount;


    /**
    * All transactions data of this process
    *
    * @var array
    */
    private $transactions = [];


    /**
    * Transaction number of transactions
    *
    * @var array
    */
    private $trx;


    /**
    * Set the user and plan object to properties
    *
    * @param object $user
    * @param object $plan
    * @param decimal $amount
    *
    * @return void
    */
    public function __construct($user,$plan,$amount)
    {
        $general = gs();
        $this->user = $user;
        $this->plan = $plan;
        $this->amount = $amount;
        $this->height = $general->matrix_height;
        $this->width = $general->matrix_width;
        $this->trx = getTrx();

        //throw exception
        $this->getException();
    }

    /**
     * Purchase user plan (Investment)
     *
     * @return void;
     */
    public function planPurchase()
    {
        $user = $this->user;
        $plan = $this->plan;
        $amount = $this->amount;

        $user->plan_id = $plan->id;
        $user->invest_amount += $amount;
        $user->balance -= $amount;
        $user->save();

        //push to transactions
        $this->pushTransaction([
            'user_id'=>$user->id,
            'ref_by'=>$user->ref_by,
            'amount'=>$amount,
            'post_balance'=>$user->balance,
            'trx_type'=>'-',
            'details'=>$plan->name.' investment made',
            'remark'=>'plan_purchase'
        ]);

        $this->getPosition();
        $this->referralCommission();
        $this->levelCommission();
        $this->storeTransactions();

        try {
            notify($user, 'PLAN_PURCHASED', [
                'currency' => gs()->cur_text,
                'trx' => $this->trx,
                'price' => showAmount($amount),
                'plan_name' =>  $plan->name,
                'post_balance' => showAmount($user->balance),
            ]);
        } catch (\Exception $e) {
            // Silently fail notification to ensure investment completes
        }
    }

    /**
     * Set the position of the user
     *
     * @return boolean;
     */
    public function getPosition()
    {
        if (!$this->user->ref_by || $this->user->position_id){
            return false;
        }

        $user = $this->user;
        $referral = $this->user->referral;
        $isBreak = false;

        // Direct position
        $nextPosition = $this->nextPosition($referral->id);

        if($nextPosition){
            $user->position_id  = $referral->id;
            $user->position     = $nextPosition;
            $user->save();
            return true;
        }

        for ($level=1; $level < 100 ; $level++) {

            $myref = $this->showPositionBelow($referral->id);

            $next =   $myref;
            for ($i=1; $i < $level ; $i++) {
                $next = array();
                foreach($myref as $uu){
                    $n = $this->showPositionBelow($uu);
                    $next = array_merge($next, $n);
                }
                $myref = $next;
            }

            foreach($next as $uu){
                $nextPosition = $this->nextPosition($uu);
                if($nextPosition){
                    $user->position_id = $uu;
                    $user->position = $nextPosition;
                    $user->save();
                    $isBreak = true;
                }
                if($isBreak){
                    break;
                }
            }
            if($isBreak){
                break;
            }
        }
    }

    /**
    * Get all immediate below users
    *
    * @param integer $id
    * @return array
    */
    private function showPositionBelow($id){
       return User::where('position_id',$id)->pluck('id')->toArray();
    }

    /**
    * Get the next position
    *
    * @param integer $id
    * @return integer
    */
    private function nextPosition($id){
        $count = User::where('position_id', $id)->count();

        if($count < $this->width){
            return $count+1;
        }
        return 0;
    }

    /**
    * Give direct referral commission to referrer
    *
    * @return void
    */
    public function referralCommission(){

        $user = $this->user;
        $referral = $user->referral;
        $plan = $this->plan;
        
        if ($referral && $plan->referral_percentage > 0) {
            $bonus = ($this->amount * $plan->referral_percentage / 100);
            $referral->balance += $bonus;
            $referral->save();

            //Push to transactions
            $this->pushTransaction([
                'user_id'=>$referral->id,
                'ref_by'=>$referral->ref_by,
                'amount'=> showAmount($bonus),
                'post_balance'=> showAmount($referral->balance),
                'trx_type'=>'+',
                'remark'=>'referral_commission',
                'details'=>'Direct Income from '.$user->username.' ('.showAmount($this->amount).' '.gs()->cur_text.' Invested)',
            ]);

            notify($referral, 'REFERRAL_COMMISSION', [
                'amount' => showAmount($bonus),
                'username' => $user->username,
                'currency' => gs()->cur_text,
                'trx' => $this->trx,
                'post_balance' => showAmount($referral->balance),
            ]);
        }
    }

    /**
    * Give direct level commission to upper
    *
    * @return void
    */
    public function levelCommission()
    {
        // Check if level commission is enabled in the plan
        if (empty($this->plan->is_level_commission) || $this->plan->is_level_commission != 1) {
            return;
        }

        $user = $this->user;
        $levels = $this->plan->level;

        for ($i = 0; $i < $this->height; $i++) {
            $levelInfo = @$levels[$i];
            if (!$levelInfo || $levelInfo->percentage <= 0) {
                break;
            }

            $upper = $user->upper;
            if (!$upper) {
                break;
            }

            $requiredReferrals = $i + 1; // Level N requires N direct referrals
            $actualReferrals = \App\Models\User::where('ref_by', $upper->id)->count();

            if ($actualReferrals < $requiredReferrals) {
                $user = $upper; // Move up the tree even if commission is skipped
                continue; // Skip commission if not enough direct referrals
            }

            $bonus = ($this->amount * $levelInfo->percentage / 100);
            $upper->balance += $bonus;
            $upper->save();

            $this->pushTransaction([
                'user_id' => $upper->id,
                'ref_by' => $upper->ref_by,
                'amount' => showAmount($bonus),
                'post_balance' => showAmount($upper->balance),
                'trx_type' => '+',
                'remark' => 'level_commission',
                'details' => 'Level ' . ($i + 1) . ' Income from ' . $user->username.' ('.showAmount($this->amount).' '.gs()->cur_text.' Invested)',
            ]);

            $user = $upper; // Move to next level up
        }
    }

    /**
    * Push all transaction data to transactions
    *
    * @param array $data
    * @return void
    */
    private function pushTransaction($data){
        $transactions[] = [
            'user_id' => $data['user_id'],
            'ref_by' => $data['ref_by'],
           
            'amount' => $data['amount'],
            'post_balance' => $data['post_balance'],
            'charge' => 0,
            'trx_type' => $data['trx_type'],
            'details' => $data['details'],
            'remark' => @$data['remark'],
            'trx' => $this->trx,
            'created_at' => now(),
        ];
        $this->transactions = array_merge($this->transactions, $transactions);
    }

    /**
    * Store transactions to database
    *
    * @param array $data
    * @return void
    */
    public function storeTransactions(){
        $transactions = $this->transactions;
        Transaction::insert($transactions);
    }

    /**
    * All exception of this process
    *
    * @return void
    */
    private function getException(){
        if ($this->amount < $this->plan->minimum_investment) {
            $message = 'Minimum investment for this plan is ' . showAmount($this->plan->minimum_investment) . ' ' . gs()->cur_text;
            $this->throwException($message);
        }

        if ($this->plan->maximum_investment > 0 && $this->amount > $this->plan->maximum_investment) {
            $message = 'Maximum investment for this plan is ' . showAmount($this->plan->maximum_investment) . ' ' . gs()->cur_text;
            $this->throwException($message);
        }

        if ($this->user->balance < $this->amount) {
            $message = 'You don\'t have sufficient balance';
            $this->throwException($message);
        }
    }

    /**
    * All exception will throw from here
    *
    * @return void
    */
    private function throwException($message){
        throw new Exception($message);
    }
}


