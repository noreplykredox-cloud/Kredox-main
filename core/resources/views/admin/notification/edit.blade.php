@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($template->shortcodes as $shortcode => $key)
                                <tr>
                                    <th><span class="short-codes">@php echo "{{". $shortcode ."}}"  @endphp</span></th>
                                    <td>{{ __($key) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->

            <h6 class="mt-4 mb-2">@lang('Global Short Codes')</h6>
            <div class="card overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class=" table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code') </th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($general->global_shortcodes as $shortCode => $codeDetails)
                            <tr>
                                <td><span class="short-codes">@{{@php echo $shortCode @endphp}}</span></td>
                                <td>{{ __($codeDetails) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <form action="{{ route('admin.setting.notification.template.update',$template->id) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-white mb-0">@lang('Email Template')</h5>
                        <button type="button" id="previewEmailBtn" class="btn btn-sm btn-outline-light">
                            <i class="la la-eye"></i> Preview
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>@lang('Subject')</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="@lang('Email subject')" name="subject" value="{{ $template->subj }}" required/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Status') <span class="text--danger">*</span></label>
                                    <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success"
                                       data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Send Email')"
                                       data-off="@lang("Don't Send")" name="email_status"
                                       @if($template->email_status) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Email Body (HTML)') <span class="text--danger">*</span></label>
                                    <textarea name="email_body" id="emailBodyEditor" rows="20"
                                        class="form-control"
                                        style="font-family:'Courier New',monospace;font-size:13px;background:#0d0d1a;color:#e2e8f0;border-color:rgba(255,255,255,0.1);resize:vertical;"
                                        placeholder="@lang('Enter HTML email body')">{{ $template->email_body }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white">@lang('SMS Template')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Status') <span class="text--danger">*</span></label>
                                    <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success"
                                       data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Send SMS')"
                                       data-off="@lang("Don't Send")" name="sms_status"
                                       @if($template->sms_status) checked @endif>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Message')</label>
                                    <textarea name="sms_body" rows="10" class="form-control" placeholder="@lang('Your message using short-codes')" required>{{ $template->sms_body }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn--primary w-100 h-45 mt-4">@lang('Submit')</button>
    </form>

    <!-- Live Preview Panel -->
    <div class="card mt-4" id="emailPreviewCard" style="display:none;">
        <div class="card-header bg--dark d-flex justify-content-between align-items-center">
            <h5 class="card-title text-white mb-0"><i class="la la-eye"></i> Email Preview</h5>
            <button type="button" id="closePreviewBtn" class="btn btn-sm btn-outline-danger"><i class="la la-times"></i> Close</button>
        </div>
        <div class="card-body p-0">
            <iframe id="livePreviewFrame" style="width:100%;height:650px;border:none;"></iframe>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.setting.notification.templates') }}" />
@endpush

@push('script')
<script>
    // Live Preview
    $('#previewEmailBtn').on('click', function(){
        let html = $('#emailBodyEditor').val();
        let frame = document.getElementById('livePreviewFrame');
        frame.srcdoc = html;
        $('#emailPreviewCard').slideDown(300);
        $('html, body').animate({ scrollTop: $('#emailPreviewCard').offset().top - 80 }, 500);
    });

    $('#closePreviewBtn').on('click', function(){
        $('#emailPreviewCard').slideUp(300);
    });

    // Auto-update preview on typing (debounced)
    let previewTimer;
    $('#emailBodyEditor').on('input', function(){
        if ($('#emailPreviewCard').is(':visible')) {
            clearTimeout(previewTimer);
            previewTimer = setTimeout(function(){
                let html = $('#emailBodyEditor').val();
                document.getElementById('livePreviewFrame').srcdoc = html;
            }, 800);
        }
    });
</script>
@endpush
