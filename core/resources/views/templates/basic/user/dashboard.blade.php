@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kycInfo = getContent('kyc_info.content', true);
        
    @endphp
    
   

    <div class="dashboard-section padding-top padding-bottom">
        
     
     
             <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="{{ route('plan') }}" class="nav__link nav__link">
    <i class="material-icons nav__icon">travel_explore</i>
    <span class="nav__text">Plan</span>
  </a>
  <a href="https://yukotrader.com/user/deposit" class="nav__link">
    <i class="material-icons nav__icon">add_card</i>
    <span class="nav__text">Deposit</span>
  </a>
  <a href="https://yukotrader.com/user/withdraw" class="nav__link">
    <i class="material-icons nav__icon">request_quote</i>
    <span class="nav__text">Withdraw</span>
  </a>
  <a href="https://yukotrader.com/user/referral/users" class="nav__link">
    <i class="material-icons nav__icon">diversity_3</i>
    <span class="nav__text">My Team</span>
  </a>
   <a href="https://yukotrader.com/user/logout" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
  </a>
  
  
</nav>

        
  <style>
  body {
    margin: 0 0 55px 0;
}

.nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 55px;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    background: -webkit-linear-gradient(-90deg, #124656 0%, #063a4a 45%, #063b46 100%);
    display: flex;
    overflow-x: auto;
    z-index:2;
}

.nav__link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #e1d4d4;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}

.nav__link:hover {
    background-color: #eeeeee;
}

.nav__link--active {
    color: #009578;
}

.nav__icon {
    font-size: 21px;
}
@media screen and (min-width: 600px) {
  .nav {
  display: none;
  }
}

  </style>
     
     
     
<!--
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="https://yukotrader.com/user/deposit" class="nav__link nav__link--active">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">devices</i>
    <span class="nav__text">Devices</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">lock</i>
    <span class="nav__text">Privacy</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">settings</i>
    <span class="nav__text">Settings</span>
  </a>
</nav>

        
  <style>
  body {
    margin: 0 0 55px 0;
}

.nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 55px;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
    display: flex;
    overflow-x: auto;
    z-index:2;
}

.nav__link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #444444;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}

.nav__link:hover {
    background-color: #eeeeee;
}

.nav__link--active {
    color: #009578;
}

.nav__icon {
    font-size: 18px;
}
@media screen and (min-width: 600px) {
  .nav__link {
  display: none;
  }
}

  </style>
 -->
  <!--
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="mobile-nav">
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">devices</i>
    <span class="nav__text">Devices</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">lock</i>
    <span class="nav__text">Privacy</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">settings</i>
    <span class="nav__text">Settings</span>
  </a>
</nav>
     <style>
     .nav__icon {
    font-size: 18px;
}
     
     .mobile-nav {
  background: #F1F1F1;
  position: fixed;
  bottom: 0;
  height: 65px;
  width: 100%;
  display: flex;
  justify-content: space-around;
  z-index:99;
}

.bloc-icon {
  display: flex;
  justify-content: center;
  align-items: center;
}

.bloc-icon img {
  width: 30px;
}

@media screen and (min-width: 600px) {
  .mobile-nav {
  display: none;
  }
}









     </style>
        
        -->
        
        <div class="container">
            
            
            
      
        <section>
            
        <div class="video-background">
        <div class="video-foreground">
        <video autoplay muted loop id="myVideo">
        <source src="https://yukotrader.com/video.mp4" type="video/mp4">
        </video>
        </div>
        </div>
        </section>
<style>
    #myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
  opacity: 5.70;
  filter: blur(0px);
}
</style>

 <h4 class="welcome-message">Welcome back, <span class="user-name">{{ $user->firstname }} {{ $user->lastname }}</span> ({{ $username }})</h4>
<br>

