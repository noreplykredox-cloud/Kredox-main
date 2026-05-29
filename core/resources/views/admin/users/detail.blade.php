@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-money-bill-wave-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($user->balance) }}</h3>
                            <p class="text-white">@lang('Balance')</p>
                        </div>
                        <a href="{{ route('admin.report.transaction') }}?search={{ $user->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalDeposit) }}</h3>
                            <p class="text-white">@lang('Deposits')</p>
                        </div>
                        <a href="{{ route('admin.deposit.list') }}?search={{ $user->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalWithdrawals) }}</h3>
                            <p class="text-white">@lang('Withdrawals')</p>
                        </div>
                        <a href="{{ route('admin.withdraw.log') }}?search={{ $user->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-exchange-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $totalTransaction }}</h3>
                            <p class="text-white">@lang('Transactions')</p>
                        </div>
                        <a href="{{ route('admin.report.transaction') }}?search={{ $user->username }}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


            </div>

            <div class="row gy-4 mt-2">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-pager"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalReferralCommission) }}</h3>
                            <p class="text-white">@lang('Total Referral Commissions')</p>
                        </div>
                        <a href="{{route('admin.users.referral.commission',$user->id)}}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-terminal"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym }}{{ showAmount($totalLevelCommission) }}</h3>
                            <p class="text-white">@lang('Total Level Commissions')</p>
                        </div>
                        <a href="{{route('admin.users.level.commission',$user->id)}}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-lock"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ __($totalPinGenerate) }}</h3>
                            <p class="text-white">@lang('Total Created Pin')</p>
                        </div>
                        <a href="{{route('admin.users.generate.pin',$user->id)}}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-lock-open"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ __($totalUsedPin) }}</h3>
                            <p class="text-white">@lang('Total Used Pin')</p>
                        </div>
                        <a href="{{route('admin.users.used.pin',$user->id)}}" class="widget-two__btn">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#manualPaymentModal" class="btn btn--info btn--shadow w-100 btn-lg">
                        <i class="las la-hand-holding-usd"></i> @lang('Manual Payment')
                    </button>
                </div>
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="{{route('admin.report.login.history')}}?search={{ $user->username }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.users.notification.log',$user->id) }}" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as User')
                    </a>
                </div>

                @if($user->kyc_data)
                <div class="flex-fill">
                    <a href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                        <i class="las la-user-check"></i>@lang('KYC Data')
                    </a>
                </div>
                @endif

                <div class="flex-fill">
                    @if($user->status == Status::USER_ACTIVE)
                    <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-ban"></i>@lang('Ban User')
                    </button>
                    @else
                    <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-undo"></i>@lang('Unban User')
                    </button>
                    @endif
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{$user->fullname}}</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.update',[$user->id])}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{$user->firstname}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{$user->lastname}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{$user->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{@$user->address->address}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{@$user->address->city}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{@$user->address->state}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{@$user->address->zip}}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        <option value="">@lang('Select One')</option>
                                        @foreach($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label>@lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($user->ev) checked @endif>

                            </div>

                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label>@lang('Mobile Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($user->sv) checked @endif>

                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label>@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="ts" @if($user->ts) checked @endif>
                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label>@lang('KYC') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="kv" @if($user->kv == 1) checked @endif>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Premium Downline Genealogy Tree & Income Schedules Card --}}
            <div class="card mt-30 border-0 box--shadow2" style="background-color: #0f172a; border-radius: 12px; overflow: hidden;">
                <div class="card-header bg--dark d-flex justify-content-between align-items-center py-3 px-4" style="border-bottom: 2px solid #1e293b;">
                    <h5 class="card-title text-white mb-0 d-flex align-items-center gap-2">
                        <i class="las la-sitemap text--primary" style="font-size: 1.5rem;"></i>
                        @lang('Downline Genealogy Tree & Income Schedules')
                    </h5>
                    <span class="badge bg--primary text-white">@lang('Active Matrix Depth'): {{ gs()->matrix_height }} Levels</span>
                </div>
                <div class="card-body p-4" style="background-color: #0f172a;">
                    <div class="text-white-50 mb-3" style="font-size: 0.9rem; line-height: 1.5;">
                        <i class="las la-info-circle text--info"></i> @lang('This interactive map displays all registered downline members residing within this user\'s matrix genealogy using high-performance SVG organization chart visualization. Click on the expand buttons to collapse/expand downline nodes, scroll to zoom, drag to pan, and click on any card to view detailed scheduled payouts.')
                    </div>
                    
                    <div class="tree-container" style="padding:0; position: relative; background-color: #020617; border-radius: 12px;">
                        <div id="chart-container"
                            style="background: #020617; width: 100%; border-radius: 12px; height: 600px; border: 1px solid rgba(239, 68, 68, 0.2); box-shadow: 0 4px 20px rgba(0,0,0,0.5); overflow:hidden; touch-action: none;">
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>

            <!-- Tree Member Payout Schedules Modal -->
            <div id="treeSchedulesModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content" style="background-color: #0f172a; border: 1px solid #1e293b; border-radius: 12px; overflow: hidden;">
                        <div class="modal-header" style="border-bottom: 1px solid #1e293b; background-color: #1e293b;">
                            <h5 class="modal-title text-white d-flex align-items-center gap-2">
                                <i class="las la-coins text--warning" style="font-size: 1.5rem;"></i>
                                <span id="modalTitleUser">@lang('User Payout Schedules')</span>
                            </h5>
                            <button type="button" class="close text-white border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5rem;">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body p-4 text-white">
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="p-3 rounded" style="background-color: #1e293b; border: 1px solid #334155;">
                                        <h6 class="text-white mb-2"><i class="las la-id-card text--primary"></i> @lang('Member Details')</h6>
                                        <div style="font-size: 0.9rem; line-height: 1.6;">
                                            <div><strong>@lang('Full Name'):</strong> <span id="modalFullName" class="text-white-50"></span></div>
                                            <div><strong>@lang('Email'):</strong> <span id="modalEmail" class="text-white-50"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded" style="background-color: #1e293b; border: 1px solid #334155;">
                                        <h6 class="text-white mb-2"><i class="las la-wallet text--success"></i> @lang('Investment Details')</h6>
                                        <div style="font-size: 0.9rem; line-height: 1.6;">
                                            <div><strong>@lang('Active Plan'):</strong> <span id="modalPlanName" class="text-success fw-bold"></span></div>
                                            <div><strong>@lang('Total Invested'):</strong> <span id="modalInvestAmount" class="text-white-50"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="text-white mb-2"><i class="las la-coins text--warning"></i> @lang('All Scheduled & Active Payouts')</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center text-white" style="background-color: #020617; border-color: #1e293b;">
                                    <thead>
                                        <tr style="background-color: #1e293b;">
                                            <th>@lang('Description')</th>
                                            <th>@lang('Rate / %')</th>
                                            <th>@lang('Payout Payment')</th>
                                            <th>@lang('Frequency')</th>
                                            <th>@lang('Exclude Weekends')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Next Execution')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalSchedulesTableBody">
                                        <!-- Dynamically populated -->
                                    </tbody>
                                </table>
                            </div>
                            <form id="payScheduleForm" action="{{ route('admin.users.pay.schedule', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="schedule_type" id="payScheduleType">
                                <input type="hidden" name="schedule_id" id="payScheduleId">
                                <input type="hidden" name="downline_id" id="payDownlineId">
                                <input type="hidden" name="level" id="payLevel">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="manualPaymentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">@lang('Manual Payments for') {{ $user->username }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">

                {{-- Tabs --}}
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#paymentList" role="tab">@lang('Payment List')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#newPayment" role="tab">@lang('Add New')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    {{-- Tab 1: Payment List --}}
                    <div class="tab-pane fade show active" id="paymentList" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Description')</th>
                                        <th>@lang('Start Time')</th>
                                        <th>@lang('Frequency')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->manualPayments as $payment)
                                        <tr>
                                            <td>{{ showAmount($payment->amount) }}</td>
                                            <td>{{ $payment->description }}</td>
                                            <td>{{ showDateTime($payment->start_time) }}</td>
                                            <td>{{ ucfirst($payment->frequency) }}</td>
                                            <td>
                                                @if($payment->status === 'active')
                                                    <span class="badge bg-success">@lang('Active')</span>
                                                @else
                                                    <span class="badge bg-danger">@lang('Inactive')</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn--primary editPaymentBtn"
                                                    data-id="{{ $payment->id }}"
                                                    data-amount="{{ $payment->amount }}"
                                                    data-description="{{ $payment->description }}"
                                                    data-start_time="{{ $payment->start_time }}"
                                                    data-frequency="{{ $payment->frequency }}"
                                                    data-monthly_day="{{ $payment->monthly_day }}">
                                                    <i class="las la-edit"></i>
                                                </button>

                                                <form action="{{ route('admin.users.manual.payment.toggle', $payment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn--info">
                                                        <i class="las la-sync-alt"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.users.manual.payment.delete', $payment->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn--danger" onclick="return confirm('Are you sure?')">
                                                        <i class="las la-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($user->manualPayments->isEmpty())
                                        <tr><td colspan="6">@lang('No Manual Payments found.')</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tab 2: Add New --}}
                    <div class="tab-pane fade" id="newPayment" role="tabpanel">
                        <form action="{{ route('admin.users.manual.payment', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>@lang('Amount')</label>
                                    <input type="number" name="amount" class="form-control" required step="0.01" min="0">
                                </div>
                                <div class="form-group col-md-8">
                                    <label>@lang('Description')</label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>@lang('Start Crediting Time')</label>
                                    <input type="datetime-local" name="start_time" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>@lang('Frequency')</label>
                                    <select name="frequency" id="frequency" class="form-control" required>
                                        <option value="daily">@lang('Daily')</option>
                                        <option value="monthly">@lang('Monthly')</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 d-none" id="dayOfMonthWrapper">
                                    <label>@lang('Day of Month (1–30)')</label>
                                    <select name="monthly_day" class="form-control">
                                        @for ($i = 1; $i <= 30; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn--primary">@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="editManualPaymentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="POST" action="" id="editManualPaymentForm" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Manual Payment')</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-group col-md-6">
                    <label>@lang('Amount')</label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('Start Time')</label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>@lang('Description')</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>@lang('Frequency')</label>
                    <select name="frequency" class="form-control frequencySelect">
                        <option value="daily">@lang('Daily')</option>
                        <option value="monthly">@lang('Monthly')</option>
                    </select>
                </div>
                <div class="form-group col-md-6 d-none" id="editDayOfMonthWrapper">
                    <label>@lang('Day of Month')</label>
                    <select name="monthly_day" class="form-control">
                        @for($i=1;$i<=30;$i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn--primary w-100" type="submit">@lang('Update')</button>
            </div>
        </form>
    </div>
</div>
    
    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.users.add.sub.balance',$user->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($user->status == Status::USER_ACTIVE)
                        <span>@lang('Ban User')</span>
                        @else
                        <span>@lang('Unban User')</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{route('admin.users.status',$user->id)}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if($user->status == Status::USER_ACTIVE)
                        <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                        <div class="form-group">
                            <label>@lang('Reason')</label>
                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                        @else
                        <p><span>@lang('Ban reason was'):</span></p>
                        <p>{{ $user->ban_reason }}</p>
                        <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if($user->status == Status::USER_ACTIVE)
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
<script>
    (function($){
    "use strict"
        $('.bal-btn').click(function(){
            var act = $(this).data('act');
            $('#addSubModal').find('input[name=act]').val(act);
            if (act == 'add') {
                $('.type').text('Add');
            }else{
                $('.type').text('Subtract');
            }
        });
        let mobileElement = $('.mobile-code');
        $('select[name=country]').change(function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

        let countryCode = '{{@$user->country_code}}';
        if(countryCode){
            $('select[name=country]').val(countryCode);
        }
        
        let dialCode        = $('select[name=country] :selected').data('mobile_code');
        let mobileNumber    = `{{ $user->mobile }}`;
        
        if(dialCode){
            mobileNumber    = mobileNumber.replace(dialCode,'');
            mobileElement.text(`+${dialCode}`);
        }
        $('input[name=mobile]').val(mobileNumber);

    })(jQuery);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const frequencySelect = document.getElementById("frequency");
        const dayWrapper = document.getElementById("dayOfMonthWrapper");

        frequencySelect.addEventListener("change", function () {
            if (this.value === "monthly") {
                dayWrapper.classList.remove("d-none");
            } else {
                dayWrapper.classList.add("d-none");
            }
        });

        // trigger on load
        frequencySelect.dispatchEvent(new Event('change'));
    });
</script>
<script>
    (function ($) {
        "use strict";

        $('.editPaymentBtn').click(function () {
            const modal = $('#editManualPaymentModal');
            const form = modal.find('form');
            const id = $(this).data('id');

            // Use Laravel route helper with placeholder
            const route = `{{ route('admin.users.manual.payment.update', ['id' => '__id__']) }}`.replace('__id__', id);

            form.attr('action', route);
            form.find('[name=amount]').val($(this).data('amount'));
            form.find('[name=description]').val($(this).data('description'));
            form.find('[name=start_time]').val($(this).data('start_time').slice(0, 16)); // format for datetime-local
            form.find('[name=frequency]').val($(this).data('frequency')).trigger('change');
            form.find('[name=monthly_day]').val($(this).data('monthly_day') || '');

            modal.modal('show');
        });

        // Toggle monthly day visibility
        $(document).on('change', '.frequencySelect', function () {
            const wrapper = $('#editDayOfMonthWrapper');
            if ($(this).val() === 'monthly') {
                wrapper.removeClass('d-none');
            } else {
                wrapper.addClass('d-none');
            }
        });
    })(jQuery);
</script>

<!-- D3 and OrgChart libraries -->
<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-org-chart@3.1.0"></script>
<script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>

<script>
    let chart;
    let orgChartData = {!! $orgChartJson !!};

    function renderOrgChart() {
        if (!chart) {
            chart = new d3.OrgChart()
                .container('#chart-container')
                .data(orgChartData)
                .nodeWidth((d) => 240)
                .initialZoom(0.75)
                .nodeHeight((d) => 200)
                .childrenMargin((d) => 60)
                .compact(false)
                .layout("top")
                .onNodeClick(d => {
                    showSchedulesModalFromNode(d.data);
                })
                .linkUpdate(function (d, i, arr) {
                    d3.select(this)
                        .attr("stroke", "rgba(239, 68, 68, 0.4)")
                        .attr("stroke-width", 2);
                })
                .buttonContent(({ node, state }) => {
                    return `<div style="color:#ffffff; border-radius:50%; width:28px; height:28px; display:flex; justify-content:center; align-items:center; background-color:#0f172a; border:1.5px solid #ef4444; box-shadow:0 0 10px rgba(0,0,0,0.5); font-size:14px; transition:all 0.3s; cursor:pointer;" onMouseOver="this.style.background='#ef4444'" onMouseOut="this.style.background='#0f172a'">
                                <i class="las ${node.children ? 'la-minus' : 'la-plus'}" style="color: #ffffff !important; line-height: 28px;"></i>
                            </div>`;
                })
                .nodeContent(function (d, i, arr, state) {
                    const isRoot = d.data.parentId === '';

                    // Parse schedules to check for active items
                    const schedules = typeof d.data.schedules === 'string' ? JSON.parse(d.data.schedules) : d.data.schedules;
                    const hasActiveSchedule = Array.isArray(schedules) && schedules.some(s => s.frequency !== 'Completed');

                    const borderColor = hasActiveSchedule ? '#fbbf24' : '#ef4444';
                    const avatarShadow = hasActiveSchedule ? '0 0 12px rgba(251, 191, 36, 0.6)' : '0 0 10px rgba(239, 68, 68, 0.4)';
                    const boxShadow = hasActiveSchedule 
                        ? '0 0 25px rgba(251, 191, 36, 0.65)' 
                        : (isRoot ? '0 0 20px rgba(239, 68, 68, 0.4)' : '0 4px 25px rgba(0,0,0,0.5)');
                    const borderStyle = isRoot 
                        ? `2px solid ${borderColor}` 
                        : `1px solid ${hasActiveSchedule ? '#fbbf24' : 'rgba(239, 68, 68, 0.3)'}`;

                    let imageHtml = '';
                    if (d.data.image && d.data.image.trim() !== '') {
                        imageHtml = `<img src="${d.data.image}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                    } else {
                        imageHtml = `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #1f2937; border-radius: 50%;">
                                        <i class="las la-user-circle" style="font-size: 42px; color: ${borderColor};"></i>
                                     </div>`;
                    }

                    const payBadgeHtml = hasActiveSchedule 
                        ? `<div style="position: absolute; top: -10px; right: -10px; background: linear-gradient(135deg, #fbbf24, #d97706); color: #000; font-size: 8px; font-weight: 800; border-radius: 20px; padding: 3px 8px; box-shadow: 0 0 12px rgba(251, 191, 36, 0.8); z-index: 10; display: flex; align-items: center; gap: 3px; border: 1.5px solid #0f172a; text-transform: uppercase;">
                               <i class="las la-clock" style="font-size: 10px; font-weight: bold; margin-right: 1px;"></i>PAY ACTIVE
                           </div>`
                        : '';

                    return `
                        <div style="font-family: inherit; box-sizing: border-box; width:${d.width}px; height:${d.height}px; padding-top:20px; background: linear-gradient(145deg, #111827, #0f172a); border: ${borderStyle}; border-radius: 12px; box-shadow: ${boxShadow}; display: flex; flex-direction: column; align-items: center; position: relative; cursor: pointer;">
                            
                            <!-- Bouncing Golden Payout Active Badge -->
                            ${payBadgeHtml}

                            <!-- Hover click overlay -->
                            <div style="position: absolute; top:0; left:0; width:100%; height:100%; z-index: 5;" title="Click to view assigned income schedules"></div>

                            <div style="flex-shrink: 0; width: 60px; height: 60px; border-radius: 50%; border: 2px solid ${borderColor}; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; background: #1f2937; z-index: 2; box-shadow: ${avatarShadow}; padding: 2px; overflow: hidden;">
                                ${imageHtml}
                            </div>

                            <div style="flex-shrink: 0; color: #fff; font-weight: 600; font-size: 14px; margin-bottom: 2px; text-align: center; width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-transform: capitalize;">${d.data.name}</div>
                            <div style="flex-shrink: 0; color: rgba(255,255,255,0.5); font-size: 11px; margin-bottom: 6px; text-align: center; font-weight: 500;">@${d.data.username}</div>

                            ${!isRoot ? `<div style="flex-shrink: 0; margin-bottom: auto; text-align: center;"><span style="background: ${hasActiveSchedule ? 'rgba(251,191,36,0.1)' : 'rgba(239, 68, 68, 0.1)'}; color: ${borderColor}; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; border: 1px solid ${hasActiveSchedule ? 'rgba(251,191,36,0.2)' : 'rgba(239, 68, 68, 0.2)'};">Level ${d.data.level}</span></div>` : `<div style="flex-shrink: 0; margin-bottom: auto; text-align: center;"><span style="background: ${hasActiveSchedule ? 'rgba(251,191,36,0.15)' : 'rgba(239, 68, 68, 0.15)'}; color: ${borderColor}; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; border: 1px solid ${hasActiveSchedule ? 'rgba(251,191,36,0.3)' : 'rgba(239, 68, 68, 0.3)'};">Root Upline</span></div>`}

                            <div style="box-sizing: border-box; display: flex; justify-content: space-between; width: 100%; border-top: 1px solid #1f2937; background: #1f2937; padding: 8px 12px 10px 12px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 48%; border-right: 1px solid rgba(255,255,255,0.05);">
                                    <span style="color: rgba(255,255,255,0.4); font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Team</span>
                                    <span style="color: #fff; font-weight: 600; font-size: 12px;">
                                        <i class="las la-users" style="color: ${borderColor}; margin-right: 3px; font-size: 11px;"></i>${d.data.teamSize}
                                    </span>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 48%;">
                                    <span style="color: rgba(255,255,255,0.4); font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Investment</span>
                                    <span style="color: #f1f1f1; font-weight: 600; font-size: 12px;">
                                        $${Number(d.data.volume).toFixed(2)}
                                    </span>
                                </div>
                            </div>

                        </div>
                        `;
                })
                .render();

            // Collapse nodes beyond depth 2
            chart.getNodes().forEach(node => {
                if (node.depth >= 2) {
                    chart.setExpanded(node.id, false);
                }
            });

            chart.render().fit();
        }
    }

    function showSchedulesModalFromNode(data) {
        const schedules = typeof data.schedules === 'string' ? JSON.parse(data.schedules) : data.schedules;
        
        document.getElementById('modalTitleUser').innerText = `Income Schedules for @${data.username}`;
        document.getElementById('modalFullName').innerText = data.name;
        document.getElementById('modalEmail').innerText = data.email || 'N/A';
        document.getElementById('modalPlanName').innerText = data.plan_name || 'No Active Plan';
        document.getElementById('modalInvestAmount').innerText = `$${Number(data.volume).toFixed(2)}`;
        
        const tbody = document.getElementById('modalSchedulesTableBody');
        tbody.innerHTML = '';
        
        if (!schedules || schedules.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-muted italic py-3 text-center">No active ROI or direct payment schedules found for this member.</td></tr>`;
        } else {
            schedules.forEach(sched => {
                const tr = document.createElement('tr');
                const targetText = sched.target_percentage 
                    ? `<br><small class="text-white-50" style="font-size: 10px;">${sched.target_percentage}</small>` 
                    : '';
                const targetPayoutText = sched.target_payout 
                    ? `<br><small class="text-white-50" style="font-size: 10px; font-weight: 500;">${sched.target_payout}</small>` 
                    : '';

                let badgeLabel = 'Plan ROI';
                if (sched.description.includes('Direct') || sched.description.includes('Specific')) {
                    badgeLabel = 'Direct';
                } else if (sched.description.includes('Referral') || sched.description.includes('Level')) {
                    badgeLabel = 'Level Income';
                }

                let actionBtnHtml = '';
                if (sched.status !== 'Completed' && sched.status !== 'Paid Today' && sched.status !== 'Expired / Completed') {
                    let schedType = 'plan';
                    if (sched.description.includes('Direct') || sched.description.includes('User Specific')) {
                        schedType = 'user';
                    } else if (sched.description.includes('Level') || sched.description.includes('Referral')) {
                        schedType = 'level';
                    }
                    actionBtnHtml = `
                        <button type="button" class="btn btn-sm btn--success btn-pay-now py-1 px-2 ms-2" 
                            data-schedule-id="${sched.schedule_id || ''}" 
                            data-type="${schedType}" 
                            data-downline-id="${sched.downline_id || ''}"
                            data-level="${sched.level_num || ''}"
                            style="font-size: 0.7rem; line-height: 1;">
                            <i class="las la-wallet"></i> Pay Now
                        </button>
                    `;
                }

                tr.innerHTML = `
                    <td style="text-align: left; vertical-align: middle;">
                        <span class="badge ${sched.badge_class} me-1" style="font-size: 0.7rem;">
                            ${badgeLabel}
                        </span>
                        ${sched.description}
                    </td>
                    <td style="vertical-align: middle; line-height: 1.3;">
                        <span class="badge bg-dark border border-secondary text-white">${sched.amount}</span>
                        ${targetText}
                    </td>
                    <td style="font-weight: 800; color: #fbbf24; vertical-align: middle; font-size: 1.05rem; line-height: 1.3;">
                        ${sched.payout_amount}
                        ${targetPayoutText}
                    </td>
                    <td style="vertical-align: middle;"><span class="badge bg-secondary">${sched.frequency}</span></td>
                    <td style="vertical-align: middle;">
                        ${sched.exclude_weekends === 'Yes' 
                            ? '<span class="text-danger fw-bold">Yes</span>' 
                            : '<span class="text-success fw-bold">No</span>'}
                    </td>
                    <td style="vertical-align: middle;">
                        <span class="${sched.status_class || 'badge bg-primary'}" style="font-size: 0.75rem;">
                            ${sched.status || 'Active'}
                        </span>
                    </td>
                    <td style="font-weight: bold; color: #34d399; vertical-align: middle;">
                        <div class="d-flex align-items-center justify-content-center gap-1">
                            <span><i class="las la-clock"></i> ${sched.next_run}</span>
                            ${actionBtnHtml}
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
        
        $('#treeSchedulesModal').modal('show');
    }

    $(document).ready(function() {
        setTimeout(() => {
            renderOrgChart();
        }, 300);

        $(document).on('click', '.btn-pay-now', function() {
            if (confirm('Are you sure you want to process this payout immediately?')) {
                $('#payScheduleType').val($(this).data('type'));
                $('#payScheduleId').val($(this).data('schedule-id'));
                $('#payDownlineId').val($(this).data('downline-id'));
                $('#payLevel').val($(this).data('level'));
                $('#payScheduleForm').submit();
            }
        });
    });
</script>
@endpush
