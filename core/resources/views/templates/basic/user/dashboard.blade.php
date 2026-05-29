@extends($activeTemplate . 'layouts.master')
@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
@endpush
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
        $user = auth()->user();
        $totalInvest = $user->invest_amount;
        $totalReceived = DB::table('transactions')
            ->where('user_id', $user->id)
            ->where('trx_type', '+')
            ->whereIn('remark', ['referral_commission', 'level_commission', 'manual_payment', 'daily_referral'])
            ->sum('amount');
        $totalPotential = $totalInvest * 3;
        $remaining = $totalPotential - $totalReceived;
        if ($remaining < 0) {
            $remaining = 0;
        }

        // 1. Calculate Expected Plan ROI Daily Income
        $expectedDailyRoi = 0;
        if ($user->plan_id && $user->invest_amount > 0) {
            $schedules = DB::table('manual_payments')
                ->where('plan_id', $user->plan_id)
                ->where('type', 'plan')
                ->where('status', 'active')
                ->get();

            foreach ($schedules as $sched) {
                $dailyPercentage = $sched->percentage;

                if ($sched->monthly_percentage > 0) {
                    $calcMonth = ($sched->selected_month === 'all') ? now()->format('Y-m') : $sched->selected_month;
                    try {
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
                    } catch (\Exception $e) {
                        // fallback
                    }
                }

                $expectedDailyRoi += $user->invest_amount * ($dailyPercentage / 100);
            }
        }

        // 2. Calculate Expected Direct User Payout Schedules Daily Income (if frequency is daily)
        $userSchedules = DB::table('manual_payments')
            ->where('user_id', $user->id)
            ->where('type', 'user')
            ->where('status', 'active')
            ->get();

        foreach ($userSchedules as $sched) {
            if ($sched->frequency === 'daily') {
                $expectedDailyRoi += $sched->amount;
            }
        }

        // 3. Calculate Expected Level Income (Daily Referral) Daily Income
        $expectedDailyLevel = 0;
        if ($user->plan_id && $user->plan && $user->plan->daily_referral_enabled && $user->invest_amount > 0) {
            if (!function_exists('getFlatDownlineIds')) {
                function getFlatDownlineIds($userIds, $depth = 1, $maxDepth = 10)
                {
                    if ($depth > $maxDepth || empty($userIds)) {
                        return [];
                    }
                    $referrals = DB::table('users')
                        ->whereIn('ref_by', $userIds)
                        ->select('id', 'plan_id', 'invest_amount', 'username')
                        ->get();

                    if ($referrals->isEmpty()) {
                        return [];
                    }

                    $downlines = [];
                    $nextUserIds = [];
                    foreach ($referrals as $ref) {
                        $downlines[] = [
                            'id' => $ref->id,
                            'plan_id' => $ref->plan_id,
                            'invest_amount' => $ref->invest_amount,
                            'username' => $ref->username,
                            'level' => $depth
                        ];
                        $nextUserIds[] = $ref->id;
                    }

                    return array_merge($downlines, getFlatDownlineIds($nextUserIds, $depth + 1, $maxDepth));
                }
            }

            $downlines = getFlatDownlineIds([$user->id], 1, 10);

            if (!empty($downlines)) {
                $dailyReferralLevels = DB::table('daily_referral_levels')
                    ->where('plan_id', $user->plan_id)
                    ->pluck('percentage', 'level')
                    ->toArray();

                $directsCount = DB::table('users')->where('ref_by', $user->id)->count();

                foreach ($downlines as $downline) {
                    $level = $downline['level'];
                    $levelPercent = $dailyReferralLevels[$level] ?? 0;
                    if ($levelPercent <= 0) {
                        continue;
                    }

                    // Check if upline has required directs
                    if ($directsCount < $level) {
                        continue;
                    }

                    if ($downline['plan_id'] && $downline['invest_amount'] > 0) {
                        $downlineSchedules = DB::table('manual_payments')
                            ->where('plan_id', $downline['plan_id'])
                            ->where('type', 'plan')
                            ->where('status', 'active')
                            ->get();

                        foreach ($downlineSchedules as $sched) {
                            $dailyPercentage = $sched->percentage;

                            if ($sched->monthly_percentage > 0) {
                                $calcMonth = ($sched->selected_month === 'all') ? now()->format('Y-m') : $sched->selected_month;
                                try {
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
                                } catch (\Exception $e) {
                                    // fallback
                                }
                            }

                            $calcDailyAmount = $downline['invest_amount'] * ($dailyPercentage / 100);
                            $expectedDailyLevel += ($calcDailyAmount * $levelPercent) / 100;
                        }
                    }
                }
            }
        }

        $dailyIncome = $expectedDailyRoi + $expectedDailyLevel;


        $trantiref = DB::table('transactions')
            ->where('user_id', auth()->user()->id)
            ->where('remark', 'Like', '%referral_commission%')
            ->sum('amount');

        $totalEarnedUsdt = $balance + $withdraw;
        $transactionsdataa = 0;
        function getAllReferredUsers($userIds, $level = 1, $maxLevel = 10)
        {
            if ($level > $maxLevel)
                return $userIds;
            $referredUsers = DB::table('users')->whereIn('ref_by', $userIds)->pluck('id')->toArray();
            if (empty($referredUsers))
                return $userIds;
            $userIds = array_merge($userIds, getAllReferredUsers($referredUsers, $level + 1, $maxLevel));
            return $userIds;
        }
        $initialUsers = DB::table('users')->where('ref_by', auth()->user()->id)->pluck('id')->toArray();
        if (!empty($initialUsers)) {
            $allReferredUsers = getAllReferredUsers($initialUsers);
            $uniqueUserIds = array_values(array_unique($allReferredUsers));
            $transactionsdataa = DB::table('transactions')
                ->where('remark', 'LIKE', '%plan_purchase%')
                ->whereIn('user_id', $uniqueUserIds)
                ->sum('amount');
        }
    @endphp
    <div class="dashboard-container">
        <div class="video-background">
            <video autoplay muted loop id="myVideo">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4"
                    type="video/mp4">
            </video>
        </div>
        <div class="dashboard-header">
            <div class="header-top">
                <div class="user-greeting">
                    <div class="greeting-icon">
                        <i class="fas fa-hand-wave"></i>
                    </div>
                    <div class="greeting-text">
                        <h1>Welcome Back, <span class="user-name">{{ $user->firstname }} {{ $user->lastname }}</span></h1>
                        <p class="user-id"><i class="fas fa-user-shield"></i> UID: <span
                                class="user-id-value">{{ $username }}</span> <span class="status-online"><i
                                    class="fas fa-circle"></i> Online</span></p>
                    </div>
                </div>
            </div>

            <div class="header-bottom">
                <div class="referral-box premium-node-card">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <p class="referral-label mb-0"><i class="fas fa-link text-danger me-2"></i> UNIQUE REFERRAL LINK</p>
                        <span class="badge-status-node"><i class="fas fa-check-circle me-1"></i> ACTIVE</span>
                    </div>
                    <p class="node-description-text mb-3">
                        Use this unique referral link to invite partners and grow your network. Share it to connect them
                        directly to your 4X Elite Strategy Network and earn team commissions.
                    </p>
                    <div class="referral-input-group">
                        <input type="text" name="key"
                            value="{{ route('user.register') }}?node=NODE_{{ bin2hex($username) }}"
                            class="referral-input node-input-glow" id="nodeLink" readonly>
                        <button type="button" class="copy-btn btn-node-glow" id="copyBoard">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @if (auth()->user()->kv == 0)
            <div class="alert-card alert-kyc">
                <div class="alert-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="alert-content">
                    <h4>@lang('KYC Verification Required')</h4>
                    <p>{{ __($kycInfo->data_values->verification_content) }}</p>
                    <a href="{{ route('user.kyc.form') }}" class="alert-action-btn">
                        <i class="fas fa-check-circle"></i> @lang('Verify Now')
                    </a>
                </div>
            </div>
        @elseif(auth()->user()->kv == 2)
            <div class="alert-card alert-pending">
                <div class="alert-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="alert-content">
                    <h4>@lang('KYC Verification Pending')</h4>
                    <p>{{ __($kycInfo->data_values->pending_content) }}</p>
                    <a href="{{ route('user.kyc.data') }}" class="alert-action-btn">
                        <i class="fas fa-eye"></i> @lang('View Status')
                    </a>
                </div>
            </div>
        @endif

        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h4>Current Balance</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($balance) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 12%
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Deposit</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposit) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 8%
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Withdraw</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($withdraw) }}</h3>
                </div>
                <div class="stat-trend down">
                    <i class="fas fa-arrow-down"></i> 5%
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h4>Daily Income</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($dailyIncome) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> 15%
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="grid-left">
                <div class="card overview-card">
                    <div class="card-header">
                        <h3><i class="fas fa-chart-pie"></i> Financial Overview</h3>
                        <div class="card-actions">
                            <a href="{{ route('plan') }}" class="action-btn invest-now-btn-header" title="Invest Now">
                                <i class="fas fa-rocket"></i> <span class="d-none d-sm-inline ms-1">Invest</span>
                            </a>
                            <button type="button" class="action-btn refresh-overview-btn" id="refreshOverview"
                                title="Refresh Data">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <!-- Skeleton Loader (Hidden by default) -->
                        <div class="overview-skeleton" style="display: none;">
                            @for($i = 0; $i < 4; $i++)
                                <div class="skeleton-box mb-3">
                                    <div class="skeleton-line skeleton-label"></div>
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <div class="skeleton-circle"></div>
                                        <div class="skeleton-line skeleton-value"></div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <!-- Actual Content -->
                        <div class="overview-content">
                            <div class="summary-box">
                                <span class="summary-label">Total Investment</span>
                                <h3 class="summary-value" id="valTotalInvest">
                                    <i class="fas fa-piggy-bank"></i>
                                    <span>{{ $general->cur_sym }}{{ showAmount($totalInvest) }}</span>
                                </h3>
                            </div>
                            <div class="summary-box mt-3">
                                <span class="summary-label">Total Received</span>
                                <h3 class="summary-value text-success" id="valTotalReceived">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <span>{{ $general->cur_sym }}{{ showAmount($totalReceived) }}</span>
                                </h3>
                            </div>
                            <div class="summary-box mt-3">
                                <span class="summary-label">Remaining to Receive</span>
                                <h3 class="summary-value text-warning" id="valRemaining">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>{{ $general->cur_sym }}{{ showAmount($remaining) }}</span>
                                </h3>
                            </div>
                            <div class="summary-box mt-3">
                                <span class="summary-label">Total Potential Earnings</span>
                                <h3 class="summary-value text-info" id="valTotalPotential">
                                    <i class="fas fa-chart-line"></i>
                                    <span>{{ $general->cur_sym }}{{ showAmount($totalPotential) }}</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Performance -->
                <div class="card team-card">
                    <div class="card-header">
                        <h3><i class="fas fa-users"></i> Team Performance</h3>
                        <div class="card-actions">
                            <button class="action-btn d-none d-lg-inline-flex"><i class="fas fa-expand-alt"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="team-stats">
                            <div class="team-stat">
                                <div class="stat-icon">
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>Team Business</h4>
                                    <h2>${{ number_format($transactionsdataa, 2) }}</h2>
                                    <p>Total business from your team</p>
                                </div>
                            </div>
                            <div class="team-stat">
                                <div class="stat-icon">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>Direct Income</h4>
                                    <h2>${{ showAmount($trantiref) }}</h2>
                                    <p>Earnings from direct referrals</p>
                                </div>
                            </div>
                        </div>
                        <div class="team-chart-container">
                            <!-- Trading Chart -->
                            <div class="trading-chart-wrapper">
                                <div class="chart-header">
                                    <div class="chart-title">
                                        <span class="live-indicator">
                                            <i class="fas fa-circle"></i> LIVE
                                        </span>
                                        <span class="chart-symbol">TEAM/BUSINESS</span>
                                        <span class="timeframe">5M</span>
                                    </div>
                                    <div class="chart-price">
                                        <span class="current-price">${{ number_format($transactionsdataa, 2) }}</span>
                                        <span class="price-change positive">+2.45%</span>
                                    </div>
                                </div>

                                <div class="chart-tools">
                                    <div class="timeframes">
                                        <button class="timeframe-btn active">1m</button>
                                        <button class="timeframe-btn">5m</button>
                                        <button class="timeframe-btn">15m</button>
                                        <button class="timeframe-btn">1h</button>
                                        <button class="timeframe-btn">4h</button>
                                        <button class="timeframe-btn">1d</button>
                                    </div>
                                    <div class="chart-indicators">
                                        <button class="indicator-btn" title="MA"><i class="fas fa-chart-line"></i></button>
                                        <button class="indicator-btn" title="Volume"><i
                                                class="fas fa-chart-bar"></i></button>
                                    </div>
                                </div>

                                <!-- TradingView-like Chart -->
                                <div class="trading-chart" id="teamGrowthChart">
                                    <!-- Chart will be rendered here by JavaScript -->
                                </div>

                                <div class="chart-footer">
                                    <div class="chart-stats">
                                        <div class="stat">
                                            <span class="label">High</span>
                                            <span
                                                class="value positive">${{ number_format($transactionsdataa * 1.1, 2) }}</span>
                                        </div>
                                        <div class="stat">
                                            <span class="label">Low</span>
                                            <span
                                                class="value negative">${{ number_format($transactionsdataa * 0.9, 2) }}</span>
                                        </div>
                                        <div class="stat">
                                            <span class="label">Volume</span>
                                            <span class="value">{{ number_format($transactionsdataa * 10, 0) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="grid-right">
                <!-- Earnings Summary -->
                <div class="card earnings-card">
                    <div class="card-header">
                        <h3><i class="fas fa-coins"></i> Earnings Summary</h3>
                        <div class="card-actions">
                            <span class="badge">Total</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="earnings-total">
                            <h2>{{ $general->cur_sym }}{{ showAmount($totalReceived) }}</h2>
                            <p>Total Earnings</p>
                        </div>
                        <div class="earnings-breakdown">
                            <div class="breakdown-item">
                                <div class="item-label">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Direct Income</span>
                                </div>
                                <div class="item-value">${{ showAmount($trantiref) }}</div>
                            </div>
                            <div class="breakdown-item">
                                <div class="item-label">
                                    <i class="fas fa-layer-group"></i>
                                    <span>Level Commissions</span>
                                </div>
                                <div class="item-value">$0.00</div>
                            </div>
                            <div class="breakdown-item">
                                <div class="item-label">
                                    <i class="fas fa-calendar-day"></i>
                                    <span>Daily Returns</span>
                                </div>
                                <div class="item-value">${{ showAmount($dailyIncome) }}</div>
                            </div>
                            <div class="breakdown-item">
                                <div class="item-label">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <span>Other Earnings</span>
                                </div>
                                <div class="item-value">$0.00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card actions-card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('user.deposit.index') }}" class="action-btn">
                                <i class="fas fa-plus-circle"></i>
                                <span>Deposit</span>
                            </a>
                            <a href="{{ route('user.withdraw') }}" class="action-btn">
                                <i class="fas fa-credit-card"></i>
                                <span>Withdraw</span>
                            </a>
                            <a href="{{ route('plan') }}" class="action-btn">
                                <i class="fas fa-cube"></i>
                                <span>Invest</span>
                            </a>
                            <a href="{{ route('user.referral.log') }}" class="action-btn">
                                <i class="fas fa-users"></i>
                                <span>My Team</span>
                            </a>
                            <a href="{{ route('user.transactions') }}" class="action-btn">
                                <i class="fas fa-history"></i>
                                <span>History</span>
                            </a>
                            <a href="{{ route('user.profile.setting') }}" class="action-btn">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity - MOBILE FRIENDLY -->
                <div class="card activity-card">
                    <div class="card-header">
                        <h3><i class="fas fa-bell"></i> Recent Activity</h3>
                        <div class="card-actions">
                            <a href="{{ route('user.transactions') }}" class="view-all">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            @forelse($transactions->take(5) as $trx)
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        @if($trx->trx_type == '+')
                                            <i class="fas fa-arrow-down text-success"></i>
                                        @else
                                            <i class="fas fa-arrow-up text-danger"></i>
                                        @endif
                                    </div>
                                    <div class="activity-content">
                                        <h4>{{ __($trx->details) }}</h4>
                                        <p>{{ showDateTime($trx->created_at) }}</p>
                                        <div class="activity-mobile-info">
                                            <span class="trx-code-mobile text--primary">{{ $trx->trx }}</span>
                                            <span class="trx-amount-mobile text-danger">
                                                {{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="activity-amount {{ $trx->trx_type == '+' ? 'text-success' : 'text-danger' }}">
                                        {{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>
                            @empty
                                <div class="empty-activity">
                                    <i class="fas fa-history"></i>
                                    <p>No recent activity</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions - REDESIGNED FOR CONSISTENCY -->
        <div class="card transactions-card">
            <div class="card-header">
                <h3><i class="fas fa-exchange-alt"></i> Recent Transactions</h3>
                <div class="card-actions">
                    <a href="{{ route('user.transactions') }}" class="view-all">View All</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Desktop Table View -->
                <div class="deposits-table desktop-view">
                    <table class="deposit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Post Balance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr class="table-row-item">
                                    <td><span class="serial-number">{{ $loop->iteration }}</span></td>
                                    <td>
                                        <div class="date-time-cell">
                                            <div class="date">{{ showDateTime($trx->created_at, 'd M, Y') }}</div>
                                            <div class="time">{{ showDateTime($trx->created_at, 'h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td><code class="trx-code">{{ $trx->trx }}</code></td>
                                    <td>
                                        <div class="amount-cell">
                                            <span
                                                class="amount-main {{ $trx->trx_type == '+' ? 'text-success' : 'text-danger' }}">
                                                {{ $trx->trx_type }}{{ showAmount($trx->amount) }}
                                            </span>
                                            <span class="currency">{{ __($general->cur_text) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="charge-text">
                                            {{ showAmount($trx->charge) }} {{ __($general->cur_text) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="total-amount">
                                            {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $trx->trx_type == '+' ? 'badge--success' : 'badge--danger' }}">
                                            {{ $trx->trx_type == '+' ? 'Credit' : 'Debit' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="action-btn view-details-btn detailBtn" data-trx="{{ $trx->trx }}"
                                            data-date="{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}"
                                            data-amount="{{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}"
                                            data-charge="{{ showAmount($trx->charge) }} {{ __($general->cur_text) }}"
                                            data-post_balance="{{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}"
                                            data-details="{{ __($trx->details) }}"
                                            data-type="{{ $trx->trx_type == '+' ? 'Credit' : 'Debit' }}"
                                            data-status_class="{{ $trx->trx_type == '+' ? 'success' : 'danger' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="empty-state py-4">
                                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                            <p>No transactions found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="deposits-mobile-view">
                    @forelse($transactions as $trx)
                        <div class="deposit-card-mobile">
                            <div class="card-mobile-header">
                                <div class="card-mobile-avatar" style="background: var(--danger-red)">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="card-mobile-identity">
                                    <div class="card-mobile-name">{{ __($trx->details) }}</div>
                                    <div class="card-mobile-subtext">{{ $trx->trx }}</div>
                                </div>
                                <div class="card-mobile-status">
                                    <span class="badge"
                                        style="background: transparent; color: {{ $trx->trx_type == '+' ? '#00ff00' : '#ff3333' }}; font-weight: 700; border: 1px solid currentColor;">
                                        {{ $trx->trx_type }}{{ showAmount($trx->amount) }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-mobile-body">
                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-calendar-alt"></i> <span>Date & Time</span>
                                    </div>
                                    <div class="card-row-value">{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}</div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-money-bill-wave"></i> <span>Amount</span>
                                    </div>
                                    <div class="card-row-value"
                                        style="color: {{ $trx->trx_type == '+' ? '#00ff00' : '#ff3333' }}; font-weight: 700;">
                                        {{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-minus-circle"></i> <span>Charge</span>
                                    </div>
                                    <div class="card-row-value text-danger">
                                        {{ showAmount($trx->charge) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-wallet"></i> <span>Post Balance</span>
                                    </div>
                                    <div class="card-row-value" style="color: #fff; font-weight: 600;">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row" style="border:none;">
                                    <div class="card-row-label">
                                        <i class="fas fa-tag"></i> <span>Category</span>
                                    </div>
                                    <div class="card-row-value"
                                        style="font-size: 11px; font-weight: 400; max-width: 60%; text-align: right; color: var(--text-muted);">
                                        {{ __(keyToTitle($trx->remark)) }}
                                    </div>
                                </div>
                            </div>

                            <div class="card-mobile-actions">
                                <button class="view-details-btn-mobile detailBtn" data-trx="{{ $trx->trx }}"
                                    data-date="{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}"
                                    data-amount="{{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}"
                                    data-charge="{{ showAmount($trx->charge) }} {{ __($general->cur_text) }}"
                                    data-post_balance="{{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}"
                                    data-details="{{ __($trx->details) }}"
                                    data-type="{{ $trx->trx_type == '+' ? 'Credit' : 'Debit' }}"
                                    data-status_class="{{ $trx->trx_type == '+' ? 'success' : 'danger' }}">
                                    <i class="fas fa-eye"></i> View Full Details
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                            <p>No transactions found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Details Modal -->
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-receipt"></i> Transaction Details</h5>
                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="transaction-summary-header text-center p-3">
                        <div id="modalStatusIcon" class="status-icon-wrapper mb-2"></div>
                        <h3 id="modalAmount" class="final-amount mb-1 text-white font-weight-bold"></h3>
                        <div id="modalStatusBadge" class="status-label-badge mb-1"></div>
                    </div>

                    <div class="details-section p-3">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i
                                class="fas fa-info-circle mr-2"></i> Transaction Information</h6>
                        <div class="info-grid-modern">
                            <div class="info-item-modern">
                                <span class="label text-muted small">Transaction ID</span>
                                <span id="modalTrx" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Date & Time</span>
                                <span id="modalDate" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Charge</span>
                                <span id="modalCharge" class="value text-danger d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Post Balance</span>
                                <span id="modalPostBalance" class="value text-success d-block font-weight-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-dark-accent">
                        <h6 class="section-title text-muted text-uppercase small mb-1">Details</h6>
                        <p id="modalDetails" class="text-white mb-0 small"></p>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex !important; justify-content: flex-end !important;">
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> OK, Got it
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#copyBoard').click(function () {
                var copyText = document.getElementsByClassName("referral-input")[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                const btn = $(this);
                const originalHtml = btn.html();
                btn.html('<i class="fas fa-check"></i> Copied!');
                btn.css('background', 'var(--success-green)');

                setTimeout(() => {
                    btn.html(originalHtml);
                    btn.css('background', '');
                }, 2000);
            });

            class TradingChart {
                constructor(containerId, initialValue, userInvest, teamBusiness) {
                    this.container = document.getElementById(containerId);
                    this.initialValue = parseFloat(initialValue) || 1000;
                    this.userInvest = parseFloat(userInvest) || 0;
                    this.teamBusiness = parseFloat(teamBusiness) || 0;
                    this.currentValue = this.initialValue;
                    this.data = [];
                    this.allData = [];
                    this.isPlaying = true;
                    this.showMA = true;
                    this.showVolume = true;
                    this.timeframe = '5m';
                    this.updateIntervalId = null;

                    // Interactive Zoom & Pan States
                    this.visibleCandlesCount = 50;
                    this.scrollOffset = 0; // 0 = latest, >0 scrolled back in history

                    // Drag & Pan Event tracking
                    this.isDragging = false;
                    this.dragStartX = 0;
                    this.dragStartScrollOffset = 0;

                    this.initializeChart();
                    this.generateInitialData();
                    this.startLiveUpdate();
                }

                initializeChart() {
                    this.canvas = document.createElement('canvas');
                    this.canvas.className = 'chart-canvas';
                    this.canvas.style.cursor = 'grab';
                    this.canvas.style.width = '100%';
                    this.canvas.style.height = '100%';
                    this.canvas.style.display = 'block';
                    this.container.appendChild(this.canvas);

                    this.ctx = this.canvas.getContext('2d');
                    this.setupEventListeners();

                    this.resizeCanvas();
                    window.addEventListener('resize', () => {
                        this.resizeCanvas();
                    });
                }

                resizeCanvas() {
                    const dpr = window.devicePixelRatio || 1;
                    const rect = this.container.getBoundingClientRect();

                    this.canvas.width = rect.width * dpr;
                    this.canvas.height = rect.height * dpr;

                    this.width = rect.width;
                    this.height = rect.height;

                    this.ctx.resetTransform();
                    this.ctx.scale(dpr, dpr);
                    this.drawChart();
                }

                setupEventListeners() {
                    // Timeframe buttons
                    document.querySelectorAll('.timeframes .timeframe-btn').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            document.querySelectorAll('.timeframes .timeframe-btn').forEach(b => b.classList.remove('active'));
                            e.target.classList.add('active');
                            this.timeframe = e.target.textContent;

                            const label = document.querySelector('.chart-header .timeframe');
                            if (label) label.textContent = this.timeframe.toUpperCase();

                            this.generateInitialData();
                            this.startLiveUpdate();
                        });
                    });

                    // MA Button Toggle
                    const maBtn = document.querySelector('.chart-indicators button:nth-child(1)');
                    if (maBtn) {
                        maBtn.classList.add('active');
                        maBtn.addEventListener('click', () => {
                            this.showMA = !this.showMA;
                            maBtn.classList.toggle('active', this.showMA);
                            this.drawChart();
                        });
                    }

                    // Volume Button Toggle
                    const volBtn = document.querySelector('.chart-indicators button:nth-child(2)');
                    if (volBtn) {
                        volBtn.classList.add('active');
                        volBtn.addEventListener('click', () => {
                            this.showVolume = !this.showVolume;
                            volBtn.classList.toggle('active', this.showVolume);
                            this.drawChart();
                        });
                    }

                    // Mouse Zoom (Scroll Wheel)
                    this.canvas.addEventListener('wheel', (e) => {
                        e.preventDefault();
                        const zoomFactor = e.deltaY > 0 ? 3 : -3;
                        const previousCount = this.visibleCandlesCount;
                        this.visibleCandlesCount = Math.max(15, Math.min(150, this.visibleCandlesCount + zoomFactor));

                        // Adjust scrollOffset dynamically to keep zoom centered under mouse or latest
                        if (this.scrollOffset > 0) {
                            this.scrollOffset = Math.max(0, this.scrollOffset - (this.visibleCandlesCount - previousCount));
                        }

                        this.updateVisibleDataAndPrice();
                        this.drawChart();
                    }, { passive: false });

                    // Mouse Drag & Pan Start
                    this.canvas.addEventListener('mousedown', (e) => {
                        this.isDragging = true;
                        this.canvas.style.cursor = 'grabbing';
                        this.dragStartX = e.clientX;
                        this.dragStartScrollOffset = this.scrollOffset;
                    });

                    // Mouse Drag & Pan Active
                    this.canvas.addEventListener('mousemove', (e) => {
                        if (!this.isDragging) return;

                        const padding = { left: 15, right: 75 };
                        const chartWidth = this.width - padding.left - padding.right;
                        const candleSpacing = chartWidth / this.visibleCandlesCount;

                        const deltaX = e.clientX - this.dragStartX;
                        const scrollDelta = Math.round(-deltaX / candleSpacing);

                        const maxScroll = Math.max(0, this.allData.length - this.visibleCandlesCount);
                        this.scrollOffset = Math.max(0, Math.min(maxScroll, this.dragStartScrollOffset + scrollDelta));

                        this.updateVisibleDataAndPrice();
                        this.drawChart();
                    });

                    // Mouse Drag End
                    const stopDrag = () => {
                        if (this.isDragging) {
                            this.isDragging = false;
                            this.canvas.style.cursor = 'grab';
                        }
                    };
                    this.canvas.addEventListener('mouseup', stopDrag);
                    this.canvas.addEventListener('mouseleave', stopDrag);

                    // Touch support for Mobile Drag & Pan
                    let touchStartX = 0;
                    let lastTouchDist = 0;

                    this.canvas.addEventListener('touchstart', (e) => {
                        if (e.touches.length === 1) {
                            this.isDragging = true;
                            touchStartX = e.touches[0].clientX;
                            this.dragStartScrollOffset = this.scrollOffset;
                        } else if (e.touches.length === 2) {
                            // Initialize pinch to zoom on touch devices
                            this.isDragging = false;
                            lastTouchDist = Math.hypot(
                                e.touches[0].clientX - e.touches[1].clientX,
                                e.touches[0].clientY - e.touches[1].clientY
                            );
                        }
                    });

                    this.canvas.addEventListener('touchmove', (e) => {
                        if (e.touches.length === 1 && this.isDragging) {
                            e.preventDefault();
                            const padding = { left: 15, right: 75 };
                            const chartWidth = this.width - padding.left - padding.right;
                            const candleSpacing = chartWidth / this.visibleCandlesCount;

                            const deltaX = e.touches[0].clientX - touchStartX;
                            const scrollDelta = Math.round(-deltaX / candleSpacing);

                            const maxScroll = Math.max(0, this.allData.length - this.visibleCandlesCount);
                            this.scrollOffset = Math.max(0, Math.min(maxScroll, this.dragStartScrollOffset + scrollDelta));

                            this.updateVisibleDataAndPrice();
                            this.drawChart();
                        } else if (e.touches.length === 2) {
                            e.preventDefault();
                            // Pinch to zoom handler
                            const dist = Math.hypot(
                                e.touches[0].clientX - e.touches[1].clientX,
                                e.touches[0].clientY - e.touches[1].clientY
                            );
                            const deltaDist = dist - lastTouchDist;
                            if (Math.abs(deltaDist) > 5) {
                                const zoomFactor = deltaDist > 0 ? -2 : 2;
                                this.visibleCandlesCount = Math.max(15, Math.min(150, this.visibleCandlesCount + zoomFactor));
                                lastTouchDist = dist;
                                this.updateVisibleDataAndPrice();
                                this.drawChart();
                            }
                        }
                    }, { passive: false });

                    this.canvas.addEventListener('touchend', stopDrag);
                }

                generateInitialData() {
                    this.allData = [];
                    let value = this.initialValue;

                    // Generate a history of 200 candles so users can scroll back immediately
                    for (let i = 0; i < 200; i++) {
                        value = this.generateNextCandle(value);
                        const candle = {
                            time: i,
                            open: value,
                            high: value * (1 + Math.random() * 0.015),
                            low: value * (1 - Math.random() * 0.015),
                            close: this.generateNextCandle(value),
                            volume: Math.random() * 1000 + 500
                        };
                        if (candle.high <= candle.low) {
                            candle.high = candle.low * 1.01;
                        }
                        this.allData.push(candle);
                        value = candle.close;
                    }

                    this.currentValue = this.allData[this.allData.length - 1].close;
                    this.scrollOffset = 0; // Show latest
                    this.updateVisibleDataAndPrice();
                }

                generateNextCandle(previousClose) {
                    const baseValue = this.initialValue;
                    const deviation = (previousClose - baseValue) / baseValue;
                    const gravity = -deviation * 0.15;
                    const volatility = 0.015;
                    const randomWalk = (Math.random() * 2 - 1) * volatility;
                    const changePercent = randomWalk + gravity;
                    return previousClose * (1 + changePercent);
                }

                addNewCandle() {
                    if (!this.isPlaying) return;
                    const lastCandle = this.allData[this.allData.length - 1];
                    const newClose = this.generateNextCandle(lastCandle.close);

                    const newCandle = {
                        time: this.allData.length,
                        open: lastCandle.close,
                        high: Math.max(lastCandle.close, newClose) * (1 + Math.random() * 0.01),
                        low: Math.min(lastCandle.close, newClose) * (1 - Math.random() * 0.01),
                        close: newClose,
                        volume: Math.random() * 1000 + 500
                    };
                    if (newCandle.high <= newCandle.low) {
                        newCandle.high = newCandle.low * 1.01;
                    }

                    this.allData.push(newCandle);
                    this.currentValue = newCandle.close;

                    if (this.scrollOffset > 0) {
                        // Maintain the historical view offset
                        this.scrollOffset++;
                    }

                    this.updateVisibleDataAndPrice();
                    this.drawChart();
                }

                updateVisibleDataAndPrice() {
                    const end = Math.max(this.visibleCandlesCount, this.allData.length - this.scrollOffset);
                    const start = Math.max(0, end - this.visibleCandlesCount);

                    this.data = this.allData.slice(start, end);
                    this.updatePriceDisplay();
                }

                startLiveUpdate() {
                    if (this.updateIntervalId) {
                        clearInterval(this.updateIntervalId);
                    }

                    const speedMap = {
                        '1m': 1000,
                        '5m': 2000,
                        '15m': 4000,
                        '1h': 8000,
                        '4h': 15000,
                        '1d': 25000
                    };
                    const speed = speedMap[this.timeframe] || 2000;

                    this.updateIntervalId = setInterval(() => {
                        this.addNewCandle();
                    }, speed);
                }

                updatePriceDisplay() {
                    const priceElement = document.querySelector('.current-price');
                    const changeElement = document.querySelector('.price-change');

                    if (priceElement) {
                        const lastPrice = this.allData.length > 1 ? this.allData[this.allData.length - 2].close : this.initialValue;
                        const changePercent = ((this.currentValue - lastPrice) / lastPrice) * 100;

                        priceElement.textContent = `$${this.currentValue.toFixed(2)}`;

                        if (changeElement) {
                            const isPositive = changePercent >= 0;
                            changeElement.textContent = `${isPositive ? '+' : ''}${changePercent.toFixed(2)}%`;
                            changeElement.className = `price-change ${isPositive ? 'positive' : 'negative'}`;
                        }
                        const high = Math.max(...this.data.map(d => d.high));
                        const low = Math.min(...this.data.map(d => d.low));
                        const volume = this.data.reduce((sum, d) => sum + d.volume, 0);

                        const stats = document.querySelectorAll('.chart-stats .value');
                        if (stats[0]) stats[0].textContent = `$${high.toFixed(2)}`;
                        if (stats[1]) stats[1].textContent = `$${low.toFixed(2)}`;
                        if (stats[2]) stats[2].textContent = volume.toFixed(0);
                    }
                }

                drawChart() {
                    if (!this.ctx) return;
                    const width = this.width;
                    const height = this.height;

                    const padding = { top: 35, right: 75, bottom: 25, left: 15 };
                    const chartWidth = width - padding.left - padding.right;
                    const chartHeight = height - padding.top - padding.bottom;

                    this.ctx.clearRect(0, 0, width, height);

                    // Dark trading theme background
                    this.ctx.fillStyle = '#050505';
                    this.ctx.fillRect(0, 0, width, height);

                    if (this.data.length === 0) return;

                    const prices = this.data.flatMap(d => [d.high, d.low]);
                    const maxPrice = Math.max(...prices);
                    const minPrice = Math.min(...prices);

                    let priceRange = maxPrice - minPrice;
                    if (priceRange === 0) {
                        priceRange = maxPrice * 0.1 || 10; // 10% default range if range is zero (flat line)
                    }

                    const paddedMin = minPrice - priceRange * 0.08;
                    const paddedMax = maxPrice + priceRange * 0.08;
                    const paddedRange = paddedMax - paddedMin;

                    // 1. Grid Lines
                    this.drawGrid(padding, chartWidth, chartHeight, paddedMin, paddedMax);

                    // 2. Candlestick Spacing and Responsive Widths
                    const candleSpacing = chartWidth / this.visibleCandlesCount;
                    const candleWidth = Math.max(1.5, candleSpacing * 0.7);

                    // Pin the latest candles to the right side of the screen
                    const startX = padding.left + chartWidth - (this.data.length * candleSpacing);

                    for (let i = 0; i < this.data.length; i++) {
                        const candle = this.data[i];
                        const x = Math.round(startX + i * candleSpacing);

                        const openY = Math.round(padding.top + chartHeight - ((candle.open - paddedMin) / paddedRange) * chartHeight);
                        const closeY = Math.round(padding.top + chartHeight - ((candle.close - paddedMin) / paddedRange) * chartHeight);
                        const highY = Math.round(padding.top + chartHeight - ((candle.high - paddedMin) / paddedRange) * chartHeight);
                        const lowY = Math.round(padding.top + chartHeight - ((candle.low - paddedMin) / paddedRange) * chartHeight);
                        const isBullish = candle.close >= candle.open;

                        const candleColor = isBullish ? '#089981' : '#f23645';

                        // Volume overlay
                        if (this.showVolume) {
                            this.ctx.shadowBlur = 0;
                            const maxVolume = Math.max(...this.data.map(d => d.volume));
                            const volumeHeight = (candle.volume / maxVolume) * (chartHeight * 0.15);
                            this.ctx.fillStyle = isBullish ? 'rgba(8, 153, 129, 0.12)' : 'rgba(242, 54, 69, 0.12)';
                            this.ctx.fillRect(x, Math.round(height - padding.bottom), Math.max(1, Math.round(candleWidth)), -Math.round(volumeHeight));
                        }

                        // Wicks (drawn with integer pixel precision)
                        this.ctx.strokeStyle = candleColor;
                        this.ctx.lineWidth = 1.5;
                        this.ctx.beginPath();
                        const wickX = Math.round(x + candleWidth / 2);
                        this.ctx.moveTo(wickX, highY);
                        this.ctx.lineTo(wickX, lowY);
                        this.ctx.stroke();

                        // Solid Candle Bodies with pixel alignment to prevent blurring or splitting
                        this.ctx.fillStyle = candleColor;
                        const bodyTop = Math.min(openY, closeY);
                        const bodyHeight = Math.max(1.5, Math.abs(openY - closeY));

                        this.ctx.fillRect(x, bodyTop, Math.max(1, Math.round(candleWidth)), Math.round(bodyHeight));
                    }

                    // 3. Moving Average Line
                    if (this.showMA) {
                        this.drawMovingAverage(padding, chartWidth, chartHeight, paddedMin, paddedRange, candleSpacing, candleWidth, startX);
                    }

                    // 4. Draw Right price levels
                    this.drawPriceLabels(padding, chartWidth, chartHeight, paddedMin, paddedMax);

                    // 5. Dynamic time labels
                    this.drawTimeLabels(padding, chartWidth, chartHeight, candleSpacing, candleWidth, startX);

                    // 6. Live Dotted Price badge Y-axis
                    const lastCandle = this.data[this.data.length - 1];
                    const isBullish = lastCandle.close >= lastCandle.open;
                    const currentY = Math.round(padding.top + chartHeight - ((this.currentValue - paddedMin) / paddedRange) * chartHeight);
                    const liveColor = isBullish ? '#089981' : '#f23645';

                    this.ctx.setLineDash([3, 3]);
                    this.ctx.strokeStyle = liveColor;
                    this.ctx.lineWidth = 1.2;
                    this.ctx.beginPath();
                    this.ctx.moveTo(padding.left, currentY);
                    this.ctx.lineTo(padding.left + chartWidth, currentY);
                    this.ctx.stroke();
                    this.ctx.setLineDash([]);

                    // Price Badge
                    this.ctx.fillStyle = liveColor;
                    const badgeHeight = 18;
                    const badgeWidth = 65;
                    const badgeX = padding.left + chartWidth;
                    const badgeY = currentY - badgeHeight / 2;
                    this.ctx.fillRect(badgeX, badgeY, badgeWidth, badgeHeight);

                    this.ctx.fillStyle = '#ffffff';
                    this.ctx.font = 'bold 10px monospace';
                    this.ctx.textAlign = 'left';
                    this.ctx.textBaseline = 'middle';
                    this.ctx.fillText(this.currentValue.toFixed(2), badgeX + 6, currentY);

                    // 7. Legend Metadata
                    const lastPrice = this.allData.length > 1 ? this.allData[this.allData.length - 2].close : this.initialValue;
                    const changePercent = ((this.currentValue - lastPrice) / lastPrice) * 100;

                    this.ctx.textBaseline = 'top';
                    this.ctx.textAlign = 'left';

                    this.ctx.fillStyle = '#c5cbdb';
                    this.ctx.font = 'bold 11px sans-serif';
                    this.ctx.fillText(`TEAM/BUSINESS · ${this.timeframe.toUpperCase()} · KREDOX (Drag & Scroll to Interactive)`, padding.left + 5, 10);

                    this.ctx.font = '10px monospace';
                    this.ctx.fillStyle = '#8a8d97';
                    let legendText = `O:${lastCandle.open.toFixed(2)}  H:${lastCandle.high.toFixed(2)}  L:${lastCandle.low.toFixed(2)}  C:${lastCandle.close.toFixed(2)}`;
                    this.ctx.fillText(legendText, padding.left + 5, 23);

                    this.ctx.fillStyle = changePercent >= 0 ? '#089981' : '#f23645';
                    this.ctx.fillText(`${changePercent >= 0 ? '+' : ''}${changePercent.toFixed(2)}%`, padding.left + 230, 23);
                }

                drawGrid(padding, chartWidth, chartHeight, minPrice, maxPrice) {
                    this.ctx.strokeStyle = 'rgba(255, 0, 50, 0.04)';
                    this.ctx.lineWidth = 1;
                    this.ctx.setLineDash([3, 3]);

                    const horizontalLines = 5;
                    for (let i = 0; i <= horizontalLines; i++) {
                        const y = Math.round(padding.top + (chartHeight / horizontalLines) * i);
                        this.ctx.beginPath();
                        this.ctx.moveTo(padding.left, y);
                        this.ctx.lineTo(padding.left + chartWidth, y);
                        this.ctx.stroke();
                    }

                    const verticalLines = 8;
                    for (let i = 0; i <= verticalLines; i++) {
                        const x = Math.round(padding.left + (chartWidth / verticalLines) * i);
                        this.ctx.beginPath();
                        this.ctx.moveTo(x, padding.top);
                        this.ctx.lineTo(x, padding.top + chartHeight);
                        this.ctx.stroke();
                    }

                    this.ctx.setLineDash([]);
                }

                drawMovingAverage(padding, chartWidth, chartHeight, paddedMin, paddedRange, candleSpacing, candleWidth, startX) {
                    const period = 9;
                    if (this.data.length < period) return;

                    this.ctx.shadowBlur = 8;
                    this.ctx.shadowColor = '#ff3c3c';
                    this.ctx.strokeStyle = '#ff3c3c';
                    this.ctx.lineWidth = 1.5;
                    this.ctx.beginPath();

                    for (let i = period - 1; i < this.data.length; i++) {
                        let sum = 0;
                        for (let j = 0; j < period; j++) {
                            sum += this.data[i - j].close;
                        }
                        const ma = sum / period;
                        const x = Math.round(startX + i * candleSpacing + candleWidth / 2);
                        const y = Math.round(padding.top + chartHeight - ((ma - paddedMin) / paddedRange) * chartHeight);

                        if (i === period - 1) {
                            this.ctx.moveTo(x, y);
                        } else {
                            this.ctx.lineTo(x, y);
                        }
                    }

                    this.ctx.stroke();
                    this.ctx.shadowBlur = 0;
                }

                drawPriceLabels(padding, chartWidth, chartHeight, minPrice, maxPrice) {
                    this.ctx.fillStyle = '#8a8d97';
                    this.ctx.font = '10px monospace';
                    this.ctx.textAlign = 'left';
                    this.ctx.textBaseline = 'middle';

                    const priceLevels = 5;
                    for (let i = 0; i <= priceLevels; i++) {
                        const price = minPrice + (maxPrice - minPrice) * (i / priceLevels);
                        const y = Math.round(padding.top + (chartHeight / priceLevels) * (priceLevels - i));

                        this.ctx.fillText(`$${price.toFixed(2)}`, padding.left + chartWidth + 8, y);
                    }
                }

                drawTimeLabels(padding, chartWidth, chartHeight, candleSpacing, candleWidth, startX) {
                    this.ctx.fillStyle = '#8a8d97';
                    this.ctx.font = '10px monospace';
                    this.ctx.textAlign = 'center';
                    this.ctx.textBaseline = 'top';

                    const labelStep = Math.max(5, Math.ceil(this.data.length / 6));
                    for (let i = 0; i < this.data.length; i += labelStep) {
                        const candle = this.data[i];
                        const x = Math.round(startX + i * candleSpacing + candleWidth / 2);
                        const y = padding.top + chartHeight + 8;

                        const minutes = (candle.time * 5) % 60;
                        const hours = (9 + Math.floor((candle.time * 5) / 60)) % 24;
                        const timeStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

                        this.ctx.fillText(timeStr, x, y);
                    }
                }
            }
            $(document).ready(function () {
                const bgVideo = document.getElementById('myVideo');
                if (bgVideo) bgVideo.playbackRate = 0.5; // Slow down background video for a more premium feel

                const userInvest = parseFloat("{{ $totalInvest }}") || 0;
                const teamBusiness = parseFloat("{{ $transactionsdataa }}") || 0;
                const totalCapital = userInvest + teamBusiness;
                const tradingChart = new TradingChart('teamGrowthChart', totalCapital, userInvest, teamBusiness);

                // Trigger initial resize to ensure canvas size measures correctly
                setTimeout(function () {
                    window.dispatchEvent(new Event('resize'));
                }, 100);

                // Toggle Fullscreen Team Performance Card
                $('.team-card .card-header .card-actions button').on('click', function () {
                    const $card = $(this).closest('.team-card');
                    const $icon = $(this).find('i');

                    $card.toggleClass('fullscreen-card');

                    if ($card.hasClass('fullscreen-card')) {
                        $icon.removeClass('fa-expand-alt').addClass('fa-compress-alt');
                        $('body').css('overflow', 'hidden'); // Prevent background scroll
                    } else {
                        $icon.removeClass('fa-compress-alt').addClass('fa-expand-alt');
                        $('body').css('overflow', '');
                    }

                    // Dynamic canvas resize recalculation
                    setTimeout(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 150);
                });

                $(window).on('scroll', function () {
                    $('.stat-card').each(function () {
                        if ($(this).offset().top < $(window).scrollTop() + $(window).height() - 100) {
                            $(this).addClass('animated');
                        }
                    });
                });
                $(window).trigger('scroll');
                $('a[href^="#"]').on('click', function (event) {
                    if (this.hash !== "") {
                        event.preventDefault();
                        const hash = this.hash;
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top - 100
                        }, 800);
                    }
                });

                // Real-time overview refresh with skeleton loading animation
                $('#refreshOverview').on('click', function () {
                    const $btn = $(this);
                    const $icon = $btn.find('i');
                    const $content = $('.overview-content');
                    const $skeleton = $('.overview-skeleton');

                    // 1. Trigger spinning animation on the refresh icon
                    $icon.addClass('fa-spin');
                    $btn.prop('disabled', true);

                    // 2. Fade out original content, fade in skeleton
                    $content.fadeOut(200, function () {
                        $skeleton.fadeIn(200);

                        // 3. Make AJAX call to fetch live, fresh stats from server
                        $.ajax({
                            url: "{{ route('user.home') }}",
                            type: 'GET',
                            data: { get_overview: 1 },
                            success: function (response) {
                                // Simulate network delay for premium visual feedback
                                setTimeout(function () {
                                    // 4. Update the values in the DOM
                                    $('#valTotalInvest').find('span').text(response.totalInvest);
                                    $('#valTotalReceived').find('span').text(response.totalReceived);
                                    $('#valRemaining').find('span').text(response.remaining);
                                    $('#valTotalPotential').find('span').text(response.totalPotential);

                                    // 5. Fade out skeleton, fade in updated content
                                    $skeleton.fadeOut(200, function () {
                                        $content.fadeIn(200);
                                        $icon.removeClass('fa-spin');
                                        $btn.prop('disabled', false);
                                    });
                                }, 1000); // 1-second premium high-tech delay
                            },
                            error: function () {
                                // Fallback in case of server error
                                setTimeout(function () {
                                    $skeleton.fadeOut(200, function () {
                                        $content.fadeIn(200);
                                        $icon.removeClass('fa-spin');
                                        $btn.prop('disabled', false);
                                    });
                                }, 1000);
                            }
                        });
                    });
                });

                $('.detailBtn').on('click', function () {
                    var modal = $('#detailModal');
                    var btn = $(this);

                    modal.find('#modalTrx').text(btn.data('trx'));
                    modal.find('#modalDate').text(btn.data('date'));
                    modal.find('#modalAmount').text(btn.data('amount'));
                    modal.find('#modalCharge').text(btn.data('charge'));
                    modal.find('#modalPostBalance').text(btn.data('post_balance'));
                    modal.find('#modalDetails').text(btn.data('details'));

                    var statusText = btn.data('type');
                    var statusClass = btn.data('status_class');
                    var iconHtml = '';

                    if (statusClass == 'success') iconHtml = '<i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>';
                    else iconHtml = '<i class="fas fa-arrow-circle-down text-danger" style="font-size: 40px;"></i>';

                    modal.find('#modalStatusIcon').html(iconHtml);
                    modal.find('#modalStatusBadge').html(`<span class="badge badge--${statusClass} text-uppercase px-3 py-2 font-weight-bold" style="letter-spacing: 1px;">${statusText}</span>`);

                    modal.modal('show');
                });
            });

        })(jQuery);
    </script>
    <style>
        footer {
            display: none !important;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-10deg);
            width: 300px;
            height: 300px;
            background: url("{{ getImage(getFilePath('logoIcon') . '/logo.png') }}") no-repeat center;
            background-size: contain;
            opacity: 0.05;
            z-index: 0;
            pointer-events: none;
            filter: grayscale(100%) brightness(2);
        }

        /* Skeleton Loader Styles */
        .skeleton-box {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 0, 0, 0.05) !important;
            border-radius: 12px !important;
            padding: 15px 20px !important;
            position: relative;
            overflow: hidden;
        }

        .skeleton-line {
            height: 12px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .skeleton-label {
            width: 40%;
        }

        .skeleton-value {
            width: 60%;
            height: 22px;
        }

        .skeleton-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        /* Shimmer overlay effect */
        .skeleton-line::after,
        .skeleton-circle::after,
        .skeleton-box::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(255, 0, 0, 0.06) 20%,
                    rgba(255, 0, 0, 0.12) 60%,
                    transparent 100%);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        /* Premium Invest Now Button in Card Header */
        .invest-now-btn-header {
            background: rgba(0, 255, 102, 0.08) !important;
            border: 1px solid rgba(0, 255, 102, 0.3) !important;
            color: #00ff66 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 14px !important;
            width: auto !important;
            height: 34px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-right: 8px;
            text-decoration: none !important;
        }

        .invest-now-btn-header:hover {
            background: linear-gradient(135deg, #004d20 0%, #00cc52 100%) !important;
            border-color: rgba(0, 255, 102, 0.8) !important;
            color: #fff !important;
            box-shadow: 0 0 15px rgba(0, 255, 102, 0.35) !important;
            transform: translateY(-1px) !important;
        }

        /* Refresh action button hover animation */
        .refresh-overview-btn:hover i {
            animation: spinFast 0.8s ease-in-out;
        }

        @keyframes spinFast {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Fullscreen card expansion style aligned to navigation sidebar */
        .team-card.fullscreen-card {
            position: fixed !important;
            top: 0 !important;
            left: 280px !important;
            width: calc(100vw - 280px) !important;
            height: 100vh !important;
            z-index: 999999 !important;
            margin: 0 !important;
            border-radius: 0 !important;
            background: rgba(10, 10, 10, 0.99) !important;
            backdrop-filter: blur(20px) !important;
            padding: 0 !important;
            /* Enable absolute header alignment */
            display: flex !important;
            flex-direction: column !important;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.6) !important;
            border-left: 1px solid var(--border-red) !important;
            overflow: hidden !important;
            /* Locks header scroll */
        }

        /* Permanently fixed header inside expanded cockpit */
        .team-card.fullscreen-card .card-header {
            position: relative !important;
            padding: 20px 30px !important;
            background: rgba(10, 10, 10, 1) !important;
            border-bottom: 1px solid var(--border-red) !important;
            flex-shrink: 0 !important;
            z-index: 10 !important;
        }

        /* Independent scrollable body underneath the header */
        .team-card.fullscreen-card .card-body {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            padding: 30px !important;
            overflow-y: auto !important;
            /* Only card body scrolls */
            gap: 20px !important;
        }

        /* Responsive full-width expanded view on smaller devices */
        @media screen and (max-width: 991px) {
            .team-card.fullscreen-card {
                left: 0 !important;
                width: 100vw !important;
                border-left: none !important;
            }

            .team-card.fullscreen-card .card-header {
                padding: 15px 20px !important;
            }

            .team-card.fullscreen-card .card-body {
                padding: 20px 15px !important;
            }
        }

        .team-card.fullscreen-card .team-chart-container {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
            min-height: 400px !important;
        }

        .team-card.fullscreen-card .trading-chart-wrapper {
            flex: 1 !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .team-card.fullscreen-card .trading-chart {
            flex: 1 !important;
            height: auto !important;
            min-height: 350px !important;
        }

        /* ==========================================================================
                       PREMIUM TRADINGVIEW DARK ACCENT STYLING
                       ========================================================================== */

        /* 1. Immersive Glassmorphic Card Container */
        .team-card {
            background: linear-gradient(135deg, #0d0d0d 0%, #050505 100%) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 0, 50, 0.15) !important;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.7),
                inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        }

        .team-card:hover {
            border-color: rgba(255, 0, 50, 0.3) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.85),
                0 0 25px rgba(255, 0, 50, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.08) !important;
        }

        /* 2. Sleek Widget Header & Grid Stats */
        .team-card .card-header {
            background: rgba(5, 5, 5, 0.95) !important;
            border-bottom: 1px solid rgba(255, 0, 50, 0.1) !important;
            padding: 18px 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .team-card .card-header h3 {
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            letter-spacing: 0.5px !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .team-card .card-header h3 i {
            color: var(--border-red) !important;
            text-shadow: 0 0 10px rgba(255, 60, 60, 0.4) !important;
        }

        /* 3. Team Statistics Blocks */
        .team-stats {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 16px !important;
            margin-bottom: 24px !important;
        }

        .team-stat {
            background: rgba(0, 0, 0, 0.5) !important;
            border: 1px solid rgba(255, 0, 50, 0.05) !important;
            border-radius: 12px !important;
            padding: 16px !important;
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            transition: all 0.3s ease !important;
        }

        .team-stat:hover {
            background: rgba(255, 0, 50, 0.02) !important;
            border-color: rgba(255, 0, 50, 0.2) !important;
            transform: translateY(-2px) !important;
        }

        .team-stat .stat-icon {
            width: 44px !important;
            height: 44px !important;
            border-radius: 10px !important;
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%) !important;
            border: 1px solid rgba(255, 0, 50, 0.2) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-size: 18px !important;
            text-shadow: 0 0 8px rgba(255, 0, 50, 0.3) !important;
        }

        .team-stat .stat-content h4 {
            font-size: 12px !important;
            font-weight: 600 !important;
            color: #8a8d97 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            margin: 0 0 4px 0 !important;
        }

        .team-stat .stat-content h2 {
            font-size: 20px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            margin: 0 0 2px 0 !important;
        }

        .team-stat .stat-content p {
            font-size: 11px !important;
            color: #5d606b !important;
            margin: 0 !important;
        }

        /* 4. Sleek Trading View wrapper */
        .trading-chart-wrapper {
            background: #050505 !important;
            /* Pure Dark Carbon Black */
            border: 1px solid rgba(255, 0, 50, 0.08) !important;
            border-radius: 12px !important;
            padding: 2px !important;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.6) !important;
        }

        /* 5. Chart Header Stats display */
        .chart-header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding-bottom: 12px !important;
            border-bottom: 1px solid rgba(255, 0, 50, 0.08) !important;
            margin-bottom: 12px !important;
        }

        .chart-title {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .live-indicator {
            background: rgba(8, 153, 129, 0.12) !important;
            border: 1px solid rgba(8, 153, 129, 0.25) !important;
            color: #089981 !important;
            font-size: 9px !important;
            font-weight: 700 !important;
            letter-spacing: 1px !important;
            padding: 3px 8px !important;
            border-radius: 4px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
        }

        .live-indicator i {
            animation: pulse-glow 1.5s infinite ease-in-out !important;
        }

        @keyframes pulse-glow {
            0% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.4;
            }
        }

        .chart-symbol {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #c5cbdb !important;
            letter-spacing: 0.5px !important;
        }

        .chart-title .timeframe {
            font-size: 10px !important;
            font-weight: 700 !important;
            color: #8a8d97 !important;
            background: rgba(255, 255, 255, 0.04) !important;
            padding: 2px 6px !important;
            border-radius: 3px !important;
        }

        .chart-price {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .current-price {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            font-family: monospace !important;
        }

        .price-change {
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 2px 6px !important;
            border-radius: 4px !important;
            font-family: monospace !important;
        }

        .price-change.positive {
            background: rgba(8, 153, 129, 0.12) !important;
            color: #089981 !important;
        }

        .price-change.negative {
            background: rgba(242, 54, 69, 0.12) !important;
            color: #f23645 !important;
        }

        /* 6. TradingView Toolbar controls */
        .chart-tools {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 16px !important;
            margin-bottom: 12px !important;
            flex-wrap: wrap !important;
        }

        .timeframes {
            display: flex !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 2px !important;
            border-radius: 6px !important;
            gap: 2px !important;
            align-items: center !important;
        }

        .timeframe-btn {
            background: transparent !important;
            border: none !important;
            outline: none !important;
            color: #8a8d97 !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 0 10px !important;
            height: 26px !important;
            line-height: 26px !important;
            border-radius: 4px !important;
            transition: all 0.2s ease !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .timeframe-btn:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.04) !important;
        }

        /* Premium Neon Red Active Timeframe Toggle */
        .timeframe-btn.active {
            background: linear-gradient(135deg, #e60028 0%, #b4001e 100%) !important;
            border-color: #ff3c3c !important;
            color: #ffffff !important;
            box-shadow: 0 3px 10px rgba(255, 0, 50, 0.4) !important;
        }

        .chart-indicators {
            display: flex !important;
            gap: 6px !important;
            align-items: center !important;
        }

        .indicator-btn {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            color: #c5cbdb !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            padding: 0 12px !important;
            height: 32px !important;
            line-height: 32px !important;
            border-radius: 6px !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            cursor: pointer !important;
            outline: none !important;
        }

        .indicator-btn:hover {
            background: rgba(255, 255, 255, 0.06) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }

        /* Glowing Active Dark Red indicator toggles */
        .indicator-btn.active {
            background: rgba(255, 0, 50, 0.12) !important;
            border-color: rgba(255, 0, 50, 0.4) !important;
            color: #ff3c3c !important;
            box-shadow: 0 0 12px rgba(255, 0, 50, 0.25) !important;
            text-shadow: 0 0 4px rgba(255, 0, 50, 0.3) !important;
        }

        /* 7. Chart Canvas Container */
        .trading-chart {
            border: 1px solid rgba(255, 255, 255, 0.03) !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            background: #131722 !important;
            height: 300px !important;
        }

        .chart-canvas {
            display: block !important;
            width: 100% !important;
            height: 100% !important;
        }

        /* 8. Chart Footer and Controls */
        .chart-footer {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-top: 12px !important;
            padding-top: 12px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.04) !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
        }

        .chart-stats {
            display: flex !important;
            gap: 16px !important;
        }

        .chart-stats .stat {
            display: flex !important;
            flex-direction: column !important;
        }

        .chart-stats .stat .label {
            font-size: 9px !important;
            font-weight: 600 !important;
            color: #5d606b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            margin-bottom: 2px !important;
        }

        .chart-stats .stat .value {
            font-size: 11px !important;
            font-weight: 700 !important;
            font-family: monospace !important;
        }

        .chart-stats .stat .value.positive {
            color: #089981 !important;
        }

        .chart-stats .stat .value.negative {
            color: #f23645 !important;
        }

        .chart-stats .stat .value:not(.positive):not(.negative) {
            color: #c5cbdb !important;
        }

        .chart-controls {
            display: flex !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 2px !important;
            border-radius: 6px !important;
            gap: 2px !important;
        }



        /* ===== High-Fidelity Premium Mobile Overrides ===== */
        @media screen and (max-width: 767px) {

            /* 1. Base Grid and Containers ordering (Chart Card first!) */
            .dashboard-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 16px !important;
                padding: 4px !important;
            }

            .grid-left {
                order: 1 !important;
                width: 100% !important;
            }

            .grid-right {
                order: 2 !important;
                width: 100% !important;
            }

            .card {
                margin-bottom: 0px !important;
            }

            .card-header {
                padding: 12px 14px !important;
            }

            .card-header h3 {
                font-size: 13.5px !important;
            }

            .card-body {
                padding: 12px 1px !important;
            }

            /* 2. Compact 2x2 Grid for Quick Stats (Amazing screen estate optimization!) */
            .quick-stats {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
                margin-bottom: 12px !important;
            }

            .stat-card {
                padding: 12px 10px !important;
                gap: 8px !important;
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
                border-radius: 10px !important;
                min-height: auto !important;
            }

            .stat-icon {
                width: 32px !important;
                height: 32px !important;
                font-size: 14px !important;
                border-radius: 6px !important;
                margin-right: 0 !important;
                margin-bottom: 2px !important;
            }

            .stat-info {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                flex: none !important;
                width: 100% !important;
            }

            .stat-info h4 {
                font-size: 10.5px !important;
                margin-bottom: 3px !important;
                font-weight: 600 !important;
            }

            .stat-info h3 {
                font-size: 15px !important;
                letter-spacing: 0px !important;
            }

            .stat-trend {
                font-size: 9px !important;
                padding: 2px 6px !important;
                border-radius: 10px !important;
                margin-top: 2px !important;
            }

            /* 3. Team Stats Cards stacking */
            .team-stats {
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 10px !important;
                margin-bottom: 12px !important;
            }

            .team-stat {
                width: 100% !important;
                padding: 12px !important;
                gap: 10px !important;
                border-radius: 8px !important;
            }

            .team-stat .stat-icon {
                width: 36px !important;
                height: 36px !important;
                font-size: 14px !important;
                border-radius: 6px !important;
            }

            .team-stat .stat-content h4 {
                font-size: 11.5px !important;
                margin-bottom: 2px !important;
            }

            .team-stat .stat-content h2 {
                font-size: 16px !important;
                margin-bottom: 2px !important;
            }

            .team-stat .stat-content p {
                font-size: 9.5px !important;
            }

            /* 4. Trading Chart Header on Mobile */
            .chart-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 6px !important;
                padding: 8px !important;
                background: rgba(255, 255, 255, 0.01) !important;
                border-radius: 6px !important;
                border: 1px solid rgba(255, 255, 255, 0.03) !important;
                margin-bottom: 10px !important;
            }

            .chart-title {
                display: flex !important;
                align-items: center !important;
                gap: 6px !important;
                width: 100% !important;
            }

            .chart-symbol {
                font-size: 10.5px !important;
            }

            .timeframe {
                font-size: 8px !important;
                padding: 1px 4px !important;
            }

            .chart-price {
                display: flex !important;
                align-items: baseline !important;
                justify-content: space-between !important;
                width: 100% !important;
                margin-top: 2px !important;
                border-top: 1px solid rgba(255, 255, 255, 0.03) !important;
                padding-top: 6px !important;
            }

            .current-price {
                font-size: 18px !important;
            }

            .price-change {
                font-size: 9.5px !important;
                padding: 1px 4px !important;
            }

            /* 5. Trading Chart Tools and Controls on Mobile */
            .chart-tools {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                gap: 8px !important;
                margin-bottom: 10px !important;
                overflow-x: auto !important;
                scrollbar-width: none !important;
                -webkit-overflow-scrolling: touch !important;
            }

            .chart-tools::-webkit-scrollbar {
                display: none !important;
            }

            .timeframes {
                display: flex !important;
                width: auto !important;
                justify-content: flex-start !important;
                align-items: center !important;
                gap: 4px !important;
                flex-shrink: 0 !important;
            }

            .timeframe-btn {
                flex: 0 0 auto !important;
                padding: 0 8px !important;
                height: 26px !important;
                line-height: 26px !important;
                text-align: center !important;
                font-size: 9.5px !important;
                min-width: 28px !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 4px !important;
            }

            .chart-indicators {
                display: flex !important;
                align-items: center !important;
                gap: 4px !important;
                flex-shrink: 0 !important;
            }

            .indicator-btn {
                padding: 0 8px !important;
                height: 32px !important;
                line-height: 32px !important;
                font-size: 10px !important;
                border-radius: 5px !important;
                flex-shrink: 0 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            /* 6. Trading Chart Canvas Container on Mobile */
            .trading-chart {
                height: 220px !important;
                border-radius: 6px !important;
            }

            /* 7. Trading Chart Footer Stats on Mobile */
            .chart-footer {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 8px !important;
                padding-top: 8px !important;
                margin-top: 8px !important;
            }

            .chart-stats {
                display: flex !important;
                justify-content: space-between !important;
                width: 100% !important;
                gap: 6px !important;
            }

            .chart-stats .stat {
                flex: 1 !important;
                align-items: center !important;
                background: rgba(255, 255, 255, 0.01) !important;
                padding: 5px !important;
                border-radius: 5px !important;
                border: 1px solid rgba(255, 255, 255, 0.03) !important;
            }

            .chart-stats .stat .label {
                font-size: 8px !important;
                margin-bottom: 1px !important;
            }

            .chart-stats .stat .value {
                font-size: 9.5px !important;
            }

            /* 8. Secure Node Allocation Key Mobile Fixes */
            .referral-box {
                padding: 12px !important;
            }

            .node-description-text {
                font-size: 11.5px !important;
                line-height: 1.4 !important;
            }

            .referral-input-group {
                flex-direction: column !important;
                gap: 8px !important;
            }

            .referral-input {
                font-size: 11px !important;
                padding: 8px !important;
                text-align: center !important;
            }

            .copy-btn {
                width: 100% !important;
                padding: 8px !important;
                font-size: 12px !important;
            }

            /* 9. Earnings breakdown on Mobile */
            .earnings-total {
                margin-bottom: 16px !important;
                padding-bottom: 16px !important;
            }

            .earnings-total h2 {
                font-size: 24px !important;
            }

            .earnings-total p {
                font-size: 11.5px !important;
            }

            .earnings-breakdown {
                gap: 8px !important;
            }

            .breakdown-item {
                padding: 8px 0 !important;
            }

            .item-label {
                gap: 8px !important;
            }

            .item-label i {
                font-size: 12px !important;
            }

            .item-label span {
                font-size: 11.5px !important;
            }

            .item-value {
                font-size: 11.5px !important;
            }

            /* 10. Recent Activity list items on Mobile */
            .activity-item {
                padding: 8px !important;
                gap: 8px !important;
                margin-bottom: 6px !important;
                border-radius: 6px !important;
            }

            .activity-icon {
                width: 28px !important;
                height: 28px !important;
                font-size: 11px !important;
                border-radius: 5px !important;
            }

            .activity-details h5 {
                font-size: 10.5px !important;
            }

            .activity-details p {
                font-size: 8.5px !important;
            }

            .activity-time {
                font-size: 8.5px !important;
            }
        }
    </style>
@endpush