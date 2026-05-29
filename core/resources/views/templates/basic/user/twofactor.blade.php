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

        /* Header */
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
        }

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

        /* QR Code & Key Styling */
        .qr-section {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 16px;
            border: 1px solid var(--ms-border);
            margin-bottom: 25px;
        }

        .qr-img {
            background: #fff;
            padding: 10px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 15px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }

        .qr-img img {
            width: 160px;
            height: 160px;
        }

        /* Inputs */
        .fg {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        /* App Download Buttons */
        .app-download-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 15px;
        }

        .app-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--ms-border);
            padding: 10px 15px;
            border-radius: 12px;
            text-decoration: none;
            transition: var(--transition);
        }

        .app-btn:hover {
            background: rgba(255, 0, 0, 0.1);
            border-color: rgba(255, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        .app-btn i {
            font-size: 24px;
            color: #fff;
        }

        .app-btn-text {
            text-align: left;
        }

        .app-btn-text span {
            display: block;
            font-size: 10px;
            color: var(--ms-text-soft);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .app-btn-text strong {
            display: block;
            font-size: 14px;
            color: #fff;
            font-weight: 600;
        }

        .fl {
            font-size: 12px;
            font-weight: 700;
            color: var(--ms-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .fi {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 0, 0, 0.12);
            border-radius: 12px;
            padding: 14px 16px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            outline: none;
            transition: var(--transition);
        }

        .fi:focus {
            border-color: var(--ms-primary);
            background: rgba(255, 0, 0, 0.04);
        }

        .copy-btn {
            position: absolute;
            right: 5px;
            background: var(--ms-gradient);
            border: none;
            color: #fff;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            transition: var(--transition);
        }

        .sb-btn {
            background: var(--ms-gradient);
            color: #fff;
            border: none;
            padding: 15px;
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
        }

        .sb-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 0, 0, 0.6);
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
            color: var(--ms-primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .sb-txt h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin: 0 0 3px;
        }

        .sb-txt p {
            font-size: 11.5px;
            color: var(--ms-text-soft);
            line-height: 1.4;
            margin: 0;
        }

        /* RESPONSIVE */
        @media (max-width: 1400px) {
            .compact-grid {
                grid-template-columns: 1fr;
            }

            body {
                overflow: auto;
            }

            .viewport-wrapper {
                height: auto;
                margin-left: 280px;
                padding: 25px;
            }
        }

        @media (max-width: 1200px) {
            .viewport-wrapper {
                margin-left: 0;
                padding: 70px 10px 15px 10px;
            }

            .dashboard-header {
                padding: 15px 12px;
                margin-bottom: 8px;
            }
        }

        @media (max-width: 576px) {
            .viewport-wrapper {
                padding-top: 85px;
            }

            .main-card {
                padding: 20px 15px;
            }
        }
    </style>

    <div class="viewport-wrapper">

        <div class="video-background">
            <video autoplay muted loop id="bgVideo">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4"
                    type="video/mp4">
            </video>
        </div>

        <div class="dashboard-header">
            <div class="greeting-text">
                <h1>Two-Factor Auth</h1>
                <p>Enhance your account security by adding an extra layer of protection using Google Authenticator.</p>
            </div>
        </div>

        <div class="compact-grid">

            <div class="main-card">
                @if (!auth()->user()->ts)
                    <div class="qr-section">
                        <div class="qr-img">
                            <img src="{{ $qrCodeUrl }}" alt="QR Code">
                        </div>
                        <p style="font-size: 13px; color: var(--ms-text-soft);">Scan this QR code with your Authenticator App
                        </p>
                    </div>

                    <div class="fg">
                        <label class="fl">Setup Key</label>
                        <div class="input-group-custom">
                            <input type="text" value="{{ $secret }}" class="fi referralURL" readonly>
                            <button type="button" class="copy-btn" id="copyBoard">COPY KEY</button>
                        </div>
                    </div>

                    <form action="{{ route('user.twofactor.enable') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key" value="{{ $secret }}">
                        <div class="fg">
                            <label class="fl">Verification Code</label>
                            <input type="text" name="code" class="fi" required placeholder="Enter 6-digit OTP">
                        </div>
                        <button type="submit" class="sb-btn w-100">Enable 2FA Protection</button>
                    </form>
                @else
                    <div style="text-align: center; padding: 30px 0;">
                        <i class="material-icons"
                            style="font-size: 80px; color: #00ff00; margin-bottom: 20px;">verified_user</i>
                        <h2 style="color: #fff; margin-bottom: 10px;">2FA is Active</h2>
                        <p style="color: var(--ms-text-soft); margin-bottom: 30px;">Your account is currently protected with
                            two-factor authentication.</p>
                    </div>

                    <form action="{{ route('user.twofactor.disable') }}" method="POST">
                        @csrf
                        <div class="fg">
                            <label class="fl">Enter OTP to Disable</label>
                            <input type="text" name="code" class="fi" required placeholder="Enter 6-digit OTP">
                        </div>
                        <button type="submit" class="sb-btn w-100" style="background: #222; box-shadow: none;">Disable
                            Security</button>
                    </form>
                @endif
            </div>

            <div class="side-panel">
                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">smartphone</i></div>
                    <div class="sb-txt">
                        <h4>Mobile Authentication</h4>
                        <p>Generate secure, time-based codes even without an internet connection.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">security_update_good</i></div>
                    <div class="sb-txt">
                        <h4>Unbreakable Defense</h4>
                        <p>Prevents unauthorized access even if your password is compromised.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">cloud_download</i></div>
                    <div class="sb-txt">
                        <h4>Backup Key</h4>
                        <p>Always save your setup key in a secure place to regain access if you lose your phone.</p>
                    </div>
                </div>

                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--ms-border);">
                    <h5 style="font-size: 14px; color: #fff; margin-bottom: 15px;">Download Authenticator:</h5>
                    <div class="app-download-group">
                        <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                            target="_blank" class="app-btn">
                            <i class="fab fa-google-play"></i>
                            <div class="app-btn-text">
                                <span>Get it on</span>
                                <strong>Google Play</strong>
                            </div>
                        </a>
                        <a href="https://apps.apple.com/us/app/google-authenticator/id388497605" target="_blank"
                            class="app-btn">
                            <i class="fab fa-apple"></i>
                            <div class="app-btn-text">
                                <span>Download on the</span>
                                <strong>App Store</strong>
                            </div>
                        </a>
                    </div>
                </div>

                <div
                    style="margin-top: 25px; padding: 15px; background: rgba(255,0,0,0.05); border: 1px dashed rgba(255,0,0,0.2); border-radius: 12px;">
                    <h5
                        style="font-size: 13px; color: #fff; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-info-circle" style="color: var(--light-red);"></i> Setup Steps:
                    </h5>
                    <ol
                        style="font-size: 11.5px; color: var(--ms-text-soft); padding-left: 15px; line-height: 1.6; margin: 0;">
                        <li>Install Google Authenticator from Play Store or App Store.</li>
                        <li>Open the app and scan the QR code shown here.</li>
                        <li>Enter the 6-digit code generated by the app to verify.</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('#copyBoard').click(function () {
                var copyText = document.querySelector(".referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");

                const btn = $(this);
                const originalText = btn.text();
                btn.text('COPIED!');
                btn.css('background', '#00ff00');

                setTimeout(() => {
                    btn.text(originalText);
                    btn.css('background', '');
                }, 2000);
            });
        })(jQuery);
    </script>
@endpush