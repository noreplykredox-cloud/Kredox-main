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
        $now = Carbon::now();

        $this->info("Running daily referral payout command...");

        // Scan downline ROI transactions from the last 7 days to process any pending daily referrals
        $targetStartDate = Carbon::now()->subDays(7)->startOfDay();

        $roiTransactions = Transaction::where('remark', 'manual_payment')
            ->where('details', 'like', '%Plan ROI%')
            ->where('created_at', '>=', $targetStartDate)
            ->orderBy('id', 'asc')
            ->get();

        if ($roiTransactions->isEmpty()) {
            $this->warn("No eligible downline Plan ROI transactions found in the last 7 days.");
            return Command::SUCCESS;
        }

        $this->info("Found " . $roiTransactions->count() . " ROI transactions to check.");

        foreach ($roiTransactions as $trx) {
            $downlineUser = User::find($trx->user_id);
            if (!$downlineUser) continue;

            $uplines = $this->getUplineUsers($downlineUser);

            foreach ($uplines as $level => $upline) {
                // Check if upline has an active investment
                if ($upline->invest_amount <= 0) continue;

                // Check if Daily Referral Payout is active for this upline's plan
                $plan = $upline->plan;
                if (!$plan || !$plan->daily_referral_enabled) continue;

                // Check plan-specific start time for daily referral payouts
                if ($plan->daily_referral_start_time) {
                    $startTime = Carbon::parse($plan->daily_referral_start_time);
                    if ($startTime->gt($now)) {
                        $this->info("⏭️ Skipped Level " . ($level + 1) . " commission for {$upline->username} because daily referral start time is in the future.");
                        continue;
                    }

                    // Scheduled time for this specific transaction on its day of creation
                    $trxDate = Carbon::parse($trx->created_at);
                    $scheduledTime = Carbon::parse($trxDate->toDateString() . ' ' . $startTime->toTimeString());

                    if ($now->lt($scheduledTime)) {
                        $this->info("⏭️ Skipped Level " . ($level + 1) . " commission for {$upline->username} because scheduled time for this transaction (" . $scheduledTime->format('Y-m-d g:i A') . ") has not been reached yet.");
                        continue;
                    }
                }

                // Check plan-specific weekend exclusion
                if ($plan->daily_referral_exclude_weekends && $now->isWeekend()) {
                    $this->info("⏭️ Skipped Level " . ($level + 1) . " commission for {$upline->username} because today is a weekend and the plan excludes weekends.");
                    continue;
                }

                // Check if this upline has already been paid today for this downline and level
                $alreadyPaidToday = Transaction::where('user_id', $upline->id)
                    ->where('remark', 'daily_referral')
                    ->where('details', 'like', "Level Income {$downlineUser->username} (Level " . ($level + 1) . ")%")
                    ->whereDate('created_at', Carbon::today())
                    ->exists();

                if ($alreadyPaidToday) {
                    $this->info("⏭️ Skipped Level " . ($level + 1) . " commission for {$upline->username} because they were already paid today for downline {$downlineUser->username}.");
                    continue;
                }

                // Check if this specific downline transaction was already processed for this upline
                $refDetails = "Ref Trx #{$trx->id}";
                $alreadyPaid = Transaction::where('user_id', $upline->id)
                    ->where('remark', 'daily_referral')
                    ->where('details', 'like', "%{$refDetails}%")
                    ->exists();

                if ($alreadyPaid) {
                    continue;
                }

                // Condition: To receive Level N income, the upline must have at least N direct referrals
                $requiredDirects = $level + 1;
                $directsCount = User::where('ref_by', $upline->id)->count();

                if ($directsCount < $requiredDirects) {
                    $this->info("⏭️ Skipped Level " . ($level + 1) . " commission for {$upline->username} because they have {$directsCount} directs (requires {$requiredDirects}).");
                    continue;
                }

                $referralPercent = DailyReferralLevel::where('plan_id', $upline->plan_id)
                    ->where('level', $level + 1)
                    ->value('percentage');

                if ($referralPercent && $referralPercent > 0) {
                    $bonus = ($trx->amount * $referralPercent) / 100;
                    if ($bonus <= 0) continue;

                    $upline->balance += $bonus;
                    $upline->save();

                    $this->pushTransaction([
                        'user_id'      => $upline->id,
                        'amount'       => $bonus,
                        'post_balance' => $upline->balance,
                        'trx_type'     => '+',
                        'details'      => "Level Income {$downlineUser->username} (Level " . ($level + 1) . ") - {$refDetails}",
                        'remark'       => 'daily_referral',
                    ]);

                    $this->info("✅ Credited {$bonus} to {$upline->username} from {$downlineUser->username} at Level " . ($level + 1) . " for Trx #{$trx->id}");
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