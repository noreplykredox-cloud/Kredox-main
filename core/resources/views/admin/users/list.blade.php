@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('User')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Country')</th>
                                <th>@lang('Joined At')</th>
                                <th>@lang('Balance')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$user->fullname}}</span>
                                    <br>
                                    <span class="small">
                                    <a href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                    </span>
                                </td>


                                <td>
                                    {{ $user->email }}<br>{{ $user->mobile }}
                                </td>
                                <td>
                                    <span class="fw-bold" title="{{ @$user->address->country }}">{{ $user->country_code }}</span>
                                </td>



                                <td>
                                    {{ showDateTime($user->created_at) }} <br> {{ diffForHumans($user->created_at) }}
                                </td>


                                <td>
                                    <span class="fw-bold">

                                    {{ $general->cur_sym }}{{ showAmount($user->balance) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.users.detail', $user->id) }}" class="btn btn-sm btn-outline--primary">
                                        <i class="las la-desktop text--shadow"></i> @lang('Details')
                                    </a>
                                     @if($user->is_deleted)
                                         <button type="button" class="btn btn-sm btn-outline--success ms-1 restoreBtn" data-id="{{ $user->id }}" data-username="{{ $user->username }}">
                                             <i class="las la-redo-alt"></i> @lang('Restore')
                                         </button>
                                     @endif
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($users) }}
                </div>
                @endif
            </div>
        </div>


    </div>

    <div id="restoreModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span>@lang('Restore User')</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST" id="restoreForm">
                    @csrf
                    <div class="modal-body text-center">
                        <h6 class="mb-2">@lang('Are you sure to restore this user?')</h6>
                        <p><strong class="restoreUsername text--primary"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal" data-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--success">@lang('Yes, Restore')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        $('.restoreBtn').on('click', function(){
            var modal = $('#restoreModal');
            var id = $(this).data('id');
            var username = $(this).data('username');
            modal.find('.restoreUsername').text(username);
            modal.find('#restoreForm').attr('action', "{{ route('admin.users.restore', '') }}/" + id);
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush

@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
