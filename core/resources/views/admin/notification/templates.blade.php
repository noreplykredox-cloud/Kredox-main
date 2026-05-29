@extends('admin.layouts.app')
@section('panel')
<div class="row">
	<div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">@lang('Notification Templates')</h5>
                <input type="text" id="templateSearch" class="form-control form-control-sm" style="max-width:280px;" placeholder="Search templates...">
            </div>
            <div class="card-body px-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table" id="templatesTable">
                        <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Subject')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($templates as $template)
                            <tr class="template-row">
                                <td>
                                    <span class="template-name">{{ __($template->name) }}</span>
                                    @if($template->act === 'INVESTMENT_OTP')
                                        <span class="badge bg--primary ms-1">Investment OTP</span>
                                    @endif
                                </td>
                                <td>
                                    <code style="font-size:11px;background:rgba(0,0,0,0.1);padding:2px 6px;border-radius:4px;">{{ $template->act }}</code>
                                </td>
                                <td>
                                    <span class="template-subject">{{ Str::limit($template->subj, 55) }}</span>
                                </td>
                                <td class="d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn btn-sm btn-outline--info preview-btn"
                                        data-body="{{ e($template->email_body) }}"
                                        data-name="{{ $template->name }}">
                                        <i class="la la-eye"></i> @lang('Preview')
                                    </button>
                                    <a href="{{ route('admin.setting.notification.template.edit', $template->id) }}"
                                        class="btn btn-sm btn-outline--primary">
                                        <i class="la la-pencil"></i> @lang('Edit')
                                    </a>
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
        </div><!-- card end -->
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" style="background:#1a1a2e;border:1px solid rgba(255,255,255,0.1);border-radius:16px;">
            <div class="modal-header border-0" style="padding:20px 24px 10px;">
                <h5 class="modal-title text-white" id="previewModalTitle">Email Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <iframe id="previewFrame" style="width:100%;height:600px;border:none;border-radius:10px;background:#fff;"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    // Search
    $('#templateSearch').on('input', function(){
        let q = $(this).val().toLowerCase();
        $('.template-row').each(function(){
            let name = $(this).find('.template-name').text().toLowerCase();
            let subj = $(this).find('.template-subject').text().toLowerCase();
            let act = $(this).find('code').text().toLowerCase();
            $(this).toggle(name.includes(q) || subj.includes(q) || act.includes(q));
        });
    });

    // Preview
    $(document).on('click', '.preview-btn', function(){
        let body = $(this).data('body');
        let name = $(this).data('name');
        $('#previewModalTitle').text('Preview: ' + name);
        let frame = document.getElementById('previewFrame');
        frame.srcdoc = body;
        $('#previewModal').modal('show');
    });
</script>
@endpush
