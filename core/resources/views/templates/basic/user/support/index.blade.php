@extends($activeTemplate . 'layouts.master')
@push('style')
<link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
<style>
:root {
    --ms-primary: #ff0000;
    --ms-bg: #0a0a0a;
    --ms-sidebar-bg: #111111;
    --ms-chat-bg: #0d0d0d;
    --ms-border: rgba(255,0,0,0.15);
    --ms-hover: rgba(255,0,0,0.07);
    --ms-active: rgba(255,0,0,0.13);
    --ms-muted: #888;
    --ms-gradient: linear-gradient(135deg,#8b0000 0%,#ff0000 100%);
    --ms-shadow: 0 8px 32px rgba(0,0,0,0.7);
    --transition: all 0.25s ease;
}
footer { display: none !important; }
body   { overflow: hidden; }

/* Video BG */
.video-background { position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:-1;overflow:hidden; }
#myVideo { position:absolute;top:50%;left:50%;min-width:100%;min-height:100%;transform:translate(-50%,-50%);object-fit:cover;opacity:.15;filter:brightness(.2) sepia(.5) hue-rotate(-10deg); }

/* ─── Outer wrapper inside dashboard-container ─── */
.wa-wrapper {
    display: flex;
    height: calc(100vh - 40px);
    min-height: 500px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--ms-shadow);
    border: 1px solid var(--ms-border);
    background: var(--ms-bg);
}

/* ─── LEFT SIDEBAR ─── */
.wa-sidebar {
    width: 320px;
    min-width: 260px;
    display: flex;
    flex-direction: column;
    background: var(--ms-sidebar-bg);
    border-right: 1px solid var(--ms-border);
    flex-shrink: 0;
}

.wa-sidebar-hdr {
    padding: 14px 16px 12px;
    background: #0d0d0d;
    border-bottom: 1px solid var(--ms-border);
    flex-shrink: 0;
}
.wa-sidebar-hdr h2 {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 11px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.wa-sidebar-hdr h2 i { color: var(--ms-primary); }

.wa-search-box { position: relative; margin-bottom: 9px; }
.wa-search-input {
    width: 100%;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--ms-border);
    border-radius: 22px;
    padding: 8px 36px 8px 14px;
    color: #fff;
    font-size: 12.5px;
    outline: none;
    transition: var(--transition);
    box-sizing: border-box;
}
.wa-search-input:focus { border-color: var(--ms-primary); background: rgba(255,0,0,0.05); }
.wa-search-input::placeholder { color: var(--ms-muted); }
.wa-search-icon { position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--ms-muted);font-size:12px;pointer-events:none; }

.wa-new-btn {
    width: 100%;
    padding: 8px;
    background: var(--ms-gradient);
    border: none;
    border-radius: 22px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: var(--transition);
}
.wa-new-btn:hover { box-shadow: 0 0 16px rgba(255,0,0,0.4); transform: translateY(-1px); }

/* Conversation list */
.wa-list {
    flex: 1;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--ms-primary) transparent;
}
.wa-list::-webkit-scrollbar { width: 3px; }
.wa-list::-webkit-scrollbar-thumb { background: var(--ms-primary); border-radius: 10px; }

.wa-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    cursor: pointer;
    transition: var(--transition);
}
.wa-item:hover { background: var(--ms-hover); }
.wa-item.active { background: var(--ms-active); border-left: 3px solid var(--ms-primary); padding-left: 13px; }

.wa-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: var(--ms-gradient);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: #fff;
    flex-shrink: 0;
    border: 2px solid var(--ms-border);
}
.wa-info { flex: 1; min-width: 0; }
.wa-top  { display:flex;justify-content:space-between;align-items:center;margin-bottom:3px; }
.wa-subj { font-size:13.5px;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px; }
.wa-time { font-size:10.5px;color:var(--ms-muted);flex-shrink:0; }
.wa-bot  { display:flex;justify-content:space-between;align-items:center; }
.wa-tid  { font-size:11px;color:var(--ms-muted); }

