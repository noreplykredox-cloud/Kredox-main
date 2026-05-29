@extends($activeTemplate . 'layouts.master')
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
     
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">

                @if (!request()->routeIs('user.recharge.log'))
                    <div class="col-md-12">
                        <div class="show-filter mb-3 text-end">
                            <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                                @lang('Filter')</button>
                        </div>
                        <div class="card responsive-filter-card mb-4 primary-bg">
                            <div class="card-body">
                                <form action="">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="flex-grow-1 contact-form-group">
                                            <label>@lang('Transaction Number')</label>
                                            <input type="text" name="search" value="{{ request()->search }}"
                                                class="form-control form--control">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label>@lang('Type')</label>
                                                <div class="select-item">
                                                    <select name="trx_type" class="select-bar">
                                                        <option value="">@lang('All')</option>
                                                        <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')
                                                        </option>
                                                        <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label>@lang('Remark')</label>
                                                <select class="select-bar" name="remark">
                                                    <option value="">@lang('Any')</option>
                                                    @foreach ($remarks as $remark)
                                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 align-self-end">
                                            <div class="contact-form-group">
                                                <button class="btn btn--base w-100"><i class="las la-filter"></i>
                                                    @lang('Filter')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="primary-bg item-rounded">
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

                                <td>
                                    <strong
                                        @if ($trx->trx_type == '+') class="text--success" @else class="text--danger" @endif>
                                        {{ $trx->trx_type == '+' ? '+' : '-' }} {{ getAmount($trx->amount) }}
                                        {{ __($general->cur_text) }}</strong>
                                </td>

                                <td>
                                    {{ getAmount($trx->charge) }} {{ __($general->cur_text) }}
                                </td>
                                <td>
                                    {{ getAmount($trx->post_balance) }} {{ __($general->cur_text) }}</td>
                                <td class="text-end">
                                    {{ __($trx->details) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">{{ __($emptyMessage) }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($transactions->hasPages() )
                    <div class="py-3">
                        {{paginateLinks($transactions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
