
@php
    $content = getContent('deposit_withdraw.content', true);
    $deposits = App\Models\Deposit::where('status', Status::PAYMENT_SUCCESS)->with('user', 'gateway')->orderBy('id', 'DESC')->limit(10)->get();
    $withdrwals = App\Models\Withdrawal::where('status', Status::PAYMENT_SUCCESS)->with('user', 'method')->orderBy('id', 'DESC')->limit(10)->get();
@endphp
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="{{ route('user.home') }}" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="{{ route('plan') }}" class="nav__link ">
    <i class="material-icons nav__icon">travel_explore</i>
    <span class="nav__text">Plan</span>
  </a>
  <a href="{{ route('user.deposit.index') }}" class="nav__link nav__link--active">
    <i class="material-icons nav__icon">add_card</i>
    <span class="nav__text">Deposit</span>
  </a>
  <a href="{{ route('user.withdraw') }}" class="nav__link">
    <i class="material-icons nav__icon">request_quote</i>
    <span class="nav__text">Withdraw</span>
  </a>
  <a href="{{ route('user.referral.log') }}" class="nav__link">
    <i class="material-icons nav__icon">diversity_3</i>
    <span class="nav__text">My Team</span>
  </a>
  <a href="{{ route('user.logout') }}" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
  </a>
</nav>


<style>
    :root {
  --primary-color: #0d8aad;
  --secondary-color: #00c9a7;
  --accent-color: #00ffcc;
  --dark-color: #0a192f;
  --darker-color: #020c1b;
  --light-color: #ccd6f6;
  --lighter-color: #e6f1ff;
  --success-color: #64ffda;
  --warning-color: #ff9e64;
  --danger-color: #ff6b6b;
  --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, #00ffcc 100%);
  --shadow-sm: 0 2px 10px rgba(0,0,0,0.3);
  --shadow-md: 0 4px 20px rgba(0,0,0,0.4);
  --shadow-lg: 0 8px 30px rgba(0,201,167,0.3);
  --card-bg: #112240;
  --nav-bg: #020c1b;
}
body {
    margin: 0 0 65px 0; /* Leave space for bottom nav */
}

/* ========== Mobile Navigation ========== */
.nav {
  display: none;
}
@media screen and (max-width: 767px) {
    .nav {
  position: fixed;
  bottom: 0;
  width: 100%;
  height: 65px;
  background: var(--nav-bg);
  display: flex;
  overflow-x: auto;
  z-index: 1000;
  box-shadow: 0 -4px 15px rgba(0,0,0,0.3);
  border-top: 1px solid rgba(100, 255, 218, 0.1);
}

.nav__link {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex-grow: 1;
  min-width: 55px;
  overflow: hidden;
  white-space: nowrap;
  font-size: 11px;
  font-weight: 600;
  color: rgba(204, 214, 246, 0.7);
  text-decoration: none;
  transition: all 0.3s ease;
  -webkit-tap-highlight-color: transparent;
  padding: 6px 3px;
}

.nav__link:hover {
  color: var(--accent-color);
  background: rgba(100, 255, 218, 0.05);
}

.nav__link--active {
  color: var(--accent-color);
  background: rgba(100, 255, 218, 0.1);
}

.nav__icon {
  font-size: 22px;
  margin-bottom: 3px;
  transition: all 0.3s ease;
}

.nav__link--active .nav__icon {
  transform: translateY(-3px);
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
