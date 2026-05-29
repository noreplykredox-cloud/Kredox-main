<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Transaction;
use App\Models\DailyReferralLevel;
use Carbon\Carbon;

class ProcessDailyReferralPayout extends Command
{
    protected $signature = 'payout:daily-referral';
    protected $description = 'Distribute daily referral commissions to uplines based on downline income';

    protected $trx;
    protected array $transactions = [];

    public function handle()
  {
      $this->trx = getTrx();
      $yesterday = Carbon::yesterday()->toDateString();

      $this->info("Running daily referral payout for date: $yesterday");

      // Get users who received any eligible payment yesterday
      $downlineUsers = User::whereHas('transactions', function ($q) use ($yesterday) {
              $q->whereDate('created_at', $yesterday)
                ->where(function ($query) {
                    $query->where('remark', 'like', '%manual_payment%')
                        ->orWhere('remark', 'like', 'daily_referral')
                        ->orWhere('remark', 'like', '%level%commission%')
                        ->orWhere('remark', 'like', '%referral_commission%');
                });
          })
          ->get();

      if ($downlineUsers->isEmpty()) {
          $this->warn("No users found with valid transactions on $yesterday.");
          return Command::SUCCESS;
      }

      foreach ($downlineUsers as $user) {
          // Sum all eligible earnings for the user
          $earned = Transaction::where('user_id', $user->id)
              ->whereDate('created_at', $yesterday)
              ->where(function ($query) {
                  $query->where('remark', 'like', '%manual_payment%')
                      ->orWhere('remark', 'like', 'daily_referral')
                      ->orWhere('remark', 'like', '%level%commission%')
                      ->orWhere('remark', 'like', '%referral_commission%');
              })
              ->sum('amount');

          if ($earned <= 0) continue;

          $uplines = $this->getUplineUsers($user);

          foreach ($uplines as $level => $upline) {
              if (!$upline->plan_id) continue;

              $referralPercent = DailyReferralLevel::where('plan_id', $user->plan_id)
                  ->where('level', $level + 1)
                  ->value('percentage');

              if ($referralPercent && $referralPercent > 0) {
                  $bonus = ($earned * $referralPercent) / 100;
                  $upline->balance += $bonus;
                  $upline->save();

                  $this->pushTransaction([
                      'user_id'      => $upline->id,
                      'amount'       => $bonus,
                      'post_balance' => $upline->balance,
                      'trx_type'     => '+',
                      'details'      => "Daily Referral Bonus from {$user->username} (Level " . ($level + 1) . ")",
                      'remark'       => 'daily_referral',
                  ]);

                  $this->info("Credited {$bonus} to {$upline->username} from {$user->username} at Level " . ($level + 1));
              }
          }
      }

      $this->storeTransactions();
      return Command::SUCCESS;
  }

    private function getUplineUsers($user)
    {
        $uplines = [];
        $current = $user;
        $level = 0;
        $matrixHeight = gs()->matrix_height;

        while ($current->ref_by && $level < $matrixHeight) {
            $upline = User::with('plan')->find($current->ref_by);
            if (!$upline) break;

            $uplines[$level] = $upline;
            $current = $upline;
            $level++;
        }

        return $uplines;
    }

    private function pushTransaction($data)
    {
        $this->transactions[] = [
            'user_id'      => $data['user_id'],
            'amount'       => $data['amount'],
            'post_balance' => $data['post_balance'],
            'charge'       => 0,
            'trx_type'     => $data['trx_type'],
            'details'      => $data['details'],
            'remark'       => $data['remark'] ?? null,
            'trx'          => $this->trx,
            'created_at'   => now(),
        ];
    }

    private function storeTransactions()
    {
        if (!empty($this->transactions)) {
            Transaction::insert($this->transactions);
        }
    }
}