@extends($activeTemplate . 'layouts.master')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --sidebar-black: #0d0d0d;
            --card-black: #111111;
            --hover-black: #1a1a1a;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --hover-red: #ff1a1a;
            --border-red: rgba(255, 0, 0, 0.2);
            --text-white: #ffffff;
            --text-light: #e6e6e6;
            --text-muted: #999999;
            --danger-red: #ff3333;
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.5);
            --glow-red: 0 0 15px rgba(255, 0, 0, 0.5);
            --transition: all 0.3s ease;
        }

        body {
            overflow: hidden !important;
            background: #000 !important;
        }

        /* Reduced blur for better visibility of dashboard design */
        .sidebar-container, 
        .user-header,
        .header-section,
        .breadcrumb-section,
        .body-wrapper,
        .footer-area,
        .dashboard-preview {
            filter: blur(5px) brightness(0.6) !important;
            pointer-events: none !important;
            user-select: none !important;
        }

        .dashboard-preview {
            position: fixed;
            top: 0;
            left: var(--sidebar-width, 280px);
            right: 0;
            bottom: 0;
            padding: 30px;
            z-index: 1;
            overflow: hidden;
        }

        .mock-header {
            margin-bottom: 30px;
        }

        .mock-welcome {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 10px;
        }

        .mock-referral {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 0, 0, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .mock-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .mock-stat-card {
            background: #111111;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .mock-stat-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient-red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .mock-stat-info h4 {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 5px;
        }

        .mock-stat-info p {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-white);
        }

        .mock-large-card {
            background: #111111;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            height: 400px;
            padding: 25px;
        }

        .verification-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            z-index: 99999;
        }

        .verification-card {
            width: 100%;
            max-width: 550px;
            background: rgba(17, 17, 17, 0.98);
            border-radius: 30px;
            border: 1px solid rgba(255, 0, 0, 0.15);
            padding: 35px;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.9), 0 0 50px rgba(255, 0, 0, 0.05);
            position: relative;
            z-index: 100000;
            backdrop-filter: blur(25px);
            animation: modalIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            overflow: hidden;
        }

        .verification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-red);
            box-shadow: 0 2px 15px rgba(255, 0, 0, 0.5);
        }

        .verification-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: var(--gradient-red);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: var(--shadow-red);
            animation: pulseIcon 2s infinite;
        }

        .icon-box i {
            font-size: 35px;
            color: white;
        }

        .verification-title {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }

        .verification-desc {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        /* OTP Code Styles Override */
        .verification-code {
            position: relative;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
            background: transparent !important;
        }

        .verification-code input {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            opacity: 0 !important;
            z-index: 10 !important;
            cursor: pointer !important;
        }

        .verification-label {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
            display: block;
            text-align: center;
        }

        /* Verification boxes styling */
        .boxes {
            display: flex !important;
            justify-content: center !important;
            gap: 12px !important;
            margin-top: 15px !important;
        }

        .boxes span {
            width: 45px !important;
            height: 55px !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid var(--border-red) !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            color: var(--text-white) !important;
            transition: var(--transition) !important;
        }

        .boxes span.active {
            border-color: var(--light-red) !important;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.2) !important;
            background: rgba(255, 0, 0, 0.05) !important;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-red);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.4);
            filter: brightness(1.1);
        }

        .logout-wrapper {
            margin-top: 25px;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 20px;
        }

        .logout-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
        }

        .logout-link:hover {
            color: var(--light-red);
            background: rgba(255, 0, 0, 0.05);
        }

        .security-footer {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .security-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 16px;
            padding: 15px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            height: 100%;
        }

        .security-card:hover {
            background: rgba(255, 0, 0, 0.04);
            border-color: rgba(255, 0, 0, 0.15);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .security-footer-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--light-red);
            font-size: 14px;
        }

        .security-footer-text h4 {
            color: var(--text-white);
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .security-footer-text p {
            color: var(--text-muted);
            font-size: 9.5px;
            line-height: 1.4;
            margin: 0;
            font-weight: 400;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes pulseIcon {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.4); }
            70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(255, 0, 0, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
        }

        @media (max-width: 576px) {
            .verification-card {
                padding: 30px 20px;
            }
            .verification-title {
                font-size: 24px;
            }
            .boxes span {
                width: 40px !important;
                height: 50px !important;
                font-size: 18px !important;
            }
            .security-footer {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Dashboard Preview Background -->
    <div class="dashboard-preview d-none d-lg-block">
        <div class="mock-header">
            <h2 class="mock-welcome">Welcome Back, <span style="color: var(--light-red)">{{ auth()->user()->firstname }}</span></h2>
            <p style="color: var(--text-muted); font-size: 14px;"><i class="fas fa-user-shield"></i> UID: {{ auth()->user()->username }} | <span style="color: #00ff00">● Online</span></p>
        </div>

        <div class="mock-referral">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="color: var(--text-muted); font-size: 14px;"><i class="fas fa-link"></i> Your Referral Link</div>
                <div style="background: var(--deep-red); padding: 5px 15px; border-radius: 8px; font-size: 12px;">Copy</div>
            </div>
            <div style="margin-top: 10px; color: var(--text-white); opacity: 0.5;">{{ route('home') }}?reference={{ auth()->user()->username }}</div>
        </div>

        <div class="mock-grid">
            <div class="mock-stat-card">
                <div class="mock-stat-icon"><i class="fas fa-wallet"></i></div>
                <div class="mock-stat-info">
                    <h4>Current Balance</h4>
                    <p>${{ showAmount(auth()->user()->balance) }}</p>
                </div>
            </div>
            <div class="mock-stat-card">
                <div class="mock-stat-icon"><i class="fas fa-university"></i></div>
                <div class="mock-stat-info">
                    <h4>Total Deposit</h4>
                    <p>$0.00</p>
                </div>
            </div>
            <div class="mock-stat-card">
                <div class="mock-stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <div class="mock-stat-info">
                    <h4>Total Withdraw</h4>
                    <p>$0.00</p>
                </div>
            </div>
            <div class="mock-stat-card">
                <div class="mock-stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="mock-stat-info">
                    <h4>Daily Income</h4>
                    <p>$0.00</p>
                </div>
            </div>
        </div>

        <div class="mock-large-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <div style="font-weight: 600;"><i class="fas fa-chart-pie"></i> Financial Overview</div>
                <div style="color: var(--light-red);"><i class="fas fa-sync-alt"></i></div>
            </div>
            <div style="display: flex; flex-direction: column; gap: 20px; opacity: 0.3;">
                <div style="height: 40px; background: rgba(255,255,255,0.05); border-radius: 10px;"></div>
                <div style="height: 40px; background: rgba(255,255,255,0.05); border-radius: 10px;"></div>
                <div style="height: 40px; background: rgba(255,255,255,0.05); border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <div class="verification-wrapper">
        <div class="verification-card">
            <div class="verification-header">
                <div class="icon-box">
                    <i class="material-icons">security</i>
                </div>
                <h1 class="verification-title">@lang('2FA Verification')</h1>
                <p class="verification-desc">
                    @lang('Please enter the 6-digit code from your authenticator app to complete the login process.')
                </p>
            </div>

            <div class="verification-body-layout">
                <form action="{{ route('user.go2fa.verify') }}" method="POST" class="submit-form">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="verification-label">@lang('Authentication Code')</label>
                        <div class="verification-code">
                            <input type="text" name="code" id="verification-code" class="form-control"
                                   required autocomplete="off" inputmode="numeric" pattern="\d*">
                            <div class="boxes">
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                                <span>-</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>@lang('Verify & Access Account')</span>
                        <i class="fas fa-shield-check"></i>
                    </button>
                </form>
            </div>

            <div class="logout-wrapper">
                <a href="{{ route('user.logout') }}" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>@lang('Logout & Return Home')</span>
                </a>
            </div>

            <!-- Enhanced Security Cards footer -->
            <div class="security-footer">
                <div class="security-card">
                    <div class="security-footer-icon"><i class="fas fa-user-shield"></i></div>
                    <div class="security-footer-text">
                        <h4>Protection</h4>
                        <p>Advanced 2FA security.</p>
                    </div>
                </div>
                <div class="security-card">
                    <div class="security-footer-icon"><i class="fas fa-lock"></i></div>
                    <div class="security-footer-text">
                        <h4>Encryption</h4>
                        <p>Total data privacy.</p>
                    </div>
                </div>
                <div class="security-card">
                    <div class="security-footer-icon"><i class="fas fa-bell"></i></div>
                    <div class="security-footer-text">
                        <h4>Monitoring</h4>
                        <p>Real-time safety.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($){
        "use strict";
        
        // Auto-focus input when clicking on the boxes
        $('.boxes').on('click', function() {
            $('#verification-code').focus();
        });

        $('#verification-code').on('input', function () {
            let val = $(this).val().replace(/\D/g, '');
            $(this).val(val);

            if (val.length >= 6) {
                val = val.substring(0, 6);
                $('.submit-form').find('button[type=submit]').html('<i class="fas fa-spinner fa-spin"></i> Verifying...');
                $('.submit-form').submit();
            }

            // Update the displayed boxes
            $('.boxes span').each(function (index) {
                $(this).html(val[index] || '-');
                if (index < val.length) {
                    $(this).addClass('active');
                } else {
                    $(this).removeClass('active');
                }
            });
        });

        // Focus input on page load
        $('#verification-code').focus();

        // Prevent closing or interacting with background
        $(document).on('keydown', function(e) {
            if (e.key === "Escape") {
                e.preventDefault();
            }
        });
    })(jQuery);
</script>
@endpush
