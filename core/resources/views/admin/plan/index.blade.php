@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Investment Range')</th>
                                    <th>@lang('Referral Percentage')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                    <tr>
                                        <td>
                                            {{ __($plan->name) }}
                                        </td>

                                        <td>
                                            <span>{{ showAmount($plan->minimum_investment) }} - {{ $plan->maximum_investment > 0 ? showAmount($plan->maximum_investment) : 'Unlimited' }}
                                                {{ __($general->cur_text) }}</span>
                                        </td>

                                        <td>
                                            <span>{{ getAmount($plan->referral_percentage) }}%</span>
                                        </td>

                                        <td>
                                            @php
                                                echo $plan->statusBadge;
                                            @endphp
                                        </td>

                                        <td>

                                            <a href="{{ route('admin.plan.edit', $plan->id) }}"
                                                class="btn btn-sm btn-outline--primary editGatewayBtn">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </a>

                                            @if ($plan->status == Status::DISABLE)
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to enable this investment?')"
                                                    data-action="{{ route('admin.plan.status', $plan->id) }}">
                                                    <i class="la la-eye"></i> @lang('Enable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="@lang('Are you sure to disable this investment?')"
                                                    data-action="{{ route('admin.plan.status', $plan->id) }}">
                                                    <i class="la la-eye-slash"></i> @lang('Disable')
                                                </button>
                                            @endif

                                            <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                data-question="@lang('Are you sure you want to delete this plan? This will also delete related levels and manual payments.')"
                                                data-action="{{ route('admin.plan.delete', $plan->id) }}">
                                                <i class="la la-trash"></i> @lang('Delete')
                                            </button>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="matrixSettingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Investment System Settings')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.plan.matrix.setting') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Matrix Height (Max Levels)')</label>
                            <input type="number" class="form-control form-control-lg" name="matrix_height"
                                value="{{ $general->matrix_height }}" required="">
                        </div>

                        <div class="form-group">
                            <label>@lang('Matrix Width (Referral Width)')</label>
                            <input type="number" class="form-control form-control-lg" name="matrix_width"
                                value="{{ $general->matrix_width }}" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn-outline--info matrixSetting"><i class="las la-cog"></i>@lang('Global Settings')</button>

    @if($plans->count() == 0)
    <a href="{{ route('admin.plan.create') }}" class="btn btn-sm btn-outline--primary addPlan"><i
            class="las la-plus"></i>@lang('Initialize Investment')</a>
    @endif
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.matrixSetting').click(function() {
                $('#matrixSettingModal').modal('show');
            });
        })(jQuery);
    </script>
@endpush
