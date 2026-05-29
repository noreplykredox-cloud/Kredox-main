@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30 justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <!-- Information Card -->
            <div class="card b-radius--10 box--shadow1 overflow-hidden mb-30 border-0">
                <div class="card-body p-0">
                    <div class="bg--dark p-4 d-flex align-items-center">
                        <div class="icon-area me-3">
                            <i class="las la-info-circle text--danger" style="font-size: 40px;"></i>
                        </div>
                        <div class="text-area">
                            <h5 class="text-white mb-1">@lang('System Update Notice')</h5>
                            <p class="text-white-50 mb-0">
                                @lang('If images do not update immediately, please') <span class="text--danger fw-bold">@lang('clear your browser cache')</span>. 
                                @lang('Files are overwritten to maintain system consistency, which may cause temporary caching at the browser or server level.')
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10 box--shadow1 overflow-hidden border-0">
                <div class="card-header bg--dark border-bottom border--light">
                    <h5 class="card-title text-white mb-0"><i class="las la-images me-2"></i>@lang('Identity Assets')</h5>
                </div>
                <div class="card-body bg--dark-two p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Logo Upload -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-3 border border--light bg--dark">
                                    <h6 class="text-white mb-4 text-center">@lang('Master Branding Logo')</h6>
                                    <div class="image-upload-wrapper">
                                        <div class="preview-container mb-4">
                                            <div class="row g-2 justify-content-center">
                                                <div class="col-6">
                                                    <div class="logo-preview-box light-bg rounded" style="background-image: url({{ getImage(getFilePath('logoIcon').'/logo.png') . '?' . time() }})">
                                                    </div>
                                                    <small class="text-muted d-block text-center mt-1">@lang('Light Mode')</small>
                                                </div>
                                                <div class="col-6">
                                                    <div class="logo-preview-box dark-bg rounded" style="background-image: url({{ getImage(getFilePath('logoIcon').'/logo.png') . '?' . time() }})">
                                                    </div>
                                                    <small class="text-muted d-block text-center mt-1">@lang('Dark Mode')</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-file-input-wrapper">
                                            <input type="file" class="d-none" id="logoUpload" accept=".png, .jpg, .jpeg" name="logo">
                                            <label for="logoUpload" class="btn btn--outline-danger w-100 py-2">
                                                <i class="las la-cloud-upload-alt me-2"></i>@lang('Change Logo')
                                            </label>
                                            <p class="text-muted small text-center mt-2">@lang('Recommended: PNG/JPG (Max 2MB)')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon Upload -->
                            <div class="col-md-6">
                                <div class="upload-card h-100 p-4 rounded-3 border border--light bg--dark">
                                    <h6 class="text-white mb-4 text-center">@lang('Browser Favicon')</h6>
                                    <div class="image-upload-wrapper">
                                        <div class="preview-container mb-4 d-flex justify-content-center align-items-center" style="height: 120px;">
                                            <div class="favicon-preview-box rounded-circle border border--light p-3 bg-white shadow-sm" style="width: 80px; height: 80px;">
                                                <img src="{{ getImage(getFilePath('logoIcon') .'/favicon.png') . '?' . time() }}" alt="favicon" class="w-100 h-100 object-fit-contain">
                                            </div>
                                        </div>
                                        <div class="custom-file-input-wrapper">
                                            <input type="file" class="d-none" id="faviconUpload" accept=".png" name="favicon">
                                            <label for="faviconUpload" class="btn btn--outline-danger w-100 py-2">
                                                <i class="las la-cloud-upload-alt me-2"></i>@lang('Change Favicon')
                                            </label>
                                            <p class="text-muted small text-center mt-2">@lang('Strictly PNG (Ideal: 128x128)')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-top border--light text-end">
                            <button type="submit" class="btn btn--danger btn-lg px-5 shadow-lg">
                                <i class="las la-check-circle me-2"></i>@lang('Update Assets')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg--dark-two {
            background-color: #0f111a !important;
        }
        .border--light {
            border-color: rgba(255,255,255,0.05) !important;
        }
        .logo-preview-box {
            height: 120px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .logo-preview-box.light-bg {
            background-color: #f8f9fa;
        }
        .logo-preview-box.dark-bg {
            background-color: #1a1c27;
        }
        .upload-card {
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        .upload-card:hover {
            transform: translateY(-5px);
            border-color: rgba(234, 30, 37, 0.3) !important;
        }
        .btn--outline-danger {
            border: 1px solid #ea1e25;
            color: #ea1e25;
            background: transparent;
            transition: all 0.3s ease;
        }
        .btn--outline-danger:hover {
            background: #ea1e25;
            color: #fff;
            box-shadow: 0 5px 15px rgba(234, 30, 37, 0.3);
        }
        .btn--danger {
            background: #ea1e25;
            border-color: #ea1e25;
            color: #fff;
        }
        .btn--danger:hover {
            background: #d3181f;
            border-color: #d3181f;
            transform: scale(1.02);
        }
        .text-white-50 {
            color: rgba(255,255,255,0.6) !important;
        }
        .object-fit-contain {
            object-fit: contain;
        }
    </style>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            // Preview Image
            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        if(previewId.includes('favicon')) {
                            $(previewId).find('img').attr('src', e.target.result);
                        } else {
                            $(previewId).css('background-image', 'url(' + e.target.result + ')');
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#logoUpload").change(function () {
                readURL(this, ".logo-preview-box");
            });

            $("#faviconUpload").change(function () {
                readURL(this, ".favicon-preview-box");
            });
        })(jQuery);
    </script>
@endpush
