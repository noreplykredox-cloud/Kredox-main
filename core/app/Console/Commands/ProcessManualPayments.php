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
            if ($payment->type === 'user') {
                $this->processUserPayment($payment);
            } elseif ($payment->type === 'plan') {
                $this->processPlanPayment($payment);
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

    private function processPlanPayment($payment)
    {
        $users = User::where('plan_id', $payment->plan_id)->get();
        if ($users->isEmpty()) return;

        foreach ($users as $user) {
            $user->balance += $payment->amount;
            $user->save();

            $this->pushTransaction([
                'user_id'      => $user->id,
                'amount'       => $payment->amount,
                'post_balance' => $user->balance,
                'trx_type'     => '+',
                'details'      => ucfirst($payment->frequency) . ' Plan Payment: ' . $payment->description,
                'remark'       => 'manual_payment',
            ]);

            $this->info("✅ Credited ₹{$payment->amount} to user {$user->username} (Plan ID: {$payment->plan_id})");
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