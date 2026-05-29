<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ManualPayment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class ProcessManualPayments extends Command
{
    protected $signature = 'manual:payments';
    protected $description = 'Process scheduled manual and recurring payments for users and plans';

    protected $transactions = [];
    protected $trx;

    public function handle()
    {
        $now = Carbon::now();
        $this->trx = getTrx();

        $payments = ManualPayment::where('status', 'active')
            ->where('start_time', '<=', $now)
            ->whereTime('start_time', '<=', $now->toTimeString())
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    // Daily payments
                    $q->where('frequency', 'daily')
                        ->where(function ($subQ) use ($now) {
                            $subQ->whereNull('last_credited_at')
                                ->orWhereDate('last_credited_at', '<', $now->toDateString());
                        });
                })->orWhere(function ($q) use ($now) {
                    // Monthly payments
                    $q->where('frequency', 'monthly')
                        ->where('monthly_day', $now->day)
                        ->where(function ($subQ) use ($now) {
                            $subQ->whereNull('last_credited_at')
                                ->orWhereDate('last_credited_at', '<', $now->toDateString());
                        });
                });
            })
            ->get();

        foreach ($payments as $payment) {
            // Check if it is a monthly calculated payment and only run in the selected month
            if ($payment->selected_month && $payment->selected_month !== 'all') {
                if ($now->format('Y-m') !== $payment->selected_month) {
                    continue;
                }
            }

            // Check if weekends should be excluded
            if ($payment->exclude_weekends) {
                if ($now->isWeekend()) {
                    $this->info("⏭️ Skipped execution for payment ID {$payment->id} because weekends are excluded.");
                    continue;
                }
            }

            // Dynamically calculate daily percentage if recurring monthly target is active
            if ($payment->selected_month === 'all' && $payment->monthly_percentage > 0) {
                $totalDays = $now->daysInMonth;
                $workingDays = 0;

                if ($payment->exclude_weekends) {
                    $tempDate = $now->copy()->startOfMonth();
                    $endDate = $now->copy()->endOfMonth();
                    while ($tempDate->lte($endDate)) {
                        if (!$tempDate->isWeekend()) {
                            $workingDays++;
                        }
                        $tempDate->addDay();
                    }
                    $daysCount = $workingDays;
                } else {
                    $daysCount = $totalDays;
                }

                $dynamicPercentage = $daysCount > 0 ? ($payment->monthly_percentage / $daysCount) : 0;
                $payment->percentage = $dynamicPercentage;
            }

            if ($payment->type === 'user') {
                $this->processUserPayment($payment);
            } elseif ($payment->type === 'plan') {
                $this->processPlanPayment($payment, $now);
            }
        }

        $this->storeTransactions();
        return Command::SUCCESS;
    }

    private function processUserPayment($payment)
    {
        $user = User::find($payment->user_id);
        if (!$user) return;

        $user->balance += $payment->amount;
        $user->save();

        $this->pushTransaction([
            'user_id'      => $user->id,
            'amount'       => $payment->amount,
            'post_balance' => $user->balance,
            'trx_type'     => '+',
            'details'      => ucfirst($payment->frequency) . ' Payment: ' . $payment->description,
            'remark'       => 'manual_payment',
        ]);

        $payment->last_credited_at = now();
        $payment->save();

        $this->info("✅ Credited ₹{$payment->amount} to user {$user->username} (Manual Payment)");
    }

    private function processPlanPayment($payment, $now)
    {
        $users = User::where('plan_id', $payment->plan_id)->where('invest_amount', '>', 0)->get();
        if ($users->isEmpty()) return;

        foreach ($users as $user) {
            // Deduplication: skip if user was already paid today for this plan ROI description
            $alreadyPaidToday = Transaction::where('user_id', $user->id)
                ->where('remark', 'manual_payment')
                ->where('details', 'like', '%Plan ROI%')
                ->where('details', 'like', '%' . $payment->description . '%')
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyPaidToday) {
                $this->info("⏭️ Skipped {$user->username} because they were already paid today.");
                continue;
            }

            $amount = ($user->invest_amount * $payment->percentage / 100);
            if ($amount <= 0) continue;

            $user->balance += $amount;
            $user->save();

            // Construct precise and highly transparent transaction details
            if ($payment->monthly_percentage > 0) {
                if ($payment->selected_month === 'all') {
                    $monthLabel = $now->format('F Y');
                } else {
                    $monthLabel = \Carbon\Carbon::parse($payment->selected_month)->format('F Y');
                }
                $details = "Plan ROI - " . $monthLabel . ": " . $payment->description;
            } else {
                $details = ucfirst($payment->frequency) . ' Plan ROI (' . getAmount($payment->percentage) . '%): ' . $payment->description;
            }

            $this->pushTransaction([
                'user_id'      => $user->id,
                'amount'       => $amount,
                'post_balance' => $user->balance,
                'trx_type'     => '+',
                'details'      => $details,
                'remark'       => 'manual_payment',
            ]);

            $this->info("✅ Credited " . gs()->cur_sym . "{$amount} to user {$user->username} (ROI)");
        }

        $payment->last_credited_at = now();
        $payment->save();
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