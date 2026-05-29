<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\Matrix;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Transaction;

class PlanController extends Controller
{

    public function plan()
    {
        $pageTitle = "Invest Funds";
        $plan = Plan::where('status', Status::ENABLE)->orderBy('id', 'asc')->first();
        if (!$plan) {
            $notify[] = ['error', 'Investment system is currently unavailable'];
            return back()->withNotify($notify);
        }

        $user = auth()->user();
        $totalInvest = $user->invest_amount;
        $totalReceived = Transaction::where('user_id', $user->id)
            ->where('trx_type', '+')
            ->whereIn('remark', ['referral_commission', 'level_commission', 'manual_payment', 'daily_referral'])
            ->sum('amount');

        $totalPotential = $totalInvest * 3;
        $remaining = $totalPotential - $totalReceived;
        if ($remaining < 0)
            $remaining = 0;

        return view($this->activeTemplate . 'plan', compact('pageTitle', 'plan', 'totalInvest', 'totalReceived', 'totalPotential', 'remaining'));
    }

    public function planOrder(Request $request, $id)
    {
        set_time_limit(60);
        $plan = Plan::with('level')->findOrFail($id);

        // Only validate and check OTP if the plan requires it
        if ($plan->require_otp) {
            $request->validate([
                'amount' => 'required|numeric|min:0',
                'otp'    => 'required|digits:6'
            ]);

            if ($request->otp != session()->get('invest_otp')) {
                return response()->json(['status' => 'error', 'message' => 'Invalid OTP code. Please check your email and try again.']);
            }

            session()->forget('invest_otp');
        } else {
            $request->validate([
                'amount' => 'required|numeric|min:0',
            ]);
        }

        $user = User::with('referral')->find(auth()->id());

        try {
            $matrix = new Matrix($user, $plan, $request->amount);
        } catch (\Exception $exp) {
            $notify[] = ['error', $exp->getMessage()];
            if (request()->ajax()) {
                return response()->json(['status' => 'error', 'message' => $exp->getMessage()]);
            }
            return back()->withNotify($notify);
        }

        try {
            $matrix->planPurchase();
        } catch (\Exception $exp) {
            return response()->json(['status' => 'error', 'message' => $exp->getMessage()]);
        }

        $user->refresh();
        $totalInvest = $user->invest_amount;
        $totalReceived = Transaction::where('user_id', $user->id)
            ->where('trx_type', '+')
            ->whereIn('remark', ['referral_commission', 'level_commission', 'manual_payment', 'daily_referral'])
            ->sum('amount');

        $totalPotential = $totalInvest * 3;
        $remaining = $totalPotential - $totalReceived;
        if ($remaining < 0)
            $remaining = 0;

        $notify[] = ['success', 'Investment has been made successfully'];
        if (request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Investment has been made successfully',
                'summary' => [
                    'balance' => showAmount($user->balance),
                    'totalInvest' => showAmount($totalInvest),
                    'totalReceived' => showAmount($totalReceived),
                    'totalPotential' => showAmount($totalPotential),
                    'remaining' => showAmount($remaining)
                ]
            ]);
        }
        return back()->withNotify($notify);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);

        $user = auth()->user();

        if ($request->amount > $user->balance) {
            return response()->json(['status' => 'error', 'message' => 'Insufficient balance for this investment.']);
        }

        $otp = rand(100000, 999999);
        session()->put('invest_otp', $otp);

        notify($user, 'INVESTMENT_OTP', [
            'otp' => $otp,
            'amount' => showAmount($request->amount),
            'currency' => gs()->cur_sym,
            'fullname' => $user->fullname
        ]);

        return response()->json(['status' => 'success', 'message' => 'Verification code sent to your email address.']);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        if ($request->otp == session()->get('invest_otp')) {
            return response()->json(['status' => 'success', 'message' => 'Code verified successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid verification code.']);
    }
}