<style>
.welcome-message {
    transform: matrix(1, 0, 0, 1, 0, 0);
    color: #FFFFFF;
    font-family: Arial, sans-serif;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0 0 0 1px #fff;
    background-image: url(https://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpg);
}

.user-name {
    transform: matrix(1, 0, 0, 1, 0, 0);
    color: #E74C3C;
    font-weight: bold;
}
</style>

<!--
  <h4 class="memory001">Welcome back, <span style="color: red;">{{ $user->firstname }} {{ $user->lastname }}</span> ({{ $username }})</h4>
<br>


    <style>
 .memory001{
transform: matrix(1, 0, 0, 1, 0, 0);
    color: aliceblue;
}
}
    </style>
    -->

           @if (auth()->user()->kv == 0)
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading">@lang('KYC Verification required')</h5>
                    <hr>
                    <p class="mb-0">{{ __($kycInfo->data_values->verification_content) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a></p>
                </div>
            @elseif(auth()->user()->kv == 2)
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading">@lang('KYC Verification pending')</h5>
                    <hr>
                    <p class="mb-0">{{ __($kycInfo->data_values->pending_content) }} <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                </div>
            @endif

            <div class="row justify-content-center mb-30-none"> 
                <div class="col-md-12">
                    <div class="input-group contact-form-group">
                        <input type="text" name="key" value="{{ route('home') }}?reference={{ $username }}"
                            class="form-control referralURL referral-input" readonly>
                        <button type="button" class="input-group-text copytext bg--base border--base text-white"
                            id="copyBoard"> <i class="fa fa-copy"></i> </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Current Balance')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($balance) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Deposit')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($deposit) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Withdraw')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($withdraw) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                       <div class="dashboard-content totalammbr">
    <h5 class="title">@lang('Total Team Business')</h5>
    <?php
        $transactionsdataa = 0;

        // Function to get all referred users recursively up to a certain level
        function getAllReferredUsers($userIds, $level = 1, $maxLevel = 10) {
            if ($level > $maxLevel) return $userIds;

            $referredUsers = DB::table('users')->whereIn('ref_by', $userIds)->pluck('id')->toArray();

            if (empty($referredUsers)) return $userIds;

            $userIds = array_merge($userIds, getAllReferredUsers($referredUsers, $level + 1, $maxLevel));
            return $userIds;
        }

        // Get the initial list of referred users
        $initialUsers = DB::table('users')->where('ref_by', auth()->user()->id)->pluck('id')->toArray();

        if (!empty($initialUsers)) {
            // Get all referred users up to the 10th level
            $allReferredUsers = getAllReferredUsers($initialUsers);

            // Remove duplicate user IDs
            $uniqueUserIds = array_values(array_unique($allReferredUsers));

            // Calculate the total transaction amount
            $transactionsdataa = DB::table('transactions')
                ->where('remark', 'LIKE', '%plan_purchase%')
                ->whereIn('user_id', $uniqueUserIds)
                ->sum('amount');
        }
        $trantipl = DB::table('transactions')
        ->where('user_id', auth()->user()->id)
        ->where('remark', 'like', '%plan_purchase%')
        ->sum('amount');

        $contractReturn = $trantipl * 3;

        $contractReceived = DB::table('transactions')
            ->where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('remark', 'like', '%referral_commission%')
                    ->orWhere('remark', 'like', '%level%commission%')
                    ->orWhere('remark', 'like', 'daily_referral')
                    ->orWhere('remark', 'like', '%manual_payment%');
            })
            ->sum('amount');

        $contractBalance = $contractReturn - $contractReceived;
        $dailyIncome = DB::table('transactions')
        ->where('user_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('remark', 'like', '%manual_payment%')
                ->orWhere('remark', 'like', 'daily_referral')
                ->orWhere('remark', 'like', '%level%commission%')
                ->orWhere('remark', 'like', '%referral_commission%');
        })
        ->whereDate('created_at', today())
        ->sum('amount');

        $manualPay = DB::table('transactions')
        ->where('user_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('remark', 'like', '%manual_payment%')
                ->orWhere('remark', 'like', 'daily_referral');
        })
        ->sum('amount');
 
        $totalEarnedUsdt = $contractReceived
    ?>

    <h4 class="amount childaount">${{ number_format($transactionsdataa, 2) }}</h4>
    <style>
        .totalammbr .childaount {
            display: none;
        }
        .totalammbr .childaount:nth-child(2) {
            display: block;
        }
    </style>
</div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Direct Referral')</h5>
                            {{-- <h4 class="amount">{{ $user->fullname }}</h4> --}}

                            <?php  $trantiref = DB::table('transactions')->where('user_id', auth()->user()->id)->where('remark', 'Like', '%referral_commission%')->sum('amount'); ?>
                            <h4 class="amount">${{ showAmount($trantiref) }}</h4>
                      
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('My Plan')</h5>
                            {{-- <h4 class="amount">{{ __($user->plan->name ?? 'N/A') }}</h4> --}}

                            <?php  $trantipl = DB::table('transactions')->where('user_id', auth()->user()->id)->where('remark', 'Like', '%plan_purchase%')->sum('amount'); ?>
                            <h4 class="amount">${{ showAmount($trantipl) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Contract Return')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($contractReturn) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Contract Received')</h5>
                            {{-- <h4 class="amount">{{ $user->fullname }}</h4> --}}
                            <h4 class="amount">${{ showAmount($contractReceived) }}</h4>
                      
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Contract Balance')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($contractBalance) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Daily Portfolio')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($dailyIncome) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title">@lang('Total Earned USDT')</h5>
                            <h4 class="amount">{{ $general->cur_sym }}{{ showAmount($totalEarnedUsdt) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <div class="card custom--card primary-bg">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Latest Trasactions')</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="deposite-table">
                                <thead class="custom--table">
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('TRX')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Charge')</th>
                                        <th>@lang('Post Balance')</th>
                                        <th>@lang('Detail')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td>
                                                {{ showDateTime($trx->created_at) }}
                                                <br>
                                                {{ diffforhumans($trx->created_at) }}
                                            </td>
                                            <td>
                                                {{ $trx->trx }}
                                            </td>
                                            <td class="budget">
                                                <strong
                                                    @if ($trx->trx_type == '+') class="text--success" @else class="text--danger" @endif>
                                                    {{ $trx->trx_type == '+' ? '+' : '-' }} {{ getAmount($trx->amount) }}
                                                    {{ __($general->cur_text) }}
                                                </strong>
                                            </td>
                                            <td class="budget">
                                                {{ __(__($general->cur_sym)) }}
                                                {{ getAmount($trx->charge) }}
                                            </td>
                                            <td>{{ getAmount($trx->post_balance) }}
                                                {{ __($general->cur_text) }}
                                            </td>
                                            <td>{{ __($trx->details) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection



@push('script')
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color }};
        }
    </style>
@endpush
