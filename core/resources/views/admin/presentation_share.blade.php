@extends('admin.layouts.app')

@section('panel')
<div class="row justify-content-center gy-4">
    <div class="col-lg-10">
        <!-- Main Presentation Share Card -->
        <div class="card b-radius--10 box--shadow1 overflow-hidden">
            <div class="card-header bg--primary d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="card-title text-white mb-0">
                    <i class="las la-share-alt me-1"></i> @lang('Share Business Presentation')
                </h5>
                <span class="badge bg--success">@lang('4K Public Link Active')</span>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4">
                    @lang('Share the official Kredox Business Presentation link directly with your users or prospects across WhatsApp, Telegram, Facebook, and social networks.')
                </p>

                <!-- Presentation Public URL Input Box -->
                <div class="mb-4">
                    <label class="fw-bold mb-2">@lang('Public Presentation URL')</label>
                    <div class="input-group">
                        <input type="text" id="adminPptShareInput" class="form-control form-control-lg bg-light" readonly value="{{ route('public.presentation') }}" style="font-family: monospace; font-size: 15px;">
                        <button class="btn btn--primary px-4" type="button" onclick="copyAdminPptLink()">
                            <i class="las la-copy me-1"></i> @lang('Copy Link')
                        </button>
                    </div>
                    <div id="adminCopyAlert" class="alert alert-success mt-2 py-2 mb-0" style="display: none;">
                        <i class="las la-check-circle me-1"></i> @lang('Presentation link copied to clipboard successfully!')
                    </div>
                </div>

                <hr class="my-4">

                <!-- One-Click Social Share Buttons -->
                <h6 class="fw-bold mb-3"><i class="las la-paper-plane text--primary me-1"></i> @lang('One-Click Social Share')</h6>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-md-3">
                        <button class="btn w-100 py-3 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 8px;" onclick="shareAdminPptWhatsApp()">
                            <i class="lab la-whatsapp f-size--24"></i> @lang('WhatsApp')
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn w-100 py-3 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #0088cc, #005580); border-radius: 8px;" onclick="shareAdminPptTelegram()">
                            <i class="lab la-telegram-plane f-size--24"></i> @lang('Telegram')
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn w-100 py-3 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #1877F2, #0d47a1); border-radius: 8px;" onclick="shareAdminPptFacebook()">
                            <i class="lab la-facebook-f f-size--24"></i> @lang('Facebook')
                        </button>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <button class="btn btn--dark w-100 py-3 text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;" onclick="copyAdminPptLink()">
                            <i class="las la-link f-size--24"></i> @lang('Copy Link')
                        </button>
                    </div>
                </div>

                <!-- Shared Message Preview Box -->
                <div class="p-3 bg-light border rounded">
                    <h6 class="fw-bold text-dark mb-2"><i class="las la-comment-alt text--info me-1"></i> @lang('Shared Message Preview')</h6>
                    <p class="mb-0 text-secondary" style="font-size: 14px; line-height: 1.6;" id="adminShareTextPreview">
                        🚀 <strong>Explore Kredox Official 4K Business Presentation & High-Tech Ecosystem!</strong><br>
                        View presentation here:<br>
                        <a href="{{ route('public.presentation') }}" target="_blank" class="text-primary">{{ route('public.presentation') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function getAdminPptUrl() {
        return "{{ route('public.presentation') }}";
    }

    function copyAdminPptLink() {
        const input = document.getElementById('adminPptShareInput');
        if (input) {
            navigator.clipboard.writeText(input.value).then(() => {
                const alert = document.getElementById('adminCopyAlert');
                if (alert) {
                    alert.style.display = 'block';
                    setTimeout(() => { alert.style.display = 'none'; }, 3000);
                }
            });
        }
    }

    function shareAdminPptWhatsApp() {
        const url = getAdminPptUrl();
        const text = encodeURIComponent("🚀 Explore Kredox Official 4K Business Presentation & High-Tech Ecosystem!\n\nView presentation here:\n" + url);
        window.open("https://api.whatsapp.com/send?text=" + text, "_blank");
    }

    function shareAdminPptTelegram() {
        const url = getAdminPptUrl();
        const text = encodeURIComponent("🚀 Explore Kredox Official 4K Business Presentation & High-Tech Ecosystem!");
        window.open("https://t.me/share/url?url=" + encodeURIComponent(url) + "&text=" + text, "_blank");
    }

    function shareAdminPptFacebook() {
        const url = getAdminPptUrl();
        window.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url), "_blank");
    }
</script>
@endpush
