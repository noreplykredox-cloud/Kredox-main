
@php
    $content = getContent('deposit_withdraw.content', true);
    $deposits = App\Models\Deposit::where('status', Status::PAYMENT_SUCCESS)->with('user', 'gateway')->orderBy('id', 'DESC')->limit(10)->get();
    $withdrwals = App\Models\Withdrawal::where('status', Status::PAYMENT_SUCCESS)->with('user', 'method')->orderBy('id', 'DESC')->limit(10)->get();
@endphp
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
     
<section class="deposit-withdraw padding-bottom padding-top">
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
  filter: blur(5px);
}
</style>
        <div class="row mb--50">
            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->deposit_heading)}}</h3>
                    <p>{{__(@$content->data_values->deposit_sub_heading)}}</p>
                </div>
                <table class="deposit-table">
                    <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Gateway')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>{{__(@$deposit->user->fullname)}}</td>
                                <td>{{showAmount($deposit->amount)}} {{ __($general->cur_text) }}</td>
                                <td>{{showdateTime($deposit->created_at, 'd M Y')}}</td>
                                <td>
                                    @if($deposit->method_code != 0)
                                        {{__(@$deposit->gateway->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title">{{__(@$content->data_values->withdraw_heading)}}</h3>
                    <p>{{__(@$content->data_values->withdraw_sub_heading)}}</p>
                </div>

                <table class="deposit-table">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Method')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrwals as $withdrwal)
                            <tr>
                                <td>{{__($withdrwal->user->fullname)}}</td>
                                <td>{{showAmount($withdrwal->amount)}} {{__($general->cur_text)}}</td>
                                <td>{{showdateTime($withdrwal->created_at, 'd M Y')}}</td>
                                <td>
                                    @if($withdrwal->method_id != 0)
                                        {{__($withdrwal->method->name)}}
                                    @else
                                        @lang('E-pin')
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
