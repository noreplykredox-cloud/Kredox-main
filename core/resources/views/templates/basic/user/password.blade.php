
@extends($activeTemplate . 'layouts.master')
@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --ms-primary: #ff0000;
            --ms-bg: #0a0a0a;
            --ms-card: #111111;
            --ms-border: rgba(255, 0, 0, 0.15);
            --ms-text: #ffffff;
            --ms-text-soft: #b0b0b0;
            --ms-muted: #666;
            --ms-gradient: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--ms-bg);
            color: var(--ms-text);
            margin: 0;
            overflow: hidden;
        }

        footer {
            display: none !important;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #bgVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.12;
        }

        /* Compact Layout Wrapper */
        .viewport-wrapper {
            margin-left: 280px;
            height: 100vh;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Withdraw History Style Header */
        .dashboard-header {
            background: #000;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            padding: 20px 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .inner-header-box {
            padding: 9px 7px;
        }

        .greeting-text h1 {
            color: var(--ms-text);
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .greeting-text p {
            color: var(--ms-text-soft);
            font-size: 14px;
            margin: 0;
            font-weight: 500;
            max-width: 100%;
        }

        /* Main Grid */
        .compact-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 25px;
            flex: 1;
            min-height: 0;
        }

        .main-card {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--ms-primary) transparent;
        }

        .main-card::-webkit-scrollbar { width: 3px; }
        .main-card::-webkit-scrollbar-thumb { background: var(--ms-primary); }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--ms-gradient);
            border-radius: 24px 24px 0 0;
        }

        /* Side Panel */
        .side-panel {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sb-feat {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .sb-ico {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 0, 0, 0.08);
            border: 1px solid rgba(255, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--ms-primary);
            font-size: 20px;
        }

        .sb-txt h4 {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 3px;
            color: #fff;
        }

        .sb-txt p {
            font-size: 11.5px;
            color: var(--ms-text-soft);
            line-height: 1.4;
            margin: 0;
        }

        /* Inputs */
        .fg {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .fl {
            font-size: 12px;
            font-weight: 700;
            color: var(--ms-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-left: 2px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            color: var(--ms-muted);
            font-size: 20px;
            transition: var(--transition);
        }

        .fi {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 0, 0, 0.12);
            border-radius: 12px;
            padding: 14px 16px 14px 45px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            transition: var(--transition);
            outline: none;
        }

        .fi:focus {
            border-color: var(--ms-primary);
            background: rgba(255, 0, 0, 0.04);
        }

        .fi:focus + i {
            color: var(--ms-primary);
        }

        .sb-btn {
            background: var(--ms-gradient);
            color: #fff;
            border: none;
            padding: 15px 45px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .sb-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 0, 0, 0.6);
        }

        /* Password Strength Popup */
        .input-popup {
            background: rgba(0, 0, 0, 0.3);
            padding: 12px 15px;
            border-radius: 12px;
            margin-top: 10px;
            border: 1px solid var(--ms-border);
        }
        .input-popup p {
            font-size: 11px;
            color: var(--ms-muted);
            margin: 4px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }
        .input-popup p.error { color: #ff4444; }
        .input-popup p.valid { color: #00ff00; }
        .input-popup p::before { content: 'close'; font-family: 'Material Icons'; font-size: 14px; }
        .input-popup p.valid::before { content: 'check_circle'; }

        /* FAQ / Tips */
        .q-title {
            font-size: 16px;
            font-weight: 800;
            margin: 20px 0 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .q-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--ms-border);
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .q-head {
            padding: 10px 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
        }

        .q-head i {
            color: var(--ms-primary);
            font-size: 18px;
        }

        .q-body {
            padding: 0 15px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
            font-size: 12px;
            color: var(--ms-text-soft);
        }

        .q-card.active .q-body {
            padding: 5px 15px 15px;
            max-height: 100px;
        }

        /* RESPONSIVE */
        @media (max-width: 1400px) {
            .compact-grid { grid-template-columns: 1fr; }
            body { overflow: auto; }
            .viewport-wrapper { height: auto; margin-left: 280px; padding: 25px; }
        }

        @media (max-width: 1200px) {
            .viewport-wrapper { margin-left: 0; padding: 70px 10px 15px 10px; }
            body { overflow: auto; }
            .dashboard-header { padding: 15px 12px; margin-bottom: 8px; }
            .greeting-text h1 { font-size: 22px; }
            .greeting-text p { font-size: 13px; }
        }

        @media (max-width: 576px) {
            .viewport-wrapper { padding-top: 85px; padding-left: 12px; padding-right: 12px; }
            .dashboard-header { padding: 18px 12px; }
            .greeting-text h1 { font-size: 20px; }
            .main-card { padding: 20px 15px; }
        }
    </style>

    <div class="viewport-wrapper">

        <div class="video-background">
            <video autoplay muted loop id="bgVideo">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4" type="video/mp4">
            </video>
        </div>

        {{-- Header --}}
        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>Security Credentials</h1>
                    <p>Protect your account with a strong password and stay updated with the latest security protocols for a safe experience.</p>
                </div>
            </div>
        </div>

        <div class="compact-grid">

            <div class="main-card">
                <form action="" method="post" class="password-change-form verify-gcaptcha">
                    @csrf
                    
                    <div class="fg">
                        <label class="fl">Current Password</label>
                        <div class="input-group-custom">
                            <i class="material-icons">vpn_key</i>
                            <input type="password" name="current_password" class="fi" required placeholder="Enter current password">
                        </div>
                    </div>

                    <div class="fg">
                        <label class="fl">New Password</label>
                        <div class="input-group-custom">
                            <i class="material-icons">lock</i>
                            <input type="password" name="password" class="fi" required placeholder="Enter new password">
                        </div>
                        @if($general->secure_password)
                            <div class="input-popup">
                                <p class="error lower">@lang('1 small letter minimum')</p>
                                <p class="error capital">@lang('1 capital letter minimum')</p>
                                <p class="error number">@lang('1 number minimum')</p>
                                <p class="error special">@lang('1 special character minimum')</p>
                                <p class="error minimum">@lang('6 character password')</p>
                            </div>
                        @endif
                    </div>

                    <div class="fg">
                        <label class="fl">Confirm New Password</label>
                        <div class="input-group-custom">
                            <i class="material-icons">verified_user</i>
                            <input type="password" name="password_confirmation" class="fi" required placeholder="Repeat new password">
                        </div>
                    </div>

                    <button type="submit" class="sb-btn">
                        Update Password
                        <i class="material-icons">security</i>
                    </button>
                </form>
            </div>

            <div class="side-panel">
                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">verified</i></div>
                    <div class="sb-txt">
                        <h4>Identity Protection</h4>
                        <p>We use military-grade hashing to secure your password data.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">history</i></div>
                    <div class="sb-txt">
                        <h4>Security Audit</h4>
                        <p>Track your recent login activities to identify any suspicious behavior.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">phonelink_lock</i></div>
                    <div class="sb-txt">
                        <h4>2FA Ready</h4>
                        <p>Highly recommended: Enable 2FA for an unbreakable shield.</p>
                    </div>
                </div>

                <div class="q-title"><i class="material-icons">tips_and_updates</i> Security Tips</div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Avoid Common Words <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Don't use birthdays, names, or simple words like "password" or "123456".</div>
                </div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Unique Password <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Never use the same password you use for your email or other financial apps.</div>
                </div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Change Regularly <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Changing your password every 90 days significantly reduces breach risks.</div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            @if($general->secure_password)
            $('input[name=password]').on('input',function(){
                secure_password($(this));
            });
            @endif
        })(jQuery);
    </script>
@endpush