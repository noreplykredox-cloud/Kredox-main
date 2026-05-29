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
            'minimum_investment' => 'required|numeric|min:0',
            'maximum_investment' => 'required|numeric|gt:minimum_investment',
            'referral_percentage' => 'required|numeric|between:0,100',
            'level' => 'required|array',
            'level.*' => 'numeric|between:0,100',
            'daily_referral_start_time' => 'nullable|date',
            'daily_referral_exclude_weekends' => 'nullable|integer|in:0,1',
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->minimum_investment = $request->minimum_investment;
        $plan->maximum_investment = $request->maximum_investment;
        $plan->referral_percentage = $request->referral_percentage;
        $plan->daily_referral_enabled = $request->daily_referral_enabled ?? 0;
        $plan->daily_referral_start_time = $request->daily_referral_start_time;
        $plan->daily_referral_exclude_weekends = $request->has('daily_referral_exclude_weekends') ? 1 : 0;
        $plan->is_level_commission = $request->is_level_commission ?? 0;
        $plan->require_otp = $request->has('require_otp') ? 1 : 0;
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
            'minimum_investment' => 'required|numeric|min:0',
            'maximum_investment' => 'required|numeric|gt:minimum_investment',
            'referral_percentage' => 'required|numeric|between:0,100',
            'level' => 'required|array',
            'level.*' => 'numeric|between:0,100',
            'daily_referral_start_time' => 'nullable|date',
            'daily_referral_exclude_weekends' => 'nullable|integer|in:0,1',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->name = $request->name;
        $plan->minimum_investment = $request->minimum_investment;
        $plan->maximum_investment = $request->maximum_investment;
        $plan->referral_percentage = $request->referral_percentage;
        $plan->daily_referral_enabled = $request->daily_referral_enabled ?? 0;
        $plan->daily_referral_start_time = $request->daily_referral_start_time;
        $plan->daily_referral_exclude_weekends = $request->has('daily_referral_exclude_weekends') ? 1 : 0;
        $plan->is_level_commission = $request->is_level_commission ?? 0;
        $plan->require_otp = $request->has('require_otp') ? 1 : 0;
        $plan->save();

        $this->levelUpdate($request, $plan);
        $this->dailyReferralLevelUpdate($request, $plan);
        $this->manualPaymentUpdate($request, $plan);

        return back()->with('success', 'Plan updated successfully.');
    }

    private function levelUpdate($request, $plan)
    {
        Level::where('plan_id', $plan->id)->delete();
        foreach ($request->level as $level => $percent) {
            Level::create([
                'plan_id' => $plan->id,
                'level' => $level,
                'percentage' => $percent,
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
            if (!isset($entry->description, $entry->start_time, $entry->frequency)) continue;

            $frequency = $entry->frequency;
            $percentage = isset($entry->percentage) ? floatval($entry->percentage) : 0;
            $monthlyDay = null;
            $excludeWeekends = 0;
            $selectedMonth = null;
            $monthlyPercentage = null;

            if ($frequency === 'monthly_target') {
                $frequency = 'daily';
                $selectedMonth = $entry->selected_month ?? null;
                $monthlyPercentage = isset($entry->monthly_percentage) ? floatval($entry->monthly_percentage) : 0;
                $excludeWeekends = isset($entry->exclude_weekends) ? intval($entry->exclude_weekends) : 0;

                if ($selectedMonth && $monthlyPercentage > 0) {
                    $calcMonth = ($selectedMonth === 'all') ? now()->format('Y-m') : $selectedMonth;
                    $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', $calcMonth);
                    $totalDays = $carbonMonth->daysInMonth;
                    $workingDays = 0;

                    if ($excludeWeekends) {
                        $tempDate = $carbonMonth->copy()->startOfMonth();
                        $endDate = $carbonMonth->copy()->endOfMonth();
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

                    $percentage = $daysCount > 0 ? ($monthlyPercentage / $daysCount) : 0;
                }
            } elseif ($frequency === 'monthly') {
                $monthlyDay = $entry->monthly_day ?? null;
            }

            $data = [
                'percentage' => $percentage,
                'description' => $entry->description,
                'start_time' => $entry->start_time,
                'frequency' => $frequency,
                'monthly_day' => $monthlyDay,
                'exclude_weekends' => $excludeWeekends,
                'selected_month' => $selectedMonth,
                'monthly_percentage' => $monthlyPercentage,
            ];

            if (!empty($entry->id)) {
                // UPDATE existing
                ManualPayment::where('id', $entry->id)->update($data);
            } else {
                // CREATE new
                $data['plan_id'] = $plan->id;
                $data['type'] = 'plan';
                $data['status'] = 'active';
                ManualPayment::create($data);
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

    public function delete($id)
    {
        $plan = Plan::findOrFail($id);

        // Cascade Delete related records
        Level::where('plan_id', $plan->id)->delete();
        ManualPayment::where('plan_id', $plan->id)->delete();
        DailyReferralLevel::where('plan_id', $plan->id)->delete();

        $plan->delete();

        $notify[] = ['success', 'Investment plan and all related records deleted successfully.'];
        return back()->withNotify($notify);
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