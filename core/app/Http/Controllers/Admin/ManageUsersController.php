<?php
namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\ManualPayment;
use App\Models\Commission;
use App\Models\Deposit;
use App\Models\NotificationLog;
use App\Models\Pin;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\DailyReferralLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ManageUsersController extends Controller
{ 
    public function manualPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'start_time' => 'required|date|after_or_equal:now',
            'frequency' => 'required|in:daily,monthly',
            'monthly_day' => 'nullable|integer|min:1|max:30|required_if:frequency,monthly',
        ]);

        $user = User::findOrFail($id);

        ManualPayment::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'description' => $request->description,
            'start_time' => Carbon::parse($request->start_time),
            'status' => 'active',
            'frequency' => $request->frequency ?? 'daily',
            'monthly_day' => $request->frequency === 'monthly' ? ($request->monthly_day ?? null) : null,
        ]);

        $notify[] = ['success', 'Manual payment added successfully.'];
        return back()->withNotify($notify);
    }
    public function manualPayments()
      {
          return $this->hasMany(ManualPayment::class);
      }
  
  public function toggleManualPayment($id)
{
    $payment = ManualPayment::findOrFail($id);
    $payment->status = $payment->status === 'active' ? 'inactive' : 'active';
    $payment->save();

    $notify[] = ['success', 'Payment status updated successfully.'];
    return back()->withNotify($notify);
}
public function deleteManualPayment($id)
{
    $payment = ManualPayment::findOrFail($id);
    $payment->delete();

    $notify[] = ['success', 'Manual payment deleted successfully.'];
    return back()->withNotify($notify);
}
public function updateManualPayment(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:0.01',
        'description' => 'required|string',
        'start_time' => 'required|date|after_or_equal:now',
        'frequency' => 'required|in:daily,monthly',
        'monthly_day' => 'nullable|integer|between:1,30'
    ]);

    $payment = ManualPayment::findOrFail($id);
    $payment->amount = $request->amount;
    $payment->description = $request->description;
    $payment->start_time = $request->start_time;
    $payment->frequency = $request->frequency;
    $payment->monthly_day = $request->monthly_day;
    $payment->save();

    $notify[] = ['success', 'Manual payment updated successfully.'];
    return back()->withNotify($notify);
}

    public function allUsers()
    {
        $pageTitle = 'All Users';
        $users = $this->userData();
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function activeUsers()
    {
        $pageTitle = 'Active Users';
        $users = $this->userData('active');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function bannedUsers()
    {
        $pageTitle = 'Banned Users';
        $users = $this->userData('banned');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailUnverifiedUsers()
    {
        $pageTitle = 'Email Unverified Users';
        $users = $this->userData('emailUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function kycUnverifiedUsers()
    {
        $pageTitle = 'KYC Unverified Users';
        $users = $this->userData('kycUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function kycPendingUsers()
    {
        $pageTitle = 'KYC Unverified Users';
        $users = $this->userData('kycPending');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function emailVerifiedUsers()
    {
        $pageTitle = 'Email Verified Users';
        $users = $this->userData('emailVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function mobileUnverifiedUsers()
    {
        $pageTitle = 'Mobile Unverified Users';
        $users = $this->userData('mobileUnverified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function mobileVerifiedUsers()
    {
        $pageTitle = 'Mobile Verified Users';
        $users = $this->userData('mobileVerified');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    public function usersWithBalance()
    {
        $pageTitle = 'Users with Balance';
        $users = $this->userData('withBalance');
        return view('admin.users.list', compact('pageTitle', 'users'));
    }


    protected function userData($scope = null){
        if ($scope) {
            $users = User::$scope();
        }else{
            $users = User::query();
        }
        return $users->searchable(['username','email'])->orderBy('id','desc')->paginate(getPaginate());
    }


    public function detail($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = 'User Detail - '.$user->username;

        $totalDeposit = Deposit::where('user_id',$user->id)->where('status',Status::PAYMENT_SUCCESS)->sum('amount');
        $totalWithdrawals = Withdrawal::where('user_id',$user->id)->where('status',Status::PAYMENT_SUCCESS)->sum('amount');
        $totalTransaction = Transaction::where('user_id',$user->id)->count();

        $totalReferralCommission = Commission::where('user_id',$user->id)->where('mark',1)->sum('amount');
        $totalLevelCommission = Commission::where('user_id',$user->id)->where('mark',2)->sum('amount');
        $totalPinGenerate = Pin::where('generate_user_id',$user->id)->count();
        $totalUsedPin = Pin::where('user_id',$user->id)->where('status', Status::ENABLE)->count();

        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $maxDepth = gs()->matrix_height ?? 10;
        
        // Calculate root user stats recursively
        $rootTeamStats = $this->getTeamStats($user);
        $user->team_count = $rootTeamStats['team_count'];

        // Get root active schedules
        $rootSchedules = [];
        $now = Carbon::now();
        if ($user->plan_id) {
            $schedules = ManualPayment::where('plan_id', $user->plan_id)
                ->where('type', 'plan')
                ->where('status', 'active')
                ->get();
            foreach ($schedules as $sched) {
                $dailyPercentage = $sched->percentage;
                $calcMonthlyAmount = 0;
                $targetPercentage = '';
                $targetPayout = '';

                if ($sched->monthly_percentage > 0) {
                    $calcMonth = ($sched->selected_month === 'all') ? now()->format('Y-m') : $sched->selected_month;
                    $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', $calcMonth);
                    $totalDays = $carbonMonth->daysInMonth;
                    $workingDays = 0;

                    if ($sched->exclude_weekends) {
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

                    $dailyPercentage = $daysCount > 0 ? ($sched->monthly_percentage / $daysCount) : 0;
                    $calcMonthlyAmount = $user->invest_amount * ($sched->monthly_percentage / 100);
                    $targetPercentage = $sched->monthly_percentage . '% (Target)';
                    $targetPayout = 'Target: ' . gs()->cur_sym . showAmount($calcMonthlyAmount);
                }

                $calcDailyAmount = $user->invest_amount * ($dailyPercentage / 100);

                $statusAndNext = $this->getScheduleStatusAndNextRun($sched);

                $rootSchedules[] = [
                    'schedule_id' => $sched->id,
                    'description' => $sched->description,
                    'amount' => showAmount($dailyPercentage, 6) . '% (Daily)',
                    'target_percentage' => $targetPercentage,
                    'payout_amount' => gs()->cur_sym . showAmount($calcDailyAmount),
                    'target_payout' => $targetPayout,
                    'frequency' => ucfirst($sched->frequency),
                    'next_run' => $statusAndNext['next_run'],
                    'exclude_weekends' => $sched->exclude_weekends ? 'Yes' : 'No',
                    'badge_class' => 'bg-success text-white',
                    'status' => $statusAndNext['status'],
                    'status_class' => $statusAndNext['status_class']
                ];
            }
        }
        $userSchedules = ManualPayment::where('user_id', $user->id)
            ->where('type', 'user')
            ->where('status', 'active')
            ->get();
        foreach ($userSchedules as $sched) {
            $statusAndNext = $this->getScheduleStatusAndNextRun($sched);
            $rootSchedules[] = [
                'schedule_id' => $sched->id,
                'description' => $sched->description . ' (User Specific Direct Payout)',
                'amount' => 'Flat / Fixed',
                'target_percentage' => '',
                'payout_amount' => gs()->cur_sym . showAmount($sched->amount),
                'target_payout' => '',
                'frequency' => ucfirst($sched->frequency),
                'next_run' => $statusAndNext['next_run'],
                'exclude_weekends' => $sched->exclude_weekends ? 'Yes' : 'No',
                'badge_class' => 'bg-info text-white',
                'status' => $statusAndNext['status'],
                'status_class' => $statusAndNext['status_class']
            ];
        }
        $levelSchedules = $this->getLevelIncomeSchedules($user, $maxDepth);
        $rootSchedules = array_merge($rootSchedules, $levelSchedules);
        $user->schedules = $rootSchedules;

        $downlineTree = $this->getDownlineTree($user, 1, $maxDepth);
        $orgChartData = $this->flattenTreeForOrgChart($user, $downlineTree);
        $orgChartJson = json_encode($orgChartData);

        return view('admin.users.detail', compact('pageTitle', 'user','totalDeposit','totalWithdrawals','totalTransaction', 'totalReferralCommission', 'totalLevelCommission', 'totalPinGenerate', 'totalUsedPin', 'countries', 'downlineTree', 'orgChartJson'));
    }

    public function referralCommission(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Search User Referral Commissions : ' . $user->username;
            $commissions = Commission::where('user_id', $user->id)->where('trx', $search)->where('mark', 1)->with('user')->orderBy('id','desc')->paginate(getPaginate());
            $emptyMessage = 'No Commissions';
            return view('admin.reports.commissions', compact('pageTitle', 'search', 'commissions', 'emptyMessage'));
        }
        $pageTitle = "Referral Commissions Log - ".$user->username;
        $emptyMessage = "No commissions found";
        $commissions = Commission::with('user')->where('user_id', $user->id)->where('mark', 1)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'emptyMessage'));
    }

    public function levelCommission(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Search User Level Commissions : ' . $user->username;
            $commissions = Commission::where('user_id', $user->id)->where('trx', $search)->where('mark', 2)->with('user')->orderBy('id','desc')->paginate(getPaginate());
            $emptyMessage = 'No Commissions';
            return view('admin.reports.commissions', compact('pageTitle', 'search', 'commissions', 'emptyMessage'));
        }
        $pageTitle = "Level Commissions Log - ".$user->username;
        $emptyMessage = "No commissions found";
        $commissions = Commission::with('user')->where('user_id', $user->id)->where('mark', 2)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.commissions', compact('pageTitle', 'commissions', 'emptyMessage'));
    }

    public function generatePin($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = "Generate pin - ". $user->username;
        $emptyMessage = "No data found";
        $pins = Pin::where('generate_user_id', $user->id)->latest()->paginate(getPaginate());
        return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }


    public function kycDetails($id)
    {
        $pageTitle = 'KYC Details';
        $user = User::findOrFail($id);
        return view('admin.users.kyc_detail', compact('pageTitle','user'));
    }

    public function usedPin($id)
    {
        $user = User::findOrFail($id);
        $pageTitle = "Used pin - ". $user->username;
        $emptyMessage = "No data found";
        $pins = Pin::where('user_id', $user->id)->latest()->paginate(getPaginate());
        return view('admin.pin.index', compact('pageTitle', 'emptyMessage', 'pins'));
    }

    public function kycApprove($id)
    {
        $user = User::findOrFail($id);
        $user->kv = 1;
        $user->save();

        notify($user,'KYC_APPROVE',[]);

        $notify[] = ['success','KYC approved successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }

    public function kycReject($id)
    {
        $user = User::findOrFail($id);
        foreach ($user->kyc_data as $kycData) {
            if ($kycData->type == 'file') {
                fileManager()->removeFile(getFilePath('verify').'/'.$kycData->value);
            }
        }
        $user->kv = 0;
        $user->kyc_data = null;
        $user->save();

        notify($user,'KYC_REJECT',[]);

        $notify[] = ['success','KYC rejected successfully'];
        return to_route('admin.users.kyc.pending')->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryArray   = (array)$countryData;
        $countries      = implode(',', array_keys($countryArray));

        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            'email' => 'required|email|string|max:40|unique:users,email,' . $user->id,
            'mobile' => 'required|string|max:40|unique:users,mobile,' . $user->id,
            'country' => 'required|in:'.$countries,
        ]);

        $countryCode    = $request->country;
        $country        = $countryData->$countryCode->country;
        $dialCode       = $countryData->$countryCode->dial_code;
        $user->mobile = $dialCode.$request->mobile;
        $user->country_code = $countryCode;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->address = [
                            'address' => $request->address,
                            'city' => $request->city,
                            'state' => $request->state,
                            'zip' => $request->zip,
                            'country' => @$country,
                        ];
        $user->ev = $request->ev ? 1 : 0;
        $user->sv = $request->sv ? 1 : 0;
        $user->ts = $request->ts ? 1 : 0;
        if (!$request->kv) {
            $user->kv = 0;
            if ($user->kyc_data) {
                foreach ($user->kyc_data as $kycData) {
                    if ($kycData->type == 'file') {
                        fileManager()->removeFile(getFilePath('verify').'/'.$kycData->value);
                    }
                }
            }
            $user->kyc_data = null;
        }else{
            $user->kv = 1;
        }
        $user->save();

        $notify[] = ['success', 'User details updated successfully'];
        return back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'act' => 'required|in:add,sub',
            'remark' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $amount = $request->amount;
        $general = gs();
        $trx = getTrx();

        $transaction = new Transaction();

        if ($request->act == 'add') {
            $user->balance += $amount;

            $transaction->trx_type = '+';
            $transaction->remark = 'balance_add';

            $notifyTemplate = 'BAL_ADD';

            $notify[] = ['success', $general->cur_sym . $amount . ' added successfully'];

        } else {
            if ($amount > $user->balance) {
                $notify[] = ['error', $user->username . ' doesn\'t have sufficient balance.'];
                return back()->withNotify($notify);
            }

            $user->balance -= $amount;

            $transaction->trx_type = '-';
            $transaction->remark = 'balance_subtract';

            $notifyTemplate = 'BAL_SUB';
            $notify[] = ['success', $general->cur_sym . $amount . ' subtracted successfully'];
        }

        $user->save();

        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx =  $trx;
        $transaction->details = $request->remark;
        $transaction->save();

        notify($user, $notifyTemplate, [
            'trx' => $trx,
            'amount' => showAmount($amount),
            'remark' => $request->remark,
            'post_balance' => showAmount($user->balance)
        ]);

        return back()->withNotify($notify);
    }

    public function login($id){
        Auth::loginUsingId($id);
        return to_route('user.home');
    }

    public function status(Request $request,$id)
    {
        $user = User::findOrFail($id);
        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason'=>'required|string|max:255'
            ]);
            $user->status = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[] = ['success','User banned successfully'];
        }else{
            $user->status = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[] = ['success','User unbanned successfully'];
        }
        $user->save();
        return back()->withNotify($notify);

    }


    public function showNotificationSingleForm($id)
    {
        $user = User::findOrFail($id);
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning','Notification options are disabled currently'];
            return to_route('admin.users.detail',$user->id)->withNotify($notify);
        }
        $pageTitle = 'Send Notification to ' . $user->username;
        return view('admin.users.notification_single', compact('pageTitle', 'user'));
    }

    public function sendNotificationSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'subject' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        notify($user,'DEFAULT',[
            'subject'=>$request->subject,
            'message'=>$request->message,
        ]);
        $notify[] = ['success', 'Notification sent successfully'];
        return back()->withNotify($notify);
    }

    public function showNotificationAllForm()
    {
        $general = gs();
        if (!$general->en && !$general->sn) {
            $notify[] = ['warning','Notification options are disabled currently'];
            return to_route('admin.dashboard')->withNotify($notify);
        }
        $users = User::where('ev',Status::VERIFIED)->where('sv',Status::VERIFIED)->where('status',Status::USER_ACTIVE)->count();
        $pageTitle = 'Notification to Verified Users';
        return view('admin.users.notification_all', compact('pageTitle','users'));
    }

    public function sendNotificationAll(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'message' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $user = User::where('ev',Status::VERIFIED)->where('sv',Status::VERIFIED)->where('status',Status::USER_ACTIVE)->skip($request->skip)->first();

        notify($user,'DEFAULT',[
            'subject'=>$request->subject,
            'message'=>$request->message,
        ]);

        return response()->json([
            'success'=>'message sent',
            'total_sent'=>$request->skip + 1,
        ]);
    }

    public function notificationLog($id){
        $user = User::findOrFail($id);
        $pageTitle = 'Notifications Sent to '.$user->username;
        $logs = NotificationLog::where('user_id',$id)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle','logs','user'));
    }

    private function getDownlineTree($user, $depth = 1, $maxDepth = 10)
    {
        if ($depth > $maxDepth) return [];

        $referrals = User::where('ref_by', $user->id)->with('plan')->get();
        $tree = [];
        $now = Carbon::now();

        foreach ($referrals as $ref) {
            $schedulesData = [];

            // 1. Manual Payments assigned to Plan
            if ($ref->plan_id) {
                $schedules = ManualPayment::where('plan_id', $ref->plan_id)
                    ->where('type', 'plan')
                    ->where('status', 'active')
                    ->get();
                
                foreach ($schedules as $sched) {
                    $dailyPercentage = $sched->percentage;
                    $calcMonthlyAmount = 0;
                    $targetPercentage = '';
                    $targetPayout = '';

                    if ($sched->monthly_percentage > 0) {
                        $calcMonth = ($sched->selected_month === 'all') ? now()->format('Y-m') : $sched->selected_month;
                        $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', $calcMonth);
                        $totalDays = $carbonMonth->daysInMonth;
                        $workingDays = 0;

                        if ($sched->exclude_weekends) {
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

                        $dailyPercentage = $daysCount > 0 ? ($sched->monthly_percentage / $daysCount) : 0;
                        $calcMonthlyAmount = $ref->invest_amount * ($sched->monthly_percentage / 100);
                        $targetPercentage = $sched->monthly_percentage . '% (Target)';
                        $targetPayout = 'Target: ' . gs()->cur_sym . showAmount($calcMonthlyAmount);
                    }

                    $calcDailyAmount = $ref->invest_amount * ($dailyPercentage / 100);

                    $statusAndNext = $this->getScheduleStatusAndNextRun($sched);
                    $schedulesData[] = [
                        'schedule_id' => $sched->id,
                        'description' => $sched->description,
                        'amount' => showAmount($dailyPercentage, 6) . '% (Daily)',
                        'target_percentage' => $targetPercentage,
                        'payout_amount' => gs()->cur_sym . showAmount($calcDailyAmount),
                        'target_payout' => $targetPayout,
                        'frequency' => ucfirst($sched->frequency),
                        'next_run' => $statusAndNext['next_run'],
                        'exclude_weekends' => $sched->exclude_weekends ? 'Yes' : 'No',
                        'badge_class' => 'bg-success text-white',
                        'status' => $statusAndNext['status'],
                        'status_class' => $statusAndNext['status_class']
                    ];
                }
            }

            // 2. Direct Payout Schedules assigned directly to the user
            $userSchedules = ManualPayment::where('user_id', $ref->id)
                ->where('type', 'user')
                ->where('status', 'active')
                ->get();

            foreach ($userSchedules as $sched) {
                $statusAndNext = $this->getScheduleStatusAndNextRun($sched);
                $schedulesData[] = [
                    'schedule_id' => $sched->id,
                    'description' => $sched->description . ' (User Specific Direct Payout)',
                    'amount' => 'Flat / Fixed',
                    'target_percentage' => '',
                    'payout_amount' => gs()->cur_sym . showAmount($sched->amount),
                    'target_payout' => '',
                    'frequency' => ucfirst($sched->frequency),
                    'next_run' => $statusAndNext['next_run'],
                    'exclude_weekends' => $sched->exclude_weekends ? 'Yes' : 'No',
                    'badge_class' => 'bg-info text-white',
                    'status' => $statusAndNext['status'],
                    'status_class' => $statusAndNext['status_class']
                ];
            }

            // Get recursive downline team stats
            $teamStats = $this->getTeamStats($ref);

            $levelSchedules = $this->getLevelIncomeSchedules($ref, $maxDepth - $depth);
            $schedulesData = array_merge($schedulesData, $levelSchedules);

            $tree[] = [
                'id' => $ref->id,
                'username' => $ref->username,
                'fullname' => $ref->fullname,
                'email' => $ref->email,
                'invest_amount' => $ref->invest_amount,
                'plan_name' => $ref->plan ? $ref->plan->name : 'No Active Plan',
                'schedules' => $schedulesData,
                'team_count' => $teamStats['team_count'],
                'level' => $depth,
                'children' => $this->getDownlineTree($ref, $depth + 1, $maxDepth)
            ];
        }

        return $tree;
    }

    private function getTeamStats($user)
    {
        $referrals = User::where('ref_by', $user->id)->get();
        $teamCount = $referrals->count();
        $investmentSum = $referrals->sum('invest_amount');

        foreach ($referrals as $ref) {
            $stats = $this->getTeamStats($ref);
            $teamCount += $stats['team_count'];
            $investmentSum += $stats['investment_sum'];
        }

        return [
            'team_count' => $teamCount,
            'investment_sum' => $investmentSum
        ];
    }

    private function calculateNextRunTime($sched)
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($sched->start_time);
        
        // If scheduled start time is in the future
        if ($startTime->gt($now)) {
            if ($sched->exclude_weekends && $startTime->isWeekend()) {
                $next = $startTime->copy();
                while ($next->isWeekend()) {
                    $next->addDay();
                }
                return $next->format('Y-m-d H:i');
            }
            return $startTime->format('Y-m-d H:i');
        }

        // If start time has already passed
        $next = $now->copy()->setTimeFromTimeString($startTime->toTimeString());
        
        // If the execution time of today has already passed, next run is tomorrow
        if ($next->lt($now)) {
            $next->addDay();
        }

        // Check if weekends should be skipped
        if ($sched->exclude_weekends) {
            while ($next->isWeekend()) {
                $next->addDay();
            }
        }

        // For monthly payments, check day of month
        if ($sched->frequency === 'monthly' && $sched->monthly_day) {
            $currentMonthRun = $now->copy()->day($sched->monthly_day)->setTimeFromTimeString($startTime->toTimeString());
            if ($currentMonthRun->lt($now)) {
                $next = $currentMonthRun->addMonth();
            } else {
                $next = $currentMonthRun;
            }
        }

        return $next->format('Y-m-d H:i');
    }

    private function flattenTreeForOrgChart($user, $downlineTree)
    {
        $flat = [];
        $img = $user->image ? getImage(getFilePath('userProfile') . '/' . $user->image) : '';
        $flat[] = [
            'id' => (string) $user->id,
            'parentId' => '',
            'name' => $user->fullname,
            'username' => $user->username,
            'image' => $img,
            'level' => 0,
            'teamSize' => $user->team_count,
            'volume' => $user->invest_amount,
            'schedules' => $user->schedules,
            'plan_name' => $user->plan ? $user->plan->name : 'No Plan',
            'email' => $user->email
        ];

        $queue = $downlineTree;
        while (count($queue) > 0) {
            $node = array_shift($queue);
            $u = User::find($node['id']);
            $parentId = $u ? (string)$u->ref_by : '';
            
            $img = $u && $u->image ? getImage(getFilePath('userProfile') . '/' . $u->image) : '';
            
            $flat[] = [
                'id' => (string)$node['id'],
                'parentId' => $parentId,
                'name' => $node['fullname'],
                'username' => $node['username'],
                'image' => $img,
                'level' => $node['level'],
                'teamSize' => $node['team_count'],
                'volume' => $node['invest_amount'],
                'schedules' => $node['schedules'],
                'plan_name' => $node['plan_name'],
                'email' => $node['email']
            ];

            if (!empty($node['children'])) {
                foreach ($node['children'] as $child) {
                    $queue[] = $child;
                }
            }
        }
        return $flat;
    }

    private function calculatePlanDailyReferralNextRun($plan)
    {
        $now = Carbon::now();
        if (!$plan->daily_referral_start_time) {
            return $now;
        }

        $startTime = Carbon::parse($plan->daily_referral_start_time);
        
        // If scheduled start time is in the future
        if ($startTime->gt($now)) {
            $next = $startTime->copy();
            if ($plan->daily_referral_exclude_weekends) {
                while ($next->isWeekend()) {
                    $next->addDay();
                }
            }
            return $next;
        }

        // If start time has already passed
        $next = $now->copy()->setTimeFromTimeString($startTime->toTimeString());
        
        // If the execution time of today has already passed, next run is tomorrow
        if ($next->lt($now)) {
            $next->addDay();
        }

        // Check if weekends should be skipped
        if ($plan->daily_referral_exclude_weekends) {
            while ($next->isWeekend()) {
                $next->addDay();
            }
        }

        return $next;
    }

    private function getFlatDownlines($user, $depth = 1, $maxDepth = 10)
    {
        if ($depth > $maxDepth) return [];
        $referrals = User::where('ref_by', $user->id)->get();
        $flat = [];
        foreach ($referrals as $ref) {
            $flat[] = [
                'user' => $ref,
                'level' => $depth
            ];
            $flat = array_merge($flat, $this->getFlatDownlines($ref, $depth + 1, $maxDepth));
        }
        return $flat;
    }

    private function getLevelIncomeSchedules($user, $maxDepth = 10)
    {
        $levelSchedules = [];
        $plan = $user->plan;
        if (!$plan || !$plan->daily_referral_enabled || $user->invest_amount <= 0) {
            return [];
        }

        $dailyReferralLevels = DailyReferralLevel::where('plan_id', $user->plan_id)
            ->pluck('percentage', 'level')
            ->toArray();

        $downlines = $this->getFlatDownlines($user, 1, $maxDepth);
        $now = Carbon::now();

        foreach ($downlines as $downlineItem) {
            $downlineUser = $downlineItem['user'];
            $level = $downlineItem['level'];

            // The level referral percentage for this level
            $levelPercent = $dailyReferralLevels[$level] ?? 0;
            if ($levelPercent <= 0) {
                continue;
            }

            // Check if upline has required direct referrals for this level
            $requiredDirects = $level;
            $directsCount = User::where('ref_by', $user->id)->count();
            $meetsRequirement = $directsCount >= $requiredDirects;

            // Get downline's scheduled ROI payments
            if ($downlineUser->plan_id) {
                $downlineSchedules = ManualPayment::where('plan_id', $downlineUser->plan_id)
                    ->where('type', 'plan')
                    ->where('status', 'active')
                    ->get();

                foreach ($downlineSchedules as $sched) {
                    $dailyPercentage = $sched->percentage;

                    if ($sched->monthly_percentage > 0) {
                        $calcMonth = ($sched->selected_month === 'all') ? now()->format('Y-m') : $sched->selected_month;
                        $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', $calcMonth);
                        $totalDays = $carbonMonth->daysInMonth;
                        $workingDays = 0;

                        if ($sched->exclude_weekends) {
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

                        $dailyPercentage = $daysCount > 0 ? ($sched->monthly_percentage / $daysCount) : 0;
                    }

                    $calcDailyAmount = $downlineUser->invest_amount * ($dailyPercentage / 100);
                    $levelCommissionAmount = ($calcDailyAmount * $levelPercent) / 100;

                    // Exclude weekends: if either downline excludes weekends OR upline plan excludes weekends
                    $excludeWeekends = $sched->exclude_weekends || $plan->daily_referral_exclude_weekends;

                    // Next execution time calculation
                    $schedNextRun = Carbon::parse($this->calculateNextRunTime($sched));
                    $planNextRun = $this->calculatePlanDailyReferralNextRun($plan);
                    $nextRunTime = $schedNextRun->gt($planNextRun) ? $schedNextRun->format('Y-m-d H:i') : $planNextRun->format('Y-m-d H:i');

                    // Check if target calendar month is already passed
                    if ($sched->selected_month && $sched->selected_month !== 'all') {
                        if ($now->format('Y-m') > $sched->selected_month) {
                            $levelSchedules[] = [
                                'schedule_id' => $sched->id,
                                'downline_id' => $downlineUser->id,
                                'level_num' => $level,
                                'description' => "Level {$level} Daily Referral from @{$downlineUser->username} ({$sched->description})",
                                'amount' => showAmount($levelPercent, 2) . '% of ROI',
                                'target_percentage' => '',
                                'payout_amount' => gs()->cur_sym . showAmount($levelCommissionAmount, 6),
                                'target_payout' => $meetsRequirement ? '' : '⚠️ Missing ' . ($requiredDirects - $directsCount) . ' directs',
                                'frequency' => 'Completed',
                                'next_run' => 'Expired / Fully Paid',
                                'exclude_weekends' => $excludeWeekends ? 'Yes' : 'No',
                                'badge_class' => 'bg-secondary text-white',
                                'status' => 'Expired / Completed',
                                'status_class' => 'badge bg-secondary'
                            ];
                            continue;
                        }
                    }

                    // Check if downline's ROI transaction exists for today
                    $downlineRoiPaidToday = Transaction::where('user_id', $downlineUser->id)
                        ->where('remark', 'manual_payment')
                        ->where('details', 'like', '%Plan ROI%')
                        ->whereDate('created_at', Carbon::today())
                        ->first();

                    $levelIncomePaidToday = false;
                    if ($downlineRoiPaidToday) {
                        $levelIncomePaidToday = Transaction::where('user_id', $user->id)
                            ->where('remark', 'daily_referral')
                            ->where('details', 'like', "%Ref Trx #{$downlineRoiPaidToday->id}%")
                            ->exists();
                    }

                    if ($downlineRoiPaidToday) {
                        if ($levelIncomePaidToday) {
                            $statusText = 'Paid Today';
                            $statusClass = 'badge bg-success';
                            // Since paid today, next run is calculated for tomorrow
                            $downlineRoiNextRun = Carbon::parse($this->calculateNextRunTime($sched));
                            $planNextRun = $this->calculatePlanDailyReferralNextRun($plan);
                            $nextRunTime = $downlineRoiNextRun->gt($planNextRun) ? $downlineRoiNextRun->format('Y-m-d H:i') : $planNextRun->format('Y-m-d H:i');
                        } else {
                            if (!$meetsRequirement) {
                                $statusText = 'Missing Directs';
                                $statusClass = 'badge bg-danger';
                                $nextRunTime = "Suspended (Requires {$requiredDirects} direct referrals)";
                            } else {
                                // check if daily referral start time is in the future
                                $planStartTime = Carbon::parse($plan->daily_referral_start_time);
                                if ($planStartTime->gt($now)) {
                                    $statusText = 'Scheduled';
                                    $statusClass = 'badge bg-primary';
                                    $nextRunTime = $planStartTime->format('Y-m-d H:i');
                                } elseif ($plan->daily_referral_exclude_weekends && $now->isWeekend()) {
                                    $statusText = 'Skipped (Weekend)';
                                    $statusClass = 'badge bg-warning text-dark';
                                    $planNextRun = $this->calculatePlanDailyReferralNextRun($plan);
                                    $nextRunTime = $planNextRun->format('Y-m-d H:i');
                                } else {
                                    // check if time of day has not reached yet
                                    if ($now->format('H:i') < $planStartTime->format('H:i')) {
                                        $statusText = 'Pending (After ROI)';
                                        $statusClass = 'badge bg-warning text-dark';
                                        $scheduledTime = Carbon::parse($now->toDateString() . ' ' . $planStartTime->toTimeString());
                                        $nextRunTime = $scheduledTime->format('Y-m-d H:i');
                                    } else {
                                        $statusText = 'Processing / Pending';
                                        $statusClass = 'badge bg-info text-white';
                                        $nextRunTime = 'Today (Waiting for cron)';
                                    }
                                }
                            }
                        }
                    } else {
                        // Downline ROI not paid today yet
                        if (!$meetsRequirement) {
                            $statusText = 'Missing Directs';
                            $statusClass = 'badge bg-danger';
                            $nextRunTime = "Suspended (Requires {$requiredDirects} direct referrals)";
                        } else {
                            $statusText = 'Scheduled (Waiting for ROI)';
                            $statusClass = 'badge bg-primary';
                            // Next run is calculated normally
                            $downlineRoiNextRun = Carbon::parse($this->calculateNextRunTime($sched));
                            $planNextRun = $this->calculatePlanDailyReferralNextRun($plan);
                            $nextRunTime = $downlineRoiNextRun->gt($planNextRun) ? $downlineRoiNextRun->format('Y-m-d H:i') : $planNextRun->format('Y-m-d H:i');
                        }
                    }

                    $levelSchedules[] = [
                        'schedule_id' => $sched->id,
                        'downline_id' => $downlineUser->id,
                        'level_num' => $level,
                        'description' => "Level {$level} Daily Referral from @{$downlineUser->username} ({$sched->description})",
                        'amount' => showAmount($levelPercent, 2) . '% of ROI',
                        'target_percentage' => '',
                        'payout_amount' => gs()->cur_sym . showAmount($levelCommissionAmount, 6),
                        'target_payout' => $meetsRequirement ? '' : '⚠️ Missing ' . ($requiredDirects - $directsCount) . ' directs',
                        'frequency' => ucfirst($sched->frequency),
                        'next_run' => $nextRunTime,
                        'exclude_weekends' => $excludeWeekends ? 'Yes' : 'No',
                        'badge_class' => $meetsRequirement ? 'bg-warning text-dark' : 'bg-danger text-white',
                        'status' => $statusText,
                        'status_class' => $statusClass
                    ];
                }
            }
        }

        return $levelSchedules;
    }

    private function getScheduleStatusAndNextRun($sched)
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($sched->start_time);
        
        // Check if expired / completed (selected_month has passed)
        if ($sched->selected_month && $sched->selected_month !== 'all') {
            if ($now->format('Y-m') > $sched->selected_month) {
                return [
                    'status' => 'Completed',
                    'status_class' => 'badge bg-secondary text-white',
                    'next_run' => 'Expired / Fully Paid'
                ];
            }
        }

        // Determine if it has run today
        $runToday = false;
        if ($sched->last_credited_at) {
            $runToday = Carbon::parse($sched->last_credited_at)->isToday();
        }

        // Determine next run time
        if ($runToday) {
            // Since it already ran today, start searching from tomorrow
            $base = $now->copy()->addDay()->setTimeFromTimeString($startTime->toTimeString());
        } else {
            // Not run today yet
            $base = $now->copy()->setTimeFromTimeString($startTime->toTimeString());
            // If the scheduled time of today has already passed, next run is tomorrow
            if ($base->lt($now)) {
                $base->addDay();
            }
        }

        // Adjust for weekend exclusion
        if ($sched->exclude_weekends) {
            while ($base->isWeekend()) {
                $base->addDay();
            }
        }

        // For monthly frequency
        if ($sched->frequency === 'monthly' && $sched->monthly_day) {
            if ($runToday) {
                // Next month on that day
                $base = $now->copy()->addMonth()->day($sched->monthly_day)->setTimeFromTimeString($startTime->toTimeString());
            } else {
                $currentMonthRun = $now->copy()->day($sched->monthly_day)->setTimeFromTimeString($startTime->toTimeString());
                if ($currentMonthRun->lt($now)) {
                    $base = $currentMonthRun->addMonth();
                } else {
                    $base = $currentMonthRun;
                }
            }
        }

        // If start time is in the future
        if ($startTime->gt($now)) {
            $next = $startTime->copy();
            if ($sched->exclude_weekends) {
                while ($next->isWeekend()) {
                    $next->addDay();
                }
            }
            return [
                'status' => 'Scheduled',
                'status_class' => 'badge bg-primary text-white',
                'next_run' => $next->format('Y-m-d H:i')
            ];
        }

        if ($runToday) {
            return [
                'status' => 'Paid Today',
                'status_class' => 'badge bg-success text-white',
                'next_run' => $base->format('Y-m-d H:i')
            ];
        }

        // If it should run today but hasn't run yet, check if today is a weekend and is excluded
        if ($sched->exclude_weekends && $now->isWeekend()) {
            return [
                'status' => 'Skipped (Weekend)',
                'status_class' => 'badge bg-warning text-dark',
                'next_run' => $base->format('Y-m-d H:i')
            ];
        }

        // Otherwise, it is pending execution today
        return [
            'status' => 'Pending',
            'status_class' => 'badge bg-info text-white',
            'next_run' => $base->format('Y-m-d H:i')
        ];
    }

    public function paySchedule(Request $request, $id)
    {
        $request->validate([
            'schedule_type' => 'required|in:plan,user,level',
            'schedule_id' => 'required|integer',
            'downline_id' => 'nullable|integer',
            'level' => 'nullable|integer',
        ]);

        $user = User::findOrFail($id);

        if ($request->schedule_type === 'user') {
            $payment = ManualPayment::where('id', $request->schedule_id)
                ->where('user_id', $user->id)
                ->where('type', 'user')
                ->firstOrFail();

            if ($payment->last_credited_at && Carbon::parse($payment->last_credited_at)->isToday()) {
                $notify[] = ['error', 'This payment has already been made today.'];
                return back()->withNotify($notify);
            }

            $user->balance += $payment->amount;
            $user->save();

            $trx = getTrx();
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $payment->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = ucfirst($payment->frequency) . ' Payment (Manual Immediate): ' . $payment->description;
            $transaction->remark = 'manual_payment';
            $transaction->trx = $trx;
            $transaction->save();

            $payment->last_credited_at = now();
            $payment->save();

            $notify[] = ['success', 'Manual payment processed successfully.'];
            return back()->withNotify($notify);

        } elseif ($request->schedule_type === 'plan') {
            $payment = ManualPayment::where('id', $request->schedule_id)
                ->where('plan_id', $user->plan_id)
                ->where('type', 'plan')
                ->firstOrFail();

            // Deduplication: check if already paid today
            $alreadyPaidToday = Transaction::where('user_id', $user->id)
                ->where('remark', 'manual_payment')
                ->where('details', 'like', '%Plan ROI%')
                ->where('details', 'like', '%' . $payment->description . '%')
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyPaidToday) {
                $notify[] = ['error', 'Plan ROI has already been paid to this user today.'];
                return back()->withNotify($notify);
            }

            $trx = $this->payPlanRoi($user, $payment);
            if (!$trx) {
                $notify[] = ['error', 'Failed to process Plan ROI. Amount is 0 or negative.'];
                return back()->withNotify($notify);
            }

            $notify[] = ['success', 'Plan ROI payment processed successfully.'];
            return back()->withNotify($notify);

        } elseif ($request->schedule_type === 'level') {
            $downlineUser = User::findOrFail($request->downline_id);
            $payment = ManualPayment::where('id', $request->schedule_id)
                ->where('plan_id', $downlineUser->plan_id)
                ->where('type', 'plan')
                ->firstOrFail();

            $level = intval($request->level);

            // Deduplication: check if already paid today
            $alreadyPaidToday = Transaction::where('user_id', $user->id)
                ->where('remark', 'daily_referral')
                ->where('details', 'like', "Level Income {$downlineUser->username} (Level {$level})%")
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyPaidToday) {
                $notify[] = ['error', 'Level Income has already been paid from this downline today.'];
                return back()->withNotify($notify);
            }

            // Check if downline's ROI transaction exists for today
            $downlineRoiPaidToday = Transaction::where('user_id', $downlineUser->id)
                ->where('remark', 'manual_payment')
                ->where('details', 'like', '%Plan ROI%')
                ->whereDate('created_at', Carbon::today())
                ->first();

            if (!$downlineRoiPaidToday) {
                // First process downline's Plan ROI
                $downlineRoiPaidToday = $this->payPlanRoi($downlineUser, $payment);
            }

            if (!$downlineRoiPaidToday) {
                $notify[] = ['error', 'Failed to process downline Plan ROI.'];
                return back()->withNotify($notify);
            }

            $levelPercent = DailyReferralLevel::where('plan_id', $user->plan_id)
                ->where('level', $level)
                ->value('percentage') ?? 0;

            if ($levelPercent <= 0) {
                $notify[] = ['error', 'Level percentage not configured.'];
                return back()->withNotify($notify);
            }

            $bonus = ($downlineRoiPaidToday->amount * $levelPercent) / 100;
            if ($bonus <= 0) {
                $notify[] = ['error', 'Calculated Level Income is 0.'];
                return back()->withNotify($notify);
            }

            $user->balance += $bonus;
            $user->save();

            $trx = getTrx();
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $bonus;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = "Level Income {$downlineUser->username} (Level {$level}) - Ref Trx #{$downlineRoiPaidToday->id} (Manual Immediate)";
            $transaction->remark = 'daily_referral';
            $transaction->trx = $trx;
            $transaction->save();

            $notify[] = ['success', 'Level Income payout processed successfully.'];
            return back()->withNotify($notify);
        }

        $notify[] = ['error', 'Invalid schedule type.'];
        return back()->withNotify($notify);
    }

    private function payPlanRoi($user, $payment)
    {
        $dailyPercentage = $payment->percentage;
        if ($payment->monthly_percentage > 0) {
            $calcMonth = ($payment->selected_month === 'all') ? now()->format('Y-m') : $payment->selected_month;
            $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', $calcMonth);
            $totalDays = $carbonMonth->daysInMonth;
            $workingDays = 0;

            if ($payment->exclude_weekends) {
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

            $dailyPercentage = $daysCount > 0 ? ($payment->monthly_percentage / $daysCount) : 0;
        }

        $amount = ($user->invest_amount * $dailyPercentage / 100);
        if ($amount <= 0) return null;

        $user->balance += $amount;
        $user->save();

        if ($payment->monthly_percentage > 0) {
            $monthLabel = ($payment->selected_month === 'all') ? now()->format('F Y') : \Carbon\Carbon::parse($payment->selected_month)->format('F Y');
            $details = "Plan ROI - " . $monthLabel . " (Manual Immediate): " . $payment->description;
        } else {
            $details = ucfirst($payment->frequency) . ' Plan ROI (' . getAmount($dailyPercentage) . '% - Manual Immediate): ' . $payment->description;
        }

        $trx = getTrx();
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = $details;
        $transaction->remark = 'manual_payment';
        $transaction->trx = $trx;
        $transaction->save();

        return $transaction;
    }
}
