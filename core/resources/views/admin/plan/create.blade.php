@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12">
        <form action="{{ route('admin.plan.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="planTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="settings-tab" data-bs-toggle="tab" href="#settings"
                                role="tab">@lang('Plan Settings')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="levels-tab" data-bs-toggle="tab" href="#levels"
                                role="tab">@lang('Level Commissions')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="daily-tab" data-bs-toggle="tab" href="#daily"
                                role="tab">@lang('Daily Referral')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manual-tab" data-bs-toggle="tab" href="#manual"
                                role="tab">@lang('Manual ROI')</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="planTabsContent">
                        {{-- Plan Settings Tab --}}
                        <div class="tab-pane fade show active" id="settings" role="tabpanel">
                            {{-- ... existing settings ... --}}
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control form-control-lg" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('Referral Percentage')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" id="referralPercentage"
                                            name="referral_percentage" value="{{ old('referral_percentage') }}" required
                                            step="any">
                                        <div class="input-group-text">%</div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('Minimum Investment')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" name="minimum_investment"
                                            value="{{ old('minimum_investment') }}" required step="any">
                                        <div class="input-group-text">
                                            {{ __($general->cur_text) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('Maximum Investment')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" name="maximum_investment"
                                            value="{{ old('maximum_investment') }}" required step="any">
                                        <div class="input-group-text">
                                            {{ __($general->cur_text) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>@lang('OTP Verification Required')</label>
                                    <p class="text-muted small mb-2">When enabled, users must verify their email OTP before completing an investment.</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check form-switch" style="transform: scale(1.4); transform-origin: left;">
                                            <input class="form-check-input" type="checkbox" role="switch" name="require_otp" id="requireOtpToggle" value="1" {{ old('require_otp') ? 'checked' : '' }}>
                                        </div>
                                        <label class="mb-0" for="requireOtpToggle" id="requireOtpLabel" style="font-weight: 600; margin-left: 10px;">
                                            <span class="badge bg-secondary">Disabled</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                      <label>@lang('Enable Level Commission')</label>
                                      <select name="is_level_commission" class="form-control">
                                          <option value="1" {{ old('is_level_commission') == '1' ? 'selected' : '' }}>Yes</option>
                                          <option value="0" {{ old('is_level_commission') != '1' ? 'selected' : '' }}>No</option>
                                      </select>
                                  </div>
                            </div>
                        </div>

                        {{-- Level Commissions Tab --}}
                        <div class="tab-pane fade" id="levels" role="tabpanel">
                            <div class="row mt-4">
                                @for ($i = 0; $i < $general->matrix_height; $i++)
                                    <div class="form-group col-lg-3">
                                        <label>@lang('Level '){{ $i + 1 }} <small>(% percentage)</small></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg commissionPercent"
                                                name="level[{{ $i + 1 }}]" step="any" min="0" value="0" required>
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Daily Referral Tab --}}
                        <div class="tab-pane fade" id="daily" role="tabpanel">
                            <div class="row mt-4 mb-3">
                                <div class="form-group col-lg-4">
                                    <label>@lang('Daily Referral Payout Active')</label>
                                    <select name="daily_referral_enabled" class="form-control">
                                        <option value="1" {{ old('daily_referral_enabled') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('daily_referral_enabled') != '1' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Daily Referral Start Time')</label>
                                    <input type="datetime-local" class="form-control" name="daily_referral_start_time" value="{{ old('daily_referral_start_time') }}">
                                </div>
                                <div class="form-group col-lg-4 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2" style="transform: scale(1.1); transform-origin: left;">
                                        <input class="form-check-input" type="checkbox" role="switch" name="daily_referral_exclude_weekends" id="dailyReferralExcludeWeekends" value="1" {{ old('daily_referral_exclude_weekends') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="dailyReferralExcludeWeekends">@lang('Exclude Weekends (Saturday & Sunday)')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @for ($i = 1; $i <= $general->matrix_height; $i++)
                                    <div class="form-group col-lg-3">
                                        <label>@lang('Level '){{ $i }}</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg payoutPercent"
                                                name="level_payout[{{ $i }}]"
                                                value="{{ old("level_payout.$i", 0) }}"
                                                step="any" min="0">
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Manual ROI Tab --}}
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <div class="card border--primary mt-4">
                                <div class="card-header bg--primary d-flex justify-content-between align-items-center">
                                    <h5 class="text-white">@lang('ROI Schedules')</h5>
                                    <button type="button" class="btn btn-sm btn-outline-light addManualPaymentBtn">
                                        <i class="la la-plus"></i> @lang('Add ROI')
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row manual-payments-container">
                                        {{-- Dynamic rows will be added here --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="totalDeduction"></div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Create Plan')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.plan.index') }}" />
@endpush

@push('script')
<script>
    "use strict";
    (function($) {
        $('#requireOtpToggle').on('change', function() {
            if($(this).is(':checked')) {
                $('#requireOtpLabel').html('<span class="badge bg-success">Enabled</span>');
            } else {
                $('#requireOtpLabel').html('<span class="badge bg-secondary">Disabled</span>');
            }
        });

        function totalPercentage() {
            let levelPercent = 0;
            const referralPercent = parseFloat($('#referralPercentage').val()) || 0;

            $('.commissionPercent').each(function() {
                const val = parseFloat($(this).val()) || 0;
                levelPercent += val;
            });

            const total = levelPercent + referralPercent;
            $('.totalDeduction').html('<strong class="text--info">@lang('Total Percentage Deduction') : ' + total.toFixed(2) + '%</strong>');
        }

        $(document).on('keyup change', '.commissionPercent, #referralPercentage', function() {
            totalPercentage();
        });

        // Manual Payment Repeater
        let index = 0;

        function populateMonthSelect(selectElement, currentValue) {
            let optionsHtml = '<option value="all" ' + (currentValue === 'all' ? 'selected' : '') + '>All Months (Recurring)</option>';
            
            // Generate current month and next 24 months
            const date = new Date();
            for (let i = 0; i < 24; i++) {
                const year = date.getFullYear();
                const monthNum = String(date.getMonth() + 1).padStart(2, '0');
                const value = `${year}-${monthNum}`;
                const label = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
                
                optionsHtml += `<option value="${value}" ${currentValue === value ? 'selected' : ''}>${label}</option>`;
                
                // Move to next month
                date.setMonth(date.getMonth() + 1);
            }
            
            selectElement.html(optionsHtml);
        }

        // Toggle calendar day list visibility
        $(document).on('click', '.toggle-calendar-list', function() {
            const list = $(this).closest('.monthly-target-breakdown').find('.calendar-list');
            if (list.hasClass('d-none')) {
                list.removeClass('d-none');
                $(this).html('<i class="la la-eye-slash"></i> Hide Day-by-Day Calendar');
            } else {
                list.addClass('d-none');
                $(this).html('<i class="la la-eye"></i> Show Day-by-Day Calendar');
            }
        });

        // Frequency Change Handler
        $(document).on('change', '.frequencySelect', function () {
            const row = $(this).closest('.row');
            const val = $(this).val();
            
            const monthlyDayWrapper = row.find('.monthly-day-wrapper');
            const percentageWrapper = row.find('.percentage-wrapper');
            
            const targetMonthWrapper = row.find('.monthly-target-month-wrapper');
            const targetPercentageWrapper = row.find('.monthly-target-percentage-wrapper');
            const targetWeekendsWrapper = row.find('.monthly-target-weekends-wrapper');
            const targetBreakdown = row.find('.monthly-target-breakdown');
            
            // Standard Percentage Input
            const standardPct = row.find('.standardPercentageInput');
            // Monthly Target Inputs
            const selectedMonth = row.find('.selectedMonthInput');
            const monthlyPercentage = row.find('.monthlyPercentageInput');

            if (val === 'monthly') {
                monthlyDayWrapper.removeClass('d-none');
                percentageWrapper.removeClass('d-none');
                standardPct.prop('required', true);
                
                targetMonthWrapper.addClass('d-none');
                targetPercentageWrapper.addClass('d-none');
                targetWeekendsWrapper.addClass('d-none');
                targetBreakdown.addClass('d-none').html('');
                selectedMonth.prop('required', false);
                monthlyPercentage.prop('required', false);
            } else if (val === 'monthly_target') {
                monthlyDayWrapper.addClass('d-none');
                percentageWrapper.addClass('d-none');
                standardPct.prop('required', false);
                
                targetMonthWrapper.removeClass('d-none');
                targetPercentageWrapper.removeClass('d-none');
                targetWeekendsWrapper.removeClass('d-none');
                selectedMonth.prop('required', true);
                monthlyPercentage.prop('required', true);
                
                // Trigger calculation
                updateMonthlyTargetCalculations(row);
            } else {
                // daily
                monthlyDayWrapper.addClass('d-none');
                percentageWrapper.removeClass('d-none');
                standardPct.prop('required', true);
                
                targetMonthWrapper.addClass('d-none');
                targetPercentageWrapper.addClass('d-none');
                targetWeekendsWrapper.addClass('d-none');
                targetBreakdown.addClass('d-none').html('');
                selectedMonth.prop('required', false);
                monthlyPercentage.prop('required', false);
            }
        });

        // Trigger calculations on inputs change
        $(document).on('change input keyup', '.selectedMonthInput, .monthlyPercentageInput, .excludeWeekendsToggle', function() {
            const row = $(this).closest('.row');
            const freq = row.find('.frequencySelect').val();
            if (freq === 'monthly_target') {
                updateMonthlyTargetCalculations(row);
            }
        });

        function updateMonthlyTargetCalculations(row) {
            const monthVal = row.find('.selectedMonthInput').val(); // YYYY-MM or 'all'
            const pctVal = parseFloat(row.find('.monthlyPercentageInput').val()) || 0;
            const excludeWeekends = row.find('.excludeWeekendsToggle').is(':checked') ? 1 : 0;
            const breakdownContainer = row.find('.monthly-target-breakdown');

            if (!monthVal || pctVal <= 0) {
                breakdownContainer.addClass('d-none').html('');
                return;
            }

            let isAll = false;
            let displayMonthName = "";
            let year, month;
            
            if (monthVal === 'all') {
                isAll = true;
                const today = new Date();
                year = today.getFullYear();
                month = today.getMonth() + 1;
                displayMonthName = today.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            } else {
                const parts = monthVal.split('-');
                year = parseInt(parts[0]);
                month = parseInt(parts[1]);
                displayMonthName = new Date(year, month - 1, 1).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            }
            
            const startDate = new Date(year, month - 1, 1);
            const endDate = new Date(year, month, 0);
            const totalDays = endDate.getDate();

            let workingDays = 0;
            const daysList = [];

            for (let day = 1; day <= totalDays; day++) {
                const currentDate = new Date(year, month - 1, day);
                const isWeekend = currentDate.getDay() === 0 || currentDate.getDay() === 6; // 0 = Sun, 6 = Sat
                if (!isWeekend) {
                    workingDays++;
                }
                daysList.push({
                    day: day,
                    dateStr: currentDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }),
                    isWeekend: isWeekend
                });
            }

            const daysCount = excludeWeekends ? workingDays : totalDays;
            const dailyPercentage = pctVal / daysCount;

            let badgeHtml = `
                <div class="monthly-breakdown-card mt-3 p-3 rounded-3" style="background: #111827 !important; border: 1px solid #1f2937 !important; color: #fff !important; display: block !important; width: 100% !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); box-sizing: border-box !important;">
                    <div style="display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; width: 100% !important; box-sizing: border-box !important;">
                        <span style="font-weight: 700; font-size: 0.95rem; color: #fff !important; display: inline-block !important;">
                            ${isAll ? '🔄 Recurring: ROI Breakdown (Example for ' + displayMonthName + ')' : '📅 ROI Breakdown for ' + displayMonthName}
                        </span>
                        <span class="badge bg-success" style="background-color: #28a745 !important; font-size: 0.8rem; padding: 4px 8px; border-radius: 4px; display: inline-block !important; font-weight: bold; color: #fff !important;">${pctVal}% Target</span>
                    </div>
                    
                    ${isAll ? `
                    <div style="background: rgba(245, 158, 11, 0.15) !important; color: #fbbf24 !important; border: 1px solid rgba(245, 158, 11, 0.3) !important; padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; margin-bottom: 12px; display: block !important; line-height: 1.4; box-sizing: border-box !important; text-align: left !important;">
                        <i class="la la-info-circle" style="font-size: 1.1rem; vertical-align: middle; margin-right: 4px;"></i> Daily payouts will automatically adjust based on each specific month's total/working days.
                    </div>
                    ` : ''}
                    
                    <div style="display: flex !important; flex-direction: row !important; text-align: center !important; margin-bottom: 12px; background: rgba(255,255,255,0.03); border-radius: 8px; padding: 10px 0; border: 1px solid rgba(255,255,255,0.05); width: 100% !important; box-sizing: border-box !important;">
                        <div style="flex: 1 !important; border-right: 1px solid rgba(255,255,255,0.1); box-sizing: border-box !important;">
                            <span style="color: #9ca3af; display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">Payout Days</span>
                            <span style="font-size: 1.2rem; font-weight: 700; color: #38bdf8 !important; display: block !important;">${daysCount} Days</span>
                        </div>
                        <div style="flex: 1 !important; box-sizing: border-box !important;">
                            <span style="color: #9ca3af; display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px;">Calculated Daily Rate</span>
                            <span style="font-size: 1.2rem; font-weight: 700; color: #fbbf24 !important; display: block !important;">${dailyPercentage.toFixed(6)}%</span>
                        </div>
                    </div>
                    
                    <button type="button" class="btn w-100 mb-2 toggle-calendar-list" style="background: #374151 !important; color: #fff !important; border: 1px solid #4b5563 !important; font-size: 0.8rem; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: all 0.2s; display: block !important; width: 100% !important; box-sizing: border-box !important;">
                        <i class="la la-eye"></i> Show Day-by-Day Calendar
                    </button>
                    
                    <div class="calendar-list d-none mt-2" style="max-height: 180px; overflow-y: auto; border: 1px solid #374151; padding: 8px; border-radius: 6px; background: #1f2937; display: block !important; width: 100% !important; box-sizing: border-box !important; text-align: left !important;">
                        <table class="table table-sm table-borderless mb-0" style="font-size: 0.75rem; color: #fff !important; width: 100% !important; border-collapse: collapse !important; background: transparent !important;">
                            <thead>
                                <tr style="border-bottom: 1px solid #374151; color: #9ca3af !important;">
                                    <th style="padding: 6px 8px; text-align: left; background: transparent !important; color: #9ca3af !important; border: none !important;">Date</th>
                                    <th style="padding: 6px 8px; text-align: right; background: transparent !important; color: #9ca3af !important; border: none !important;">Daily ROI</th>
                                    <th style="padding: 6px 8px; text-align: center; background: transparent !important; color: #9ca3af !important; border: none !important;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            daysList.forEach(item => {
                const rate = (excludeWeekends && item.isWeekend) ? 0 : dailyPercentage;
                const label = item.isWeekend ? (excludeWeekends ? 'Skipped (Weekend)' : 'Active (Weekend)') : 'Active (Weekday)';
                const bgColor = item.isWeekend ? (excludeWeekends ? '#dc3545' : '#28a745') : '#28a745';
                
                badgeHtml += `
                    <tr style="opacity: ${item.isWeekend && excludeWeekends ? 0.5 : 1}; border-bottom: 1px solid rgba(255,255,255,0.05); background: transparent !important;">
                        <td style="color:#fff !important; padding: 6px 8px; text-align: left; background: transparent !important; border: none !important;">${item.dateStr}</td>
                        <td style="color: #fbbf24 !important; padding: 6px 8px; text-align: right; font-weight: 700; background: transparent !important; border: none !important;">${rate.toFixed(6)}%</td>
                        <td style="padding: 6px 8px; text-align: center; background: transparent !important; border: none !important;">
                            <span style="font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; color: #fff !important; background-color: ${bgColor} !important; font-weight: bold; display: inline-block !important; border: none !important;">
                                ${label}
                            </span>
                        </td>
                    </tr>
                `;
            });

            badgeHtml += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            breakdownContainer.removeClass('d-none').html(badgeHtml);
        }

        $('.addManualPaymentBtn').on('click', function(){
            let html = `
                <div class="col-md-6 mb-4 manual-payment-row">
                    <div class="card border-info">
                        <div class="card-header bg--info d-flex justify-content-between align-items-center p-2">
                            <span class="text-white small">@lang('New Schedule')</span>
                            <button type="button" class="btn btn-xs btn-danger removeManualPaymentBtn">
                                <i class="la la-trash"></i>
                            </button>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="form-group col-md-6 percentage-wrapper">
                                    <label class="small">ROI Percentage (%)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="manual_payments[new_${index}][percentage]" class="form-control standardPercentageInput" step="any" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="small">Frequency</label>
                                    <select name="manual_payments[new_${index}][frequency]" class="form-control form-control-sm frequencySelect">
                                        <option value="daily">Daily</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="monthly_target">Monthly Target ROI (Distributed Daily)</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 monthly-day-wrapper d-none">
                                    <label class="small">Day of Month</label>
                                    <select name="manual_payments[new_${index}][monthly_day]" class="form-control form-control-sm">
                                        @for($i=1;$i<=30;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-6 monthly-target-month-wrapper d-none">
                                    <label class="small">Select Month</label>
                                    <select name="manual_payments[new_${index}][selected_month]" class="form-control form-control-sm selectedMonthInput">
                                    </select>
                                </div>
                                <div class="form-group col-md-6 monthly-target-percentage-wrapper d-none">
                                    <label class="small">Monthly Percentage (%)</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="manual_payments[new_${index}][monthly_percentage]" class="form-control monthlyPercentageInput" step="any">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 monthly-target-weekends-wrapper d-none mt-2">
                                    <div class="form-check form-switch d-flex align-items-center gap-2">
                                        <input class="form-check-input excludeWeekendsToggle" type="checkbox" role="switch" name="manual_payments[new_${index}][exclude_weekends]" value="1" id="exclude_weekends_new_${index}">
                                        <label class="form-check-label small mb-0 fw-bold" for="exclude_weekends_new_${index}">Exclude Weekends (Saturday & Sunday)</label>
                                    </div>
                                </div>
                                <div class="col-md-12 monthly-target-breakdown d-none"></div>
                                <div class="form-group col-md-12 mt-2">
                                    <label class="small">Description</label>
                                    <input type="text" name="manual_payments[new_${index}][description]" class="form-control form-control-sm" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="small">Start Time</label>
                                    <input type="datetime-local" name="manual_payments[new_${index}][start_time]" class="form-control form-control-sm" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('.manual-payments-container').append(html);
            
            // Populate Month Select for new row
            const newRow = $('.manual-payments-container').children().last();
            const newSelect = newRow.find('.selectedMonthInput');
            populateMonthSelect(newSelect, 'all');

            index++;
        });

        $(document).on('click', '.removeManualPaymentBtn', function(){
            $(this).closest('.manual-payment-row').remove();
        });

    })(jQuery);
</script>
@endpush