.bwa { padding:2px 8px;border-radius:10px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.3px; }
.bwa-open   { background:rgba(0,200,100,.12);color:#00c864;border:1px solid rgba(0,200,100,.2); }
.bwa-ans    { background:rgba(50,130,255,.12);color:#3282ff;border:1px solid rgba(50,130,255,.2); }
.bwa-rep    { background:rgba(255,0,0,.12);color:#ff3333;border:1px solid rgba(255,0,0,.2); }
.bwa-closed { background:rgba(120,120,120,.12);color:#888;border:1px solid rgba(120,120,120,.2); }

.wa-empty { display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;padding:50px 20px;color:var(--ms-muted);text-align:center; }
.wa-empty i { font-size:36px;color:rgba(255,0,0,0.18); }
.wa-empty p { font-size:12.5px;margin:0;line-height:1.5; }

/* ─── RIGHT PANEL ─── */
.wa-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--ms-chat-bg);
    position: relative;
    overflow: hidden;
    min-width: 0;
}

/* Welcome screen */
.wa-welcome {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    color: var(--ms-muted);
    text-align: center;
    padding: 40px 20px;
    animation: wsFade .4s ease;
}
.wa-welcome-ico {
    width: 90px; height: 90px;
    border-radius: 50%;
    background: rgba(255,0,0,0.06);
    border: 2px solid var(--ms-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 38px; color: rgba(255,0,0,0.35);
}
.wa-welcome h3 { color: #bbb; font-size: 20px; font-weight: 600; margin: 0; }
.wa-welcome p  { font-size: 13px; max-width: 240px; line-height: 1.6; margin: 0; }

/* Loader overlay */
.wa-loader {
    display: none;
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 20;
    flex-direction: column;
    align-items: center; justify-content: center;
    gap: 12px;
    color: #fff; font-size: 13px;
}
.wa-loader.show { display: flex; }
.wa-spinner {
    width: 38px; height: 38px;
    border: 3px solid rgba(255,0,0,0.2);
    border-top-color: #ff0000;
    border-radius: 50%;
    animation: spin .8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Chat injected frame */
.wa-chat-frame {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    animation: wsFade .3s ease;
}
@keyframes wsFade { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

/* ─── MODAL ─── */
.custom--modal .modal-title { color: #fff; font-size: 14px; font-weight: 700; margin: 0; }

.form-label { color: #bbb; font-size: 10.5px; font-weight: 600; margin-bottom: 5px; text-transform: uppercase; letter-spacing: .5px; display: block; }
.form-control-custom {
    background: rgba(255,255,255,0.04) !important;
    border: 1px solid rgba(255,0,0,0.15) !important;
    border-radius: 10px !important;
    padding: 9px 14px !important;
    font-size: 13px !important;
    color: #fff !important;
    width: 100% !important;
    outline: none;
    transition: var(--transition);
}
.form-control-custom:focus { border-color: #ff3333 !important; box-shadow: 0 0 10px rgba(255,0,0,0.1) !important; }

.select-custom {
    appearance: none !important;
    background: rgba(255,255,255,0.04) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' fill='%23ff0000' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat calc(100% - 13px) center !important;
    border: 1px solid rgba(255,0,0,0.15) !important;
    border-radius: 10px !important;
    padding: 9px 14px !important;
    font-size: 13px !important;
    color: #fff !important;
    width: 100% !important;
    outline: none;
    cursor: pointer;
}
.select-custom option { background: #111; color: #fff; }

.custom-file-box {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,0,0,0.15);
    border-radius: 10px;
    padding: 8px 12px;
    display: flex; align-items: center; gap: 10px;
    position: relative;
}
.file-input-hidden { position:absolute;inset:0;opacity:0;cursor:pointer;z-index:10; }
.file-label-red { background:var(--ms-gradient);color:#fff;padding:5px 13px;border-radius:8px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:6px;flex-shrink:0; }

.submit-btn {
    width: 100%; height: 46px;
    background: var(--ms-gradient);
    color: #fff; border: none;
    border-radius: 11px;
    font-weight: 800; font-size: 13px;
    text-transform: uppercase; letter-spacing: .4px;
    cursor: pointer; transition: var(--transition);
}
.submit-btn:hover { box-shadow: 0 0 18px rgba(255,0,0,0.4); transform: translateY(-1px); }

.invalid-feedback { font-size: 11px; color: #ff5555 !important; margin-top: 4px; }
.form-control-custom.is-invalid { border-color: #ff5555 !important; }

/* ─── Responsive ─── */
@media (max-width: 991px) {
    /* On tablet/mobile, dashboard-container has no left margin */
    .dashboard-container {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .wa-wrapper {
        height: 100vh;
        height: 100dvh;
        border-radius: 0;
        border: none;
        position: fixed;
        top: 75px; left: 0; right: 0; bottom: 0;
        height: calc(100vh - 75px);
        height: calc(100dvh - 75px);
        z-index: 999;
    }

    /* Sidebar — full screen on mobile */
    .wa-sidebar {
        width: 100%;
        min-width: unset;
        position: absolute;
        inset: 0;
        z-index: 10;
        transform: translateX(0);
        transition: transform .3s ease;
    }
    .wa-sidebar.slide-left {
        transform: translateX(-100%);
    }

    /* Panel — full screen, hidden right initially */
    .wa-panel {
        position: absolute;
        inset: 0;
        z-index: 11;
        transform: translateX(100%);
        transition: transform .3s ease;
    }
    .wa-panel.slide-in {
        transform: translateX(0);
    }

    /* Sidebar header mobile tweaks */
    .wa-sidebar-hdr { 
        padding: 12px 16px; 
        background: rgba(13,13,13,0.95);
        backdrop-filter: blur(10px);
    }
    .wa-sidebar-hdr h2 { font-size: 14px; margin-bottom: 10px; color: #fff; font-weight: 800; }
    .wa-item { padding: 13px 14px; }
    .wa-subj { max-width: 200px; font-size: 14px; }

    /* Mobile top bar for panel */
    .wa-mobile-topbar {
        display: flex !important;
    }
}
@media (min-width: 992px) {
    .wa-mobile-topbar { display: none !important; }
}
</style>
@endpush

@section('content')
<div class="video-background">
    <video autoplay muted loop id="myVideo">
        <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4" type="video/mp4">
    </video>
</div>

<div class="dashboard-container" style="padding: 10px 20px 0;">
    <div class="wa-wrapper">

        {{-- ══ LEFT SIDEBAR ══ --}}
        <div class="wa-sidebar" id="waSidebar">
            <div class="wa-sidebar-hdr">
                <h2><i class="fas fa-comments"></i> My Conversations</h2>
                <div class="wa-search-box">
                    <input type="text" id="waSearch" class="wa-search-input"
                           placeholder="Search ID or Subject..." onkeyup="waFilter()">
                    <i class="fas fa-search wa-search-icon"></i>
                </div>
                <button class="wa-new-btn" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                    <i class="fas fa-plus-circle"></i> New Conversation
                </button>
            </div>

            <div class="wa-list" id="waConvList">
                @forelse($supports as $support)
                    <div class="wa-item conv-item"
                         data-id="{{ $support->ticket }}"
                         data-subject="{{ strtolower($support->subject) }}"
                         data-url="{{ route('ticket.view', $support->ticket) }}"
                         onclick="waOpenChat(this)">
                        <div class="wa-avatar"><i class="fas fa-headset"></i></div>
                        <div class="wa-info">
                            <div class="wa-top">
                                <span class="wa-subj" title="{{ __($support->subject) }}">{{ __($support->subject) }}</span>
                                <span class="wa-time">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans(null, true, true) }}</span>
                            </div>
                            <div class="wa-bot">
                                <span class="wa-tid">#{{ $support->ticket }}</span>
                                @if($support->status == 0)    <span class="bwa bwa-open">Open</span>
                                @elseif($support->status == 1) <span class="bwa bwa-ans">Answered</span>
                                @elseif($support->status == 2) <span class="bwa bwa-rep">Replied</span>
                                @elseif($support->status == 3) <span class="bwa bwa-closed">Closed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="wa-empty">
                        <i class="fas fa-comment-slash"></i>
                        <p>No conversations yet.<br>Start one above!</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ══ RIGHT PANEL ══ --}}
        <div class="wa-panel" id="waPanel">

            {{-- Mobile topbar (back button) shown only on mobile --}}
            <div class="wa-mobile-topbar" id="waMobileTopbar" style="display:none;align-items:center;gap:12px;">
                <button onclick="waGoBack()" class="wa-mobile-back">
                    <i class="fas fa-arrow-left" style="font-size:13px;"></i>
                </button>
                <div style="flex:1;">
                    <div id="mobileConvTitle" style="font-size:14px;font-weight:700;color:#fff;">Conversation</div>
                    <div id="mobileConvId" style="font-size:11px;color:#888;"></div>
                </div>
                <div id="mobileActionWrap" style="display: flex; align-items: center; gap: 8px;"></div>
            </div>

            <div class="wa-loader" id="waLoader">
                <div class="wa-spinner"></div>
                <span>Opening conversation...</span>
            </div>

            <div class="wa-welcome" id="waWelcome">
                <div class="wa-welcome-ico"><i class="fas fa-comments"></i></div>
                <h3>Support Messenger</h3>
                <p>Select a conversation from the left panel to open it here.</p>
                <button class="wa-new-btn" style="width:auto;padding:9px 24px;"
                        data-bs-toggle="modal" data-bs-target="#newTicketModal">
                    <i class="fas fa-plus-circle"></i> New Conversation
                </button>
            </div>

            <div class="wa-chat-frame" id="waChatFrame" style="display:none;"></div>
        </div>

    </div>
</div>

{{-- ══ NEW TICKET MODAL ══ --}}
<div class="modal fade custom--modal" id="newTicketModal" tabindex="-1"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-paper-plane text-danger me-2"></i> @lang('New Support Request')</h5>
                <div class="btn-close-custom" data-bs-dismiss="modal"><i class="fas fa-times"></i></div>
            </div>
            <div class="modal-body">
                <form id="newTicketForm" action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">@lang('Your Name')</label>
                            <input type="text" name="name" class="form-control-custom"
                                   value="{{ auth()->user()->fullname }}" readonly>
                            <div class="invalid-feedback" id="error-name"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">@lang('Email')</label>
                            <input type="email" name="email" class="form-control-custom"
                                   value="{{ auth()->user()->email }}" readonly>
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Subject')</label>
                            <input type="text" name="subject" class="form-control-custom"
                                   placeholder="@lang('What is this about?')" required>
                            <div class="invalid-feedback" id="error-subject"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Priority')</label>
                            <select name="priority" class="select-custom">
                                <option value="1">@lang('Low')</option>
                                <option value="2">@lang('Medium')</option>
                                <option value="3" selected>@lang('High')</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" class="form-control-custom" rows="3"
                                      placeholder="@lang('Explain your issue...')" required></textarea>
                            <div class="invalid-feedback" id="error-message"></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">@lang('Attachment (Optional)')</label>
                            <div class="custom-file-box">
                                <input type="file" name="attachments[]" id="modalFile"
                                       class="file-input-hidden" onchange="updateModalFileName(this)">
                                <div class="file-label-red"><i class="fas fa-paperclip"></i> Choose</div>
                                <span id="modalFileName" style="color:#888;font-size:12px;">No file chosen</span>
                            </div>
                            <div class="invalid-feedback" id="error-attachments"></div>
                        </div>
                        <div class="col-12 mt-1">
                            <button type="submit" class="submit-btn" id="newTicketSubmitBtn">
                                <i class="fas fa-rocket me-2"></i> @lang('Send Request')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-confirmation-modal is_custom="yes" />
@endsection

@push('script')
<script>
(function($) {
    "use strict";

    window.updateModalFileName = function(input) {
        $('#modalFileName').text(input.files[0] ? input.files[0].name : 'No file chosen');
    };

    // Detect mobile
    function isMobile() { return window.innerWidth < 992; }

    // Open chat in right panel via AJAX
    window.waOpenChat = function(el) {
        const url   = $(el).data('url');
        const subj  = $(el).find('.wa-subj').text().trim();
        const tid   = $(el).data('id');

        $('.conv-item').removeClass('active');
        $(el).addClass('active');

        if (window.msPollInterval) { clearInterval(window.msPollInterval); window.msPollInterval = null; }
        
        $('#waWelcome').hide();
        $('#waChatFrame').hide().empty();
        $('#waLoader').addClass('show');

        // Mobile: slide panel in
        if (isMobile()) {
            $('#waMobileTopbar').css('display','flex');
            $('#mobileConvTitle').text(subj);
            $('#mobileConvId').text('#' + tid);
            $('#waSidebar').addClass('slide-left');
            $('#waPanel').addClass('slide-in');
        }

        $.ajax({
            url: url,
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                const $res = $($.parseHTML(response, document, true));
                let $content = $res.find('.messenger-view-wrapper');
                if (!$content.length) $content = $res.filter('.messenger-view-wrapper');

                $('#waLoader').removeClass('show');

                if ($content.length) {
                    $('#waChatFrame').empty().append($content.html()).fadeIn(300);
                    
                    // Handle mobile topbar actions
                    const $closeBtn = $res.find('.ms-close-conv-btn');
                    const $statusBadge = $res.find('.badge-ms');
                    $('#mobileActionWrap').empty();
                    if ($statusBadge.length) $('#mobileActionWrap').append($statusBadge.clone());
                    if ($closeBtn.length) $('#mobileActionWrap').append($closeBtn.clone());

                    setTimeout(function() {
                        if (typeof window.initMessenger === 'function') window.initMessenger();
                    }, 100);
                    window.history.pushState({ path: url }, '', url);
                } else {
                    console.error('Messenger content not found in response');
                    $('#waLoader').removeClass('show');
                }
            },
            error: function() {
                window.location.href = url;
            }
        });
    };

    // Mobile back button — go back to sidebar
    window.waGoBack = function() {
        $('#waPanel').removeClass('slide-in');
        $('#waSidebar').removeClass('slide-left');
        $('#waMobileTopbar').hide();
        $('#mobileActionWrap').empty();
        $('#waChatFrame').hide().empty();
        $('#waWelcome').show();
        $('.conv-item').removeClass('active');
        if (window.msPollInterval) clearInterval(window.msPollInterval);
        window.history.pushState({}, '', '{{ route("ticket.index") }}');
    };

    // Search filter
    window.waFilter = function() {
        const q = $('#waSearch').val().toLowerCase();
        $('.conv-item').each(function() {
            const id = $(this).data('id').toString();
            const sub = $(this).data('subject');
            $(this).toggle(id.includes(q) || sub.includes(q));
        });
    };

    // AJAX New Ticket
    $('#newTicketForm').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#newTicketSubmitBtn');
        const orig = btn.html();
        $('.invalid-feedback').text('').hide();
        $('.form-control-custom,.select-custom').removeClass('is-invalid');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Sending...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    $('#newTicketModal').modal('hide');
                    $('#newTicketForm')[0].reset();
                    
                    // Refresh conversation list after a delay to ensure DB commit
                    setTimeout(() => {
                        const refreshUrl = '{{ route("ticket.index") }}';
                        $.get(refreshUrl + '?v=' + Date.now(), function(data) {
                            const $data = $(data);
                            const newList = $data.find('#waConvList').html() || $data.filter('#waConvList').html();
                            if (newList) {
                                $('#waConvList').html(newList);
                                const $newItem = $('.conv-item[data-id="' + res.ticket_id + '"]');
                                if ($newItem.length) {
                                    waOpenChat($newItem[0]);
                                } else {
                                    // Fallback if not found in list (maybe on another page, but unlikely for new)
                                    window.location.reload(); 
                                }
                            }
                        });
                    }, 800);
                } else { window.location.reload(); }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(orig);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(k => {
                        $('#error-' + k).text(errors[k][0]).show();
                        $('[name="' + k + '"]').addClass('is-invalid');
                    });
                } else { notify('error', 'Something went wrong.'); }
            }
        });
    });

    // Auto-open conversation from ?open=TICKET_ID (when redirected from view page)
    $(document).ready(function() {
        const params = new URLSearchParams(window.location.search);
        const openId = params.get('open');
        if (openId) {
            window.history.replaceState({}, '', '{{ route("ticket.index") }}');
            const $item = $('.conv-item[data-id="' + openId + '"]');
            if ($item.length) {
                setTimeout(function() { waOpenChat($item[0]); }, 200);
            }
        }
    });

    window.onpopstate = function() { window.location.reload(); };

})(jQuery);
</script>
@endpush
