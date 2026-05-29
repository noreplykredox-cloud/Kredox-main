@extends($activeTemplate . 'layouts.' . (request()->ajax() ? 'blank' : $layout))
@section('content')
    <div class="main-content messenger-view-wrapper">
        <style>
            :root {
                --ms-primary: #ff0000;
                --ms-primary-soft: rgba(255, 0, 0, 0.1);
                --ms-bg: #0a0a0a;
                --ms-card: #111111;
                --ms-user-bubble: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
                --ms-admin-bubble: #1c1c1c;
                --ms-text: #ffffff;
                --ms-text-soft: #b0b0b0;
                --ms-muted: #666666;
                --ms-border: rgba(255, 0, 0, 0.12);
                --ms-shadow: 0 12px 40px rgba(0, 0, 0, 0.8);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            footer {
                display: none !important;
            }

            /* ─── Standalone page shell (when accessed directly) ─── */
            .ms-page-shell {
                display: flex;
                height: calc(100vh - 40px);
                max-width: 1400px;
                margin: 20px auto;
                border-radius: 18px;
                overflow: hidden;
                box-shadow: var(--ms-shadow);
                border: 1px solid var(--ms-border);
                background: var(--ms-bg);
            }

            /* ─── Chat Container ─── */
            .ms-chat-container {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
                flex: 1;
                min-height: 0;
                background: var(--ms-bg);
                overflow: hidden;
            }

            /* Header */
            .ms-chat-header {
                padding: 13px 20px;
                background: #111;
                border-bottom: 1px solid var(--ms-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-shrink: 0;
                z-index: 5;
            }

            .ms-hdr-left {
                display: flex;
                align-items: center;
                gap: 13px;
            }

            .ms-avatar {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                background: var(--ms-user-bubble);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #fff;
                border: 2px solid var(--ms-border);
            }

            .ms-hdr-title {
                font-size: 14px;
                font-weight: 700;
                color: #fff;
                margin: 0;
            }

            .ms-hdr-sub {
                font-size: 11.5px;
                color: var(--ms-muted);
            }

            .ms-hdr-right {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .badge-ms {
                padding: 3px 11px;
                border-radius: 12px;
                font-size: 10.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .3px;
            }

            .badge-ms-open {
                background: rgba(0, 200, 100, .12);
                color: #00c864;
                border: 1px solid rgba(0, 200, 100, .2);
            }

            .badge-ms-ans {
                background: rgba(50, 130, 255, .12);
                color: #3282ff;
                border: 1px solid rgba(50, 130, 255, .2);
            }

            .badge-ms-rep {
                background: rgba(255, 170, 0, .12);
                color: #ff3333;
                border: 1px solid rgba(255, 170, 0, .2);
            }

            .badge-ms-closed {
                background: rgba(120, 120, 120, .12);
                color: #999;
                border: 1px solid rgba(120, 120, 120, .2);
            }

            .ms-icon-btn {
                width: 33px;
                height: 33px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid var(--ms-border);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: .25s;
                text-decoration: none;
                font-size: 13px;
            }

            .ms-icon-btn:hover {
                background: #ff0000;
                border-color: transparent;
                color: #fff;
            }

            .ms-chat-body {
                flex: 1;
                overflow-y: auto;
                padding: 20px 25px;
                background: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
                background-color: #080808;
                background-blend-mode: overlay;
                display: flex;
                flex-direction: column;
                gap: 10px;
                scrollbar-width: thin;
                scrollbar-color: var(--ms-primary) transparent;
            }

            .ms-chat-body::-webkit-scrollbar {
                width: 5px;
            }

            .ms-chat-body::-webkit-scrollbar-thumb {
                background: var(--ms-primary);
                border-radius: 10px;
            }

            /* Bubbles */
            .ms-wrapper {
                display: flex;
                width: 100%;
            }

            .ms-wrapper.user {
                justify-content: flex-end;
            }

            .ms-wrapper.admin {
                justify-content: flex-start;
            }

            .ms-bubble {
                max-width: 65%;
                padding: 10px 14px;
                font-size: 13.5px;
                line-height: 1.55;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
                position: relative;
                word-break: break-word;
            }

            .user .ms-bubble {
                background: var(--ms-user-bubble);
                color: #fff;
                border-radius: 16px 16px 4px 16px;
                margin-right: 6px;
            }

            .admin .ms-bubble {
                background: var(--ms-admin-bubble);
                color: #e6e6e6;
                border-radius: 16px 16px 16px 4px;
                border: 1px solid var(--ms-border);
                margin-left: 6px;
            }

            .ms-sender {
                font-size: 11px;
                font-weight: 700;
                margin-bottom: 4px;
                display: block;
            }

            .user .ms-sender {
                color: #ffc0c0;
                text-align: right;
            }

            .admin .ms-sender {
                color: var(--ms-primary);
            }

            .ms-meta {
                font-size: 10px;
                margin-top: 6px;
                display: flex;
                justify-content: flex-end;
                gap: 4px;
                opacity: .65;
            }

            /* Attachments */
            .ms-attachment {
                background: rgba(0, 0, 0, 0.25);
                border-radius: 8px;
                padding: 7px 12px;
                margin-top: 8px;
                display: flex;
                align-items: center;
                gap: 9px;
                text-decoration: none !important;
                border: 1px solid rgba(255, 255, 255, 0.08);
            }

            .ms-attachment i {
                color: var(--ms-primary);
                font-size: 15px;
            }

            .ms-attachment span {
                color: #fff;
                font-size: 12px;
            }

            /* Footer */
            .ms-chat-footer {
                padding: 15px 20px;
                background: #0d0d0d;
                border-top: 1px solid var(--ms-border);
                flex-shrink: 0;
            }

            .ms-input-row {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .ms-input-wrap {
                flex: 1;
                background: rgba(255, 255, 255, 0.04);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 28px;
                padding: 4px 20px;
                display: flex;
                align-items: center;
                transition: var(--transition);
            }

            .ms-input-wrap:focus-within {
                background: rgba(255, 255, 255, 0.06);
                border-color: rgba(255, 0, 0, 0.4);
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.1);
            }

            .ms-input-wrap textarea {
                flex: 1;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                color: #fff !important;
                padding: 4px 0 12px;
                resize: none;
                max-height: 150px;
                min-height: 30px;
                font-size: 15px;
                outline: none !important;
                height: 30px;
                line-height: 22px;
                overflow-y: hidden;
                text-align: left;
            }

            .ms-round-btn {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                border: none;
                cursor: pointer;
                transition: var(--transition);
                flex-shrink: 0;
            }

            .ms-btn-send {
                background: var(--ms-user-bubble);
                color: #fff;
                box-shadow: 0 6px 16px rgba(255, 0, 0, 0.35);
            }

            .ms-btn-send:hover {
                transform: scale(1.05) translateY(-2px);
                box-shadow: 0 8px 24px rgba(255, 0, 0, 0.5);
            }

            .ms-btn-attach {
                background: rgba(255, 255, 255, 0.04);
                color: var(--ms-text-soft);
                font-size: 16px;
                border: 1px solid rgba(255, 255, 255, 0.05);
            }

            .ms-btn-attach:hover {
                background: rgba(255, 0, 0, 0.1);
                color: var(--ms-primary);
                transform: rotate(15deg);
            }

            .att-preview-row {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 9px;
            }

            .att-preview-item {
                background: #1a1a1a;
                padding: 4px 12px;
                border-radius: 14px;
                border: 1px solid var(--ms-border);
                font-size: 11.5px;
                display: flex;
                align-items: center;
                gap: 7px;
                color: #ddd;
            }

            /* Closed notice */
            .ms-closed-notice {
                text-align: center;
                padding: 18px;
                background: rgba(120, 120, 120, 0.08);
                border-top: 1px solid rgba(255, 255, 255, 0.06);
                color: var(--ms-muted);
                font-size: 13px;
            }

            @keyframes msFadeUp {
                from {
                    opacity: 0;
                    transform: translateY(8px)
                }

                to {
                    opacity: 1;
                    transform: translateY(0)
                }
            }

            /* Date separator */
            .ms-date-sep {
                display: flex;
                align-items: center;
                gap: 10px;
                margin: 12px 0 8px;
                flex-shrink: 0;
            }

            .ms-date-sep::before,
            .ms-date-sep::after {
                content: '';
                flex: 1;
                height: 1px;
                background: rgba(255, 255, 255, 0.07);
            }

            .ms-date-sep span {
                font-size: 11px;
                color: #888;
                background: rgba(255, 255, 255, 0.06);
                border: 1px solid rgba(255, 255, 255, 0.08);
                padding: 3px 12px;
                border-radius: 12px;
                white-space: nowrap;
                letter-spacing: .3px;
            }

            /* Message time tooltip on hover */
            .ms-bubble:hover .ms-full-time {
                opacity: 1;
            }

            .ms-full-time {
                font-size: 10px;
                color: rgba(255, 255, 255, 0.4);
                margin-top: 2px;
                opacity: 0;
                transition: opacity .2s;
                text-align: right;
            }

            /* Info note below input */
            .ms-info-note {
                display: flex;
                align-items: center;
                gap: 12px;
                background: rgba(255, 255, 255, 0.02);
                border: 1px solid rgba(255, 255, 255, 0.04);
                border-radius: 12px;
                padding: 10px 16px;
                margin-top: 15px;
            }

            .ms-info-note i {
                color: rgba(255, 180, 0, 0.6);
                font-size: 14px;
            }

            .ms-info-note p {
                margin: 0;
                font-size: 12px;
                color: #777;
                line-height: 1.5;
            }

            .ms-info-note p strong {
                color: #999;
                font-weight: 600;
            }

            /* Standalone page adjustments */
            @media (max-width: 991px) {
                .ms-page-shell {
                    height: 100vh;
                    height: 100dvh;
                    margin: 0;
                    border-radius: 0;
                    border: none;
                    max-width: 100%;
                }

                .ms-bubble {
                    max-width: 82%;
                }

                .ms-chat-header {
                    display: none !important;
                }

                .ms-chat-body {
                    padding: 14px 12px;
                }

                .ms-chat-footer {
                    padding: 10px 12px;
                }

                /* Hide back button when loaded in AJAX panel (mobile topbar handles it) */
                .wa-chat-frame .ms-back-btn-wrap {
                    display: none !important;
                }
            }
        </style>

        {{-- If accessed directly (not via AJAX), redirect to index with auto-open param --}}
        @php
            $isStandalone = !request()->ajax();
        @endphp

        @if($isStandalone)
            <script>
                // Redirect to the split WhatsApp layout and auto-open this conversation
                window.location.replace('{{ route("ticket.index") }}?open={{ $myTicket->ticket }}');
            </script>
        @endif


        <div class="ms-chat-container">
            {{-- Header --}}
            <div class="ms-chat-header">
                <div class="ms-hdr-left">
                    <span class="ms-back-btn-wrap">
                        <a href="{{ route('ticket.index') }}" class="ms-icon-btn" title="Back to conversations">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </span>
                    <div class="ms-avatar"><i class="fas fa-headset"></i></div>
                    <div>
                        <p class="ms-hdr-title">{{ __($myTicket->subject) }}</p>
                        <span class="ms-hdr-sub">#{{ $myTicket->ticket }}</span>
                    </div>
                </div>
                <div class="ms-hdr-right">
                    <span class="badge-ms
                    @if($myTicket->status == 0) badge-ms-open
                    @elseif($myTicket->status == 1) badge-ms-ans
                    @elseif($myTicket->status == 2) badge-ms-rep
                    @else badge-ms-closed @endif">
                        @if($myTicket->status == 0) Open
                        @elseif($myTicket->status == 1) Answered
                        @elseif($myTicket->status == 2) Replied
                        @else Closed @endif
                    </span>
                    @if($myTicket->status != 3)
                        <button class="ms-close-conv-btn confirmationBtn" data-action="{{ route('ticket.close', $myTicket->id) }}"
                            data-question="Has your issue been completely resolved? If you are satisfied with the assistance provided, you can close this conversation now. Please note that once closed, you will not be able to send further messages in this specific thread." title="Close Ticket">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Messages with WhatsApp-style date separators --}}
            <div class="ms-chat-body" id="chatBody">
                @php
                    $lastDate = null;
                    $now = \Carbon\Carbon::now();
                @endphp

                @foreach($messages as $message)
                    @php
                        $msgDate = $message->created_at->toDateString();
                        $showSep = ($msgDate !== $lastDate);
                        $lastDate = $msgDate;

                        if ($message->created_at->isToday()) {
                            $dateLabel = 'Today';
                        } elseif ($message->created_at->isYesterday()) {
                            $dateLabel = 'Yesterday';
                        } else {
                            $dateLabel = $message->created_at->format('d M Y');
                        }
                    @endphp

                    @if($showSep)
                        <div class="ms-date-sep"><span>{{ $dateLabel }}</span></div>
                    @endif

                    <div class="ms-wrapper {{ $message->admin_id == 0 ? 'user' : 'admin' }}" data-id="{{ $message->id }}">
                        <div class="ms-bubble">
                            <span class="ms-sender">
                                {{ $message->admin_id == 0 ? __('You') : __($message->admin->name) }}
                            </span>
                            <div class="ms-text">{{ __($message->message) }}</div>

                            @if($message->attachments->count() > 0)
                                <div class="ms-attachments-list mt-1">
                                    @foreach($message->attachments as $k => $image)
                                        <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="ms-attachment">
                                            <i class="fas fa-file-download"></i>
                                            <span>@lang('Attachment') {{ ++$k }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <div class="ms-meta">
                                <span>{{ $message->created_at->format('h:i A') }}</span>
                                @if($message->admin_id == 0)
                                    <i class="fas fa-check-double" style="color:#4fc3f7;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Footer / Input --}}
            @if($myTicket->status != 3)
                <div class="ms-chat-footer">
                    <form method="post" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data"
                        id="replyForm">
                        @csrf
                        <div id="att-preview" class="att-preview-row"></div>
                        <div class="ms-input-row">
                            <input type="file" name="attachments[]" id="file-input" multiple style="display:none;"
                                onchange="handleFiles(this)">
                            <button type="button" class="ms-round-btn ms-btn-attach"
                                onclick="document.getElementById('file-input').click()">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <div class="ms-input-wrap">
                                <textarea name="message" id="messageInput" placeholder="@lang('Type a message...')" required
                                    rows="1"></textarea>
                            </div>
                            <button type="submit" class="ms-round-btn ms-btn-send">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>

                        {{-- Info Note --}}
                        <div class="ms-info-note">
                            <i class="fas fa-info-circle"></i>
                            <p>
                                <strong>Note:</strong> Your messages are sent directly to our <strong>Admin Support
                                    Team</strong> and will be reviewed as soon as possible.
                                You will receive the reply to your registered <strong>email address</strong> — please check your
                                inbox (and spam folder) for a response.
                            </p>
                        </div>
                    </form>
                </div>
            @else
                <div class="ms-closed-notice">
                    <i class="fas fa-lock me-2"></i> @lang('This conversation is closed.')
                </div>
            @endif
        </div>




        <script>
            window.initMessenger = function () {
                // Scroll to bottom
                const body = document.getElementById('chatBody');
                if (body) body.scrollTop = body.scrollHeight;

                // AJAX Form Submit
                $('#replyForm').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    const $form = $(this);
                    const $btn = $form.find('.ms-btn-send');
                    const formData = new FormData(this);

                    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            $form[0].reset();
                            $('#att-preview').empty();
                            if ($ta.length) $ta.css('height', '30px');

                            // Immediately refresh chat body
                            $.get(window.location.href + (window.location.href.indexOf('?') > -1 ? '&' : '?') + 'v=' + Date.now(), function (data) {
                                const $newHtml = $(data);
                                const newContent = $newHtml.find('#chatBody').html() || $newHtml.filter('#chatBody').html();
                                if (newContent) {
                                    $('#chatBody').html(newContent);
                                    const body = document.getElementById('chatBody');
                                    if (body) body.scrollTop = body.scrollHeight;
                                }
                            });
                        },
                        error: function () {
                            alert('Failed to send message. Please try again.');
                        },
                        complete: function () {
                            $btn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
                        }
                    });
                });

                // Auto-resize and Enter-to-send
                const $ta = $('#messageInput');
                if ($ta.length) {
                    $ta.off('input keydown').on('input', function () {
                        this.style.height = '30px';
                        this.style.height = this.scrollHeight + 'px';
                        this.style.overflowY = (this.scrollHeight > 150) ? 'auto' : 'hidden';
                    }).on('keydown', function (e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            if (this.value.trim()) {
                                $('#replyForm').submit();
                            }
                        }
                    });
                }

                // Polling for new messages
                if (window.msPollInterval) clearInterval(window.msPollInterval);
                @if($myTicket->status != 3)
                    window.msPollInterval = setInterval(function () {
                        if (!$('#chatBody').length) { clearInterval(window.msPollInterval); return; }
                        $.ajax({
                            url: '{{ route("ticket.view", $myTicket->ticket) }}',
                            type: 'GET',
                            success: function (res) {
                                const $res = $(res);
                                const newHtml = $res.find('#chatBody').html() || $res.filter('#chatBody').html();
                                const curHtml = $('#chatBody').html();
                                if (newHtml && newHtml.length !== curHtml.length) {
                                    $('#chatBody').html(newHtml);
                                    const body = document.getElementById('chatBody');
                                    if (body) body.scrollTop = body.scrollHeight;
                                }
                            }
                        });
                    }, 10000);
                @endif
    };

            $(document).ready(function () { window.initMessenger(); });

            window.handleFiles = function (input) {
                const preview = document.getElementById('att-preview');
                if (!preview) return;
                preview.innerHTML = '';
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const div = document.createElement('div');
                    div.className = 'att-preview-item';
                    div.innerHTML = `<i class="fas fa-file" style="color:#ff0000"></i><span>${file.name.substring(0, 15)}...</span><i class="fas fa-times text-danger" style="cursor:pointer;" onclick="removeFiles()"></i>`;
                    preview.appendChild(div);
                }
            };
            window.removeFiles = function () {
                const fi = document.getElementById('file-input');
                if (fi) fi.value = '';
                const p = document.getElementById('att-preview');
                if (p) p.innerHTML = '';
            };
        </script>
    </div>
@endsection