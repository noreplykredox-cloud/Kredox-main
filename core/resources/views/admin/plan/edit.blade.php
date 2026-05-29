@extends('admin.layouts.app')

@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12">
        {{-- Main Plan Update Form --}}
        <form action="{{ route('admin.plan.update', $plan->id) }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    {{-- Nav Tabs --}}
                    <ul class="nav nav-tabs mb-4" id="planTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                                type="button" role="tab">@lang('Plan Settings')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="commission-tab" data-bs-toggle="tab" data-bs-target="#commission"
                                type="button" role="tab">@lang('Commission Levels')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily"
                                type="button" role="tab">@lang('Daily Referral Levels')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual"
                                type="button" role="tab">@lang('Manual Payments')</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="planTabContent">
                        {{-- Tab 1: Basic Info --}}
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" name="name" value="{{ $plan->name }}" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Price')</label>
                                    <input type="number" class="form-control" name="price" value="{{ getAmount($plan->price) }}" id="planAmount" step="any" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Referral Bonus')</label>
                                    <input type="number" class="form-control" name="referral_bonus" id="referralBonus" value="{{ getAmount($plan->referral_bonus) }}" step="any" required>
                                </div>
                            </div>
                        </div>

                        {{-- Tab 2: Commission Levels --}}
                        <div class="tab-pane fade" id="commission" role="tabpanel">
                            <div class="form-group col-lg-4">
                                <label>@lang('Active Level Commission')</label>
                                <select class="form-control" name="is_level_commission">
                                    <option value="1" {{ $plan->is_level_commission ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$plan->is_level_commission ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="row">
                                @for ($i = 0; $i < $general->matrix_height; $i++)
                                    <div class="form-group col-lg-3">
                                        <label>@lang('Level '){{ $i + 1 }}</label>
                                        <input type="number" class="form-control commissionAmount" name="level[{{ $i + 1 }}]" value="{{ getAmount(@$plan->level[$i]->amount) }}" step="any" required>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Tab 3: Daily Referral --}}
                        <div class="tab-pane fade" id="daily" role="tabpanel">
                            <div class="form-group col-lg-4">
                                <label>@lang('Daily Referral Payout Active')</label>
                                <select class="form-control" name="daily_referral_enabled">
                                    <option value="1" {{ $plan->daily_referral_enabled ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$plan->daily_referral_enabled ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="row">
                                @for ($i = 1; $i <= $general->matrix_height; $i++)
                                    <div class="form-group col-lg-3">
                                        <label>@lang('Level '){{ $i }}</label>
                                        <input type="number" class="form-control payoutPercent" name="level_payout[{{ $i }}]" value="{{ @$plan->dailyReferralLevels->where('level', $i)->first()?->percentage ?? 0 }}" step="any">
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Tab 4: Manual Payments --}}
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <div class="row">
                                @foreach($manualPayments as $index => $payment)
                                    <div class="col-md-6 mb-3 border p-3">
                                        <input type="hidden" name="manual_payments[{{ $index }}][id]" value="{{ $payment->id }}">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" name="manual_payments[{{ $index }}][amount]" value="{{ $payment->amount }}" class="form-control" step="0.01" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="manual_payments[{{ $index }}][description]" value="{{ $payment->description }}" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="datetime-local" name="manual_payments[{{ $index }}][start_time]" value="{{ \Carbon\Carbon::parse($payment->start_time)->format('Y-m-d\\TH:i') }}" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Frequency</label>
                                            <select name="manual_payments[{{ $index }}][frequency]" class="form-control frequencySelect">
                                                <option value="daily" {{ $payment->frequency == 'daily' ? 'selected' : '' }}>Daily</option>
                                                <option value="monthly" {{ $payment->frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            </select>
                                        </div>
                                        <div class="form-group monthly-day-wrapper {{ $payment->frequency == 'monthly' ? '' : 'd-none' }}">
                                            <label>Day of Month</label>
                                            <select name="manual_payments[{{ $index }}][monthly_day]" class="form-control">
                                                @for($i=1;$i<=30;$i++)
                                                    <option value="{{ $i }}" {{ $payment->monthly_day == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        {{-- Delete Button --}}
                                        <form method="POST" action="{{ route('admin.plan.manual.payment.delete', $payment->id) }}" onsubmit="return confirm('Are you sure you want to delete this manual payment?')" class="mt-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                                <i class="las la-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach

                                {{-- New entry (blank) --}}
                                <div class="col-md-6 mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="manual_payments[new_1][amount]" class="form-control" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="manual_payments[new_1][description]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <input type="datetime-local" name="manual_payments[new_1][start_time]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Frequency</label>
                                        <select name="manual_payments[new_1][frequency]" class="form-control frequencySelect">
                                            <option value="daily">Daily</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="form-group monthly-day-wrapper d-none">
                                        <label>Day of Month</label>
                                        <select name="manual_payments[new_1][monthly_day]" class="form-control">
                                            @for($i=1;$i<=30;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">@lang('Plan Update')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).on('change', '.frequencySelect', function () {
        const wrapper = $(this).closest('div').siblings('.monthly-day-wrapper');
        if ($(this).val() === 'monthly') {
            wrapper.removeClass('d-none');
        } else {
            wrapper.addClass('d-none');
        }
    });
</script>
@endpush