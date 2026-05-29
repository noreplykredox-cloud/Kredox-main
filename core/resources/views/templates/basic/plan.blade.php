@extends($activeTemplate . 'layouts.frontend')
@section('content')
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="https://yukotrader.com/subscribe/plan" class="nav__link nav__link">
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
     
    <section class="plan-section padding-top padding-bottom oh">
        <div class="container">
            <div class="row justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-md-6 col-lg-4">
                        <div class="plan-item">
                            <div class="plan-header">
                                <span class="plan-badge">
                                    {{ __($plan->name) }}
                                </span>
                                <div class="icon">
                                    <i class="fas fa-piggy-bank"></i>
                                </div>
                                <h3 class="title">{{ $general->cur_sym }}{{ getAmount($plan->price) }}</h3>
                            </div>
                            <ul class="plan-info">
                                <li>
                                    <h6 class="direct">@lang('Direct Referral Bonus') :
                                        {{ $general->cur_sym }}{{ getAmount($plan->referral_bonus) }}</h6>
                                </li>
                                @php
                                    $sumCommission = 0;
                                @endphp

                                @foreach ($plan->totalLevel($plan->id) as $value)
                                    @php
                                        $matrixCal = pow($general->matrix_width, $loop->iteration);
                                        $commission = getAmount($value->amount * $matrixCal);
                                        $sumCommission += $commission;
                                    @endphp

                                    <!--
                                    <li>
                                        @lang('L'){{ $loop->iteration }} :
                                        {{ __($general->cur_sym) }}{{ getAmount($value->amount) }} X {{ $matrixCal }} <i
                                            class="fa fa-users"></i> = <strong
                                            class="profit">{{ __($general->cur_sym) }}{{ $commission }}</strong>
                                    </li>
                                    -->
                                @endforeach
                            </ul>
                            <!--
                            <div class="total-return">
                                <h6 class="title">@lang('Total Level Commission') : {{ getAmount($sumCommission) }}
                                    {{ __($general->cur_text) }}</h6>
                                <span class="return-remainders">
                                    @lang('Returns') <span
                                        class="remainder">{{ getAmount(($sumCommission / $plan->price) * 100) }}%</span>
                                    @lang('of Invest')
                                </span>
                            </div>
                            -->

                            <div class="invest-now py-3">
                                <button type="button" class="btn btn--base btn-lg confirmationBtn"
                                    data-question="@lang('Are you sure you want to subscribe this plan')"
                                    data-action="{{ route('user.plan.order',$plan->id)}}">@lang('Invest Now')
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-confirmation-modal is_custom="yes" />
@endsection
