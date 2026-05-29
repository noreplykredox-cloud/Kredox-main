<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status', Status::ENABLE)->get();
        $pageTitle = 'Withdraw Money';
        
        $user = auth()->user();
        $totalInvestment = $user->invest_amount;

        return view($this->activeTemplate . 'user.withdraw.methods', compact('pageTitle', 'withdrawMethod', 'totalInvestment'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric',
            'withdrawal_type' => 'nullable|in:1,2'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', Status::ENABLE)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $message = 'Your requested amount is smaller than minimum amount.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            $notify[] = ['error', $message];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $message = 'Your requested amount is larger than maximum amount.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            $notify[] = ['error', $message];
            return back()->withNotify($notify);
        }

        if ($request->withdrawal_type == 2) {
            $totalInvestment = $user->invest_amount;
            if ($request->amount > $totalInvestment) {
                $message = 'Your requested amount is larger than your current active investment.';
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                $notify[] = ['error', $message];
                return back()->withNotify($notify);
            }
        } else {
            if ($request->amount > $user->balance) {
                $message = 'You do not have sufficient balance for withdraw.';
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $message]);
                }
                $notify[] = ['error', $message];
                return back()->withNotify($notify);
            }
        }

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);

        if ($request->withdrawal_type == 2) {
            $charge += ($request->amount * $method->investment_charge / 100);
        }
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->withdraw_type = $request->withdrawal_type ?? 1;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'withdraw' => $withdraw,
                'method_name' => $method->name,
                'gateway_description' => $method->description,
                'form_id' => $method->form_id
            ]);
        }

        return to_route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        
        $savedWallets = \App\Models\UserWallet::where('user_id', auth()->id())->orderBy('id', 'desc')->get();
        
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle', 'withdraw', 'savedWallets'));
    }

    public function manageWallets()
    {
        $pageTitle = 'Manage Saved Wallets';
        $savedWallets = \App\Models\UserWallet::where('user_id', auth()->id())->orderBy('id', 'desc')->get();
        return view($this->activeTemplate . 'user.withdraw.wallets', compact('pageTitle', 'savedWallets'));
    }

    public function saveWallet(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'address' => 'required|string'
        ]);

        $userId = auth()->id();

        // Check if this address already exists for this user (updating existing)
        $exists = \App\Models\UserWallet::where('user_id', $userId)
            ->where('address', $request->address)
            ->exists();

        if (!$exists) {
            // Count total saved wallets for this user
            $count = \App\Models\UserWallet::where('user_id', $userId)->count();
            if ($count >= 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only save up to 2 wallet addresses. Please delete an existing address to save a new one.'
                ]);
            }
        }

        $wallet = \App\Models\UserWallet::updateOrCreate(
            [
                'user_id' => $userId,
                'address' => $request->address
            ],
            [
                'label' => $request->label
            ]
        );

        return response()->json([
            'success' => true,
            'wallet' => $wallet,
            'message' => 'Wallet address saved successfully'
        ]);
    }

    public function deleteWallet($id)
    {
        $wallet = \App\Models\UserWallet::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $wallet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Wallet address deleted successfully'
        ]);
    }

    public function getWallets()
    {
        $wallets = \App\Models\UserWallet::where('user_id', auth()->id())->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'wallets' => $wallets
        ]);
    }

    public function withdrawSubmit(Request $request)
    {
        $withdraw = Withdrawal::with('method', 'user')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();

        $method = $withdraw->method;
        if ($method->status == Status::DISABLE) {
            abort(404);
        }

        $formData = $method->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user, $request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }

        if ($withdraw->withdraw_type == 1 && $withdraw->amount > $user->balance) {
            $notify[] = ['error', 'Your request amount is larger than your current balance.'];
            return back()->withNotify($notify);
        }
        if ($withdraw->withdraw_type == 2 && $withdraw->amount > $user->invest_amount) {
            $notify[] = ['error', 'Your request amount is larger than your active investment.'];
            return back()->withNotify($notify);
        }

        $withdraw->status = Status::PAYMENT_PENDING;
        $withdraw->withdraw_information = $userData;
        $withdraw->save();
        if ($withdraw->withdraw_type == 1) {
            $user->balance -= $withdraw->amount;
            $user->save();
        } elseif ($withdraw->withdraw_type == 2) {
            $user->invest_amount -= $withdraw->amount;
            if ($user->invest_amount <= 0) {
                $user->invest_amount = 0;
                $user->plan_id = null;
            }
            $user->save();
        }

        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx = $withdraw->trx;
        $transaction->remark = $withdraw->withdraw_type == 2 ? 'investment_withdrawal' : 'withdraw';
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from ' . $user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details', $withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Withdraw request sent successfully'
            ]);
        }

        return to_route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog(Request $request)
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', auth()->id())->where('status', '!=', Status::PAYMENT_INITIATE);
        if ($request->search) {
            $withdraws = $withdraws->where('trx', $request->search);
        }
        $withdraws = $withdraws->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.withdraw.log', compact('pageTitle', 'withdraws'));
    }
}
