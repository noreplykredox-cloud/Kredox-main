<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Level, Plan, DailyReferralLevel, ManualPayment};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = "All Plan List";
        $plans = Plan::with(['level', 'dailyReferralLevels'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.plan.index', compact('pageTitle', 'plans'));
    }

    public function create()
    {
        $pageTitle = "Create Plan";
        return view('admin.plan.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|min:0',
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->referral_bonus = $request->referral_bonus;
        $plan->daily_referral_enabled = $request->daily_referral_enabled ?? 0;
        $plan->is_level_commission = $request->is_level_commission ?? 0;
        $plan->save();

        $this->levelUpdate($request, $plan);
        $this->dailyReferralLevelUpdate($request, $plan);
        $this->manualPaymentUpdate($request, $plan);

        return back()->with('success', 'Plan created successfully.');
    }

    public function edit($id)
    {
        $plan = Plan::with('dailyReferralLevels')->findOrFail($id);
        $pageTitle = "Edit Plan";
        $manualPayments = ManualPayment::where('plan_id', $plan->id)->where('type', 'plan')->get();
        $totalAmount = $plan->sumLevelOfCommission($plan->id) + $plan->referral_bonus;
        $finalAmount = $plan->price - $totalAmount;

        return view('admin.plan.edit', compact('pageTitle', 'plan', 'manualPayments', 'totalAmount', 'finalAmount'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|gt:0',
            'referral_bonus' => 'required|numeric|gt:0',
            'level' => 'required|array',
            'level.*' => 'numeric|min:0',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->referral_bonus = $request->referral_bonus;
        $plan->daily_referral_enabled = $request->daily_referral_enabled ?? 0;
        $plan->is_level_commission = $request->is_level_commission ?? 0;
        $plan->save();

        $this->levelUpdate($request, $plan);
        $this->dailyReferralLevelUpdate($request, $plan);
        $this->manualPaymentUpdate($request, $plan);

        return back()->with('success', 'Plan updated successfully.');
    }

    private function levelUpdate($request, $plan)
    {
        Level::where('plan_id', $plan->id)->delete();
        foreach ($request->level as $level => $amount) {
            Level::create([
                'plan_id' => $plan->id,
                'level' => $level,
                'amount' => $amount,
            ]);
        }
    }

    private function dailyReferralLevelUpdate($request, $plan)
    {
        if ($plan->daily_referral_enabled && $request->has('level_payout')) {
            DailyReferralLevel::where('plan_id', $plan->id)->delete();
            foreach ($request->level_payout as $level => $percent) {
                if ($percent > 0) {
                    DailyReferralLevel::create([
                        'plan_id' => $plan->id,
                        'level' => $level,
                        'percentage' => $percent,
                    ]);
                }
            }
        }
    }

    private function manualPaymentUpdate($request, $plan)
    {
        if (!$request->has('manual_payments')) return;

        foreach ($request->manual_payments as $entry) {
            $entry = (object) $entry;

            // Skip incomplete rows
            if (!isset($entry->amount, $entry->description, $entry->start_time, $entry->frequency)) continue;

            if (!empty($entry->id)) {
                // UPDATE existing
                ManualPayment::where('id', $entry->id)->update([
                    'amount' => $entry->amount,
                    'description' => $entry->description,
                    'start_time' => $entry->start_time,
                    'frequency' => $entry->frequency,
                    'monthly_day' => $entry->frequency === 'monthly' ? ($entry->monthly_day ?? null) : null,
                ]);
            } else {
                // CREATE new
                ManualPayment::create([
                    'plan_id' => $plan->id,
                    'type' => 'plan',
                    'amount' => $entry->amount,
                    'description' => $entry->description,
                    'start_time' => $entry->start_time,
                    'frequency' => $entry->frequency,
                    'monthly_day' => $entry->frequency === 'monthly' ? ($entry->monthly_day ?? null) : null,
                    'status' => 'active',
                ]);
            }
        }
    }

    public function deleteManualPayment($id)
    {
        $payment = ManualPayment::findOrFail($id);
        $payment->delete();
        return back()->with('success', 'Manual payment deleted.');
    }

    public function status($id)
    {
        return Plan::changeStatus($id);
    }

    public function matrixSetting(Request $request)
    {
        $request->validate([
            'matrix_height' => 'required|integer|gt:0',
            'matrix_width' => 'required|integer|gt:0'
        ]);

        $general = gs();
        $general->matrix_height = $request->matrix_height;
        $general->matrix_width = $request->matrix_width;
        $general->save();

        return back()->with('success', 'Matrix setting has been updated');
    }
}