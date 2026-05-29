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
                    </ul>

                    <div class="tab-content" id="planTabsContent">
                        {{-- Plan Settings Tab --}}
                        <div class="tab-pane fade show active" id="settings" role="tabpanel">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control form-control-lg" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Price')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" name="price"
                                            value="{{ old('price') }}" id="planAmount" required step="any">
                                        <div class="input-group-text">
                                            {{ __($general->cur_text) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Referral Bonus')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" id="referralBonus"
                                            name="referral_bonus" value="{{ old('referral_bonus') }}" required
                                            step="any">
                                        <div class="input-group-text">
                                            {{ __($general->cur_text) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>@lang('Enable Daily Referral Payout')</label>
                                    <select name="daily_referral_enabled" class="form-control">
                                        <option value="1" {{ old('daily_referral_enabled') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('daily_referral_enabled') != '1' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                      <label>@lang('Enable Level Commission')</label>
                                      <select name="daily_referral_enabled" class="form-control">
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
                                        <label>@lang('Level '){{ $i + 1 }} <small>(0 allowed)</small></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg commissionAmount"
                                                name="level[{{ $i + 1 }}]" step="any" min="0" value="0" required>
                                            <div class="input-group-text">
                                                {{ __($general->cur_text) }}
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Daily Referral Tab --}}
                        <div class="tab-pane fade" id="daily" role="tabpanel">
                            <div class="row mt-4">
                                @for ($i = 1; $i <= $general->matrix_height; $i++)
                                    <div class="form-group col-lg-3">
                                        <label>@lang('Level '){{ $i }}</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg payoutPercent"
                                                name="daily_referral_levels[{{ $i }}]"
                                                value="{{ old("daily_referral_levels.$i", 0) }}"
                                                step="any" min="0">
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="adminGain"></div>
                        <div class="adminLoss"></div>
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
        function planPriceCommission() {
            let levelAmount = 0;
            const planAmount = parseFloat($('#planAmount').val()) || 0;
            const referralBonus = parseFloat($('#referralBonus').val()) || 0;

            $('.commissionAmount').each(function() {
                const val = parseFloat($(this).val()) || 0;
                levelAmount += val;
            });

            const totalAmount = levelAmount + referralBonus;
            const currency = "{{ __($general->cur_text) }}";
            const finalAmount = planAmount - totalAmount;

            if (planAmount > totalAmount) {
                $('.adminGain').html('<strong class="text--success">@lang('Admin Benefit') : ' + finalAmount.toFixed(2) + ' ' + currency + '</strong>');
                $('.adminLoss').empty();
            } else {
                $('.adminLoss').html('<strong class="text--danger">@lang('Admin Loss') : ' + finalAmount.toFixed(2) + ' ' + currency + '</strong>');
                $('.adminGain').empty();
            }
        }

        $(document).on('keyup change', '.commissionAmount, #planAmount, #referralBonus', function() {
            planPriceCommission();
        });
    })(jQuery);
</script>
@endpush