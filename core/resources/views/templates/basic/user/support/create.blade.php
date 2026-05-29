@extends($activeTemplate . 'layouts.master')
@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <style>
        /* Hide Footer on Messenger Pages */
        footer { display: none !important; }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
        }

        #myVideo {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            transform: translate(-50%, -50%);
            object-fit: cover;
            opacity: 0.3;
            filter: brightness(0.2) sepia(0.5) hue-rotate(-10deg);
        }

        .messenger-create-container {
            padding: 30px 0;
            position: relative;
            z-index: 1;
        }

        .message__chatbox {
            background: rgba(17, 17, 17, 0.85);
            backdrop-filter: blur(15px);
            padding: 2.5rem;
            border-radius: 20px;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.2);
            animation: fadeIn 0.6s ease-out;
            position: relative;
            overflow: hidden;
            margin: 0 auto;
        }

        .message__chatbox::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
        }

        .form-label {
            color: #888;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 0, 0, 0.15);
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: #ff3333;
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.1);
            outline: none;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5);
        }

        .attachment-box {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 0, 0, 0.2);
            padding: 20px;
            border-radius: 12px;
        }

        .btn-add-file {
            background: rgba(255, 0, 0, 0.1);
            color: #ff3333;
            border: 1px solid rgba(255, 0, 0, 0.2);
            width: 40px; height: 40px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-file:hover {
            background: #ff3333;
            color: white;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endpush

@section('content')
    <div class="video-background">
        <video autoplay muted loop id="myVideo">
            <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4" type="video/mp4">
        </video>
    </div>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>Start New Conversation</h1>
                    <p>Tell us how we can help you today</p>
                </div>
            </div>
        </div>

        <div class="messenger-create-container">
            <div class="message__chatbox">
                <div class="card-header border-0 bg-transparent p-0 mb-4 d-flex justify-content-between align-items: center;">
                    <h4 class="text-white m-0">@lang('New Ticket Information')</h4>
                    <a href="{{ route('ticket.index') }}" class="btn-new-deposit" style="text-decoration: none; padding: 8px 15px; font-size: 13px;">
                        <i class="fas fa-arrow-left"></i> @lang('Back to Messenger')
                    </a>
                </div>
                
                <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data" class="row g-4">
                    @csrf
                    <div class="col-sm-6">
                        <label class="form-label">@lang('Full Name')</label>
                        <input type="text" name="name" class="form-control-custom" value="{{ auth()->user()->fullname }}" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">@lang('Email Address')</label>
                        <input type="text" name="email" class="form-control-custom" value="{{ auth()->user()->email }}" readonly>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">@lang('Subject') *</label>
                        <input type="text" name="subject" class="form-control-custom" placeholder="@lang('Briefly describe your request')" value="{{ old('subject') }}" required>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">@lang('Priority Level')</label>
                        <select name="priority" class="form-control-custom">
                            <option value="1">@lang('Low Priority')</option>
                            <option value="2">@lang('Medium Priority')</option>
                            <option value="3" selected>@lang('High Priority')</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">@lang('Detailed Message') *</label>
                        <textarea name="message" class="form-control-custom" placeholder="@lang('Provide as much detail as possible...')" style="min-height: 150px;" required>{{ old('message') }}</textarea>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">@lang('Attachments (Optional)')</label>
                        <div class="attachment-box">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control-custom" style="flex: 1;">
                                <button type="button" class="btn-add-file ms-2 addFile">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div id="fileUploadsContainer"></div>
                            <p class="text-muted small mt-2 mb-0">
                                <i class="fas fa-info-circle"></i> @lang('Max 5 files. Supported: .jpg, .jpeg, .png, .pdf, .doc, .docx')
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-4">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i> @lang('Create Conversation')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'Maximum 5 files allowed');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(
                    `<div class="removeFile mt-3">
                        <div class="input-group">
                            <input type="file" class="form-control-custom" name="attachments[]" required style="flex: 1;">
                            <button class="btn-add-file ms-2 bg-danger remove-btn" type="button" style="border-color: rgba(255,0,0,0.2); color: white;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>`
                )
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.removeFile').remove();
            });
        })(jQuery);
    </script>
@endpush