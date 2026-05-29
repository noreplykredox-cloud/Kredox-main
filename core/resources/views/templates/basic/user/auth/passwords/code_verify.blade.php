<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $general->siteName(__($pageTitle)) }}</title>
    
    @include('partials.seo')
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ========== Dark Black & Red Theme ========== */
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
            --success-green: #00ff00;
            --danger-red: #ff3333;
            --warning-orange: #ff9900;
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --gradient-black: linear-gradient(135deg, var(--dark-black) 0%, var(--card-black) 100%);
            --gradient-card: linear-gradient(145deg, #111111 0%, #1a1a1a 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.5);
            --transition: all 0.3s ease;
            --glow-red: 0 0 15px rgba(255, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--dark-black);
            color: var(--text-white);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(139, 0, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 0, 0, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        /* Floating Particles */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            background: var(--light-red);
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }

        /* Main Container */
        .verification-container {
            width: 100%;
            max-width: 520px;
            padding: 20px;
            animation: fadeIn 0.8s ease;
        }

        /* Back Button */
        .back-btn {
            position: absolute;
            top: 30px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            padding: 10px 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-red);
            z-index: 100;
        }

        .back-btn:hover {
            color: var(--light-red);
            background: rgba(255, 0, 0, 0.1);
            transform: translateX(-5px);
        }

        .back-btn i {
            font-size: 16px;
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
            animation: slideInDown 0.5s ease;
        }

        .logo {
            display: inline-block;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo img {
            max-width: 180px;
            height: auto;
            filter: brightness(1.2) drop-shadow(0 0 15px rgba(255, 0, 0, 0.3));
        }

        .brand-tagline {
            color: var(--text-muted);
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* Verification Card */
        .verification-card {
            background: var(--gradient-card);
            border-radius: 20px;
            border: 1px solid var(--border-red);
            padding: 40px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.5s ease 0.2s backwards;
        }

        .verification-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
        }

        .verification-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 0, 0, 0.1) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        /* Header */
        .verification-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .verification-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--gradient-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            box-shadow: var(--shadow-red);
            animation: pulse 2s infinite;
        }

        .verification-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .verification-subtitle {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* Email Display */
        .email-display {
            background: rgba(255, 0, 0, 0.1);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            margin: 25px 0;
            border: 1px solid var(--border-red);
        }

        .email-label {
            color: var(--text-muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .email-value {
            color: var(--text-light);
            font-size: 16px;
            font-weight: 600;
            word-break: break-all;
        }

        /* OTP Input Container */
        .otp-container {
            margin: 40px 0 30px;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .otp-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid var(--border-red);
            border-radius: 12px;
            color: var(--text-white);
            transition: var(--transition);
        }

        .otp-input:focus {
            outline: none;
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .otp-input.filled {
            border-color: var(--light-red);
            box-shadow: var(--glow-red);
        }

        /* Timer */
        .timer-container {
            text-align: center;
            margin: 25px 0;
        }

        .timer {
            display: inline-block;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 600;
            color: var(--light-red);
            border: 1px solid var(--border-red);
        }

        .timer.expired {
            color: var(--danger-red);
        }

        /* Form Styles */
        .verification-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        /* Button */
        .verify-btn {
            width: 100%;
            padding: 18px;
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .verify-btn:hover {
            background: var(--light-red);
            transform: translateY(-3px);
            box-shadow: var(--shadow-red);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .verify-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Resend Link */
        .resend-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border-red);
        }

        .resend-text {
            color: var(--text-muted);
            font-size: 15px;
        }

        .resend-btn {
            background: none;
            border: none;
            color: var(--light-red);
            font-weight: 600;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .resend-btn:hover {
            color: var(--hover-red);
            text-decoration: underline;
        }

        .resend-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Back to Login */
        .back-to-login {
            text-align: center;
            color: var(--text-muted);
            font-size: 15px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border-red);
        }

        .back-to-login a {
            color: var(--light-red);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: var(--transition);
        }

        .back-to-login a:hover {
            text-decoration: underline;
            color: var(--hover-red);
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 14px;
            border-left: 4px solid;
            animation: slideInRight 0.5s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-danger {
            background: rgba(255, 0, 0, 0.1);
            border-left-color: var(--danger-red);
            color: #ff9999;
        }

        .alert-success {
            background: rgba(0, 255, 0, 0.1);
            border-left-color: var(--success-green);
            color: #99ff99;
        }

        .alert-info {
            background: rgba(0, 100, 255, 0.1);
            border-left-color: #0066ff;
            color: #99ccff;
        }

        .invalid-feedback {
            color: var(--danger-red);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
            padding: 15px;
            background: rgba(255, 0, 0, 0.05);
            border-radius: 12px;
            border: 1px solid var(--border-red);
        }

        .security-icon {
            color: var(--light-red);
            font-size: 20px;
            animation: pulse 2s infinite;
        }

        .security-text {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: var(--shadow-red);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 25px rgba(255, 0, 0, 0.5);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(-10px) translateX(-10px);
            }
            75% {
                transform: translateY(-30px) translateX(5px);
            }
        }

        /* Ripple Effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid transparent;
            border-top-color: var(--light-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Input animation for auto-focus */
        @keyframes inputFocus {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Status Indicators */
        .status-indicator {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(13, 13, 13, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid var(--border-red);
            backdrop-filter: blur(10px);
            animation: slideInRight 0.5s ease;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--light-red);
            animation: pulse 2s infinite;
        }

        .status-text {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        /* Mobile Responsive */
        @media screen and (max-width: 768px) {
            body {
                padding: 20px;
            }

            .verification-container {
                padding: 10px;
            }

            .verification-card {
                padding: 30px 25px;
            }

            .back-btn {
                top: 20px;
                left: 20px;
                padding: 8px 15px;
                font-size: 13px;
            }

            .logo img {
                max-width: 150px;
            }

            .verification-icon {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .verification-title {
                font-size: 24px;
            }

            .otp-input {
                width: 50px;
                height: 60px;
                font-size: 24px;
            }

            .verify-btn {
                padding: 16px;
            }
        }

        @media screen and (max-width: 480px) {
            .verification-card {
                padding: 25px 20px;
            }

            .verification-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .verification-title {
                font-size: 22px;
            }

            .otp-inputs {
                gap: 10px;
            }

            .otp-input {
                width: 45px;
                height: 55px;
                font-size: 22px;
            }

            .email-value {
                font-size: 14px;
            }

            .back-btn {
                top: 15px;
                left: 15px;
                padding: 6px 12px;
                font-size: 12px;
            }

            .logo img {
                max-width: 130px;
            }
        }

        /* Digit animation */
        @keyframes digitPop {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Back Button -->
    <a href="{{ route('user.password.request') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        <span>Back</span>
    </a>

    <!-- Status Indicator -->
    <div class="status-indicator">
        <div class="status-dot"></div>
        <div class="status-text">Secure OTP Verification</div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    <div class="particles" id="particles"></div>
    <div class="verification-container">
        <div class="verification-card">
            <!-- Header -->
            <div class="verification-header">
                <div class="verification-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="verification-title">Verify Your Email</h1>
                <p class="verification-subtitle">
                    Enter the 6-digit verification code sent to your email address
                </p>
            </div>

            <!-- Email Display -->
            <div class="email-display">
                <div class="email-label">Verification sent to</div>
                <div class="email-value">{{ showEmailAddress($email) }}</div>
            </div>

            <!-- Alerts -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('user.password.verify.code') }}" class="verification-form" id="verificationForm">
                @csrf
                
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- OTP Inputs -->
                <div class="otp-container">
                    <div class="otp-inputs" id="otpContainer">
                        @for($i = 1; $i <= 6; $i++)
                        <input type="text" 
                               class="otp-input" 
                               id="digit{{ $i }}" 
                               maxlength="1" 
                               data-index="{{ $i-1 }}"
                               inputmode="numeric"
                               pattern="[0-9]"
                               required>
                        @endfor
                    </div>
                    
                    <!-- Hidden input for complete code -->
                    <input type="hidden" name="code" id="verificationCode">
                </div>

                <!-- Timer -->
                <div class="timer-container">
                    <div class="timer" id="timer">
                        Code expires in: <span id="time">02:00</span>
                    </div>
                </div>

                <button type="submit" class="verify-btn" id="verifyBtn">
                    <i class="fas fa-check-circle"></i>
                    <span id="btnText">Verify Code</span>
                </button>
            </form>

            <!-- Resend Link -->
            <div class="resend-link">
                <p class="resend-text">
                    Didn't receive the code?
                    <button type="button" class="resend-btn" id="resendBtn" disabled>
                        Resend Code <span id="resendTimer">(120s)</span>
                    </button>
                </p>
            </div>

            <!-- Back to Login -->
            <div class="back-to-login">
                Remember your password?
                <a href="{{ route('user.login') }}">Sign In</a>
            </div>

            <!-- Security Badge -->
            <div class="security-badge">
                <i class="fas fa-shield-alt security-icon"></i>
                <span class="security-text">Your verification is secured with end-to-end encryption</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create floating particles
            createParticles();

            // OTP Input Handling
            const otpInputs = document.querySelectorAll('.otp-input');
            const verificationForm = document.getElementById('verificationForm');
            const verifyBtn = document.getElementById('verifyBtn');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const resendBtn = document.getElementById('resendBtn');
            const resendTimer = document.getElementById('resendTimer');
            const verificationCode = document.getElementById('verificationCode');
            const timer = document.getElementById('timer');
            const timeSpan = document.getElementById('time');

            let timeLeft = 120; // 2 minutes in seconds
            let resendTimeLeft = 120; // 2 minutes for resend
            let timerInterval;
            let resendTimerInterval;

            // Initialize OTP inputs
            otpInputs.forEach((input, index) => {
                // Focus on first input
                if (index === 0) {
                    setTimeout(() => {
                        input.focus();
                        input.style.animation = 'inputFocus 0.5s ease';
                    }, 500);
                }

                // Input event
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        this.value = '';
                        return;
                    }

                    // If a digit is entered
                    if (value.length === 1) {
                        this.classList.add('filled');
                        this.style.animation = 'digitPop 0.3s ease';

                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        } else {
                            // If last digit, focus verify button
                            verifyBtn.focus();
                        }
                        
                        updateVerificationCode();
                    } else if (value.length === 0) {
                        this.classList.remove('filled');
                    }
                });

                // Keydown events
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                        updateVerificationCode();
                    }
                    
                    // Handle arrow keys
                    if (e.key === 'ArrowLeft' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                // Paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').slice(0, 6);
                    
                    if (/^\d+$/.test(pastedData)) {
                        otpInputs.forEach((input, idx) => {
                            if (idx < pastedData.length) {
                                input.value = pastedData[idx];
                                input.classList.add('filled');
                                input.style.animation = 'digitPop 0.3s ease';
                            }
                        });
                        
                        if (pastedData.length === 6) {
                            verifyBtn.focus();
                        } else {
                            otpInputs[pastedData.length].focus();
                        }
                        
                        updateVerificationCode();
                    }
                });
            });

            // Update verification code in hidden input
            function updateVerificationCode() {
                const code = Array.from(otpInputs).map(input => input.value).join('');
                verificationCode.value = code;
                
                // Enable/disable verify button based on complete code
                verifyBtn.disabled = code.length !== 6;
            }

            // Start timer
            function startTimer() {
                clearInterval(timerInterval);
                timeLeft = 120;
                
                timerInterval = setInterval(() => {
                    timeLeft--;
                    
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    
                    timeSpan.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    
                    if (timeLeft <= 30) {
                        timer.classList.add('expired');
                    }
                    
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timeSpan.textContent = '00:00';
                        timer.innerHTML = 'Code expired. Please request a new one.';
                        verifyBtn.disabled = true;
                    }
                }, 1000);
            }

            // Start resend timer
            function startResendTimer() {
                clearInterval(resendTimerInterval);
                resendTimeLeft = 120;
                resendBtn.disabled = true;
                
                resendTimerInterval = setInterval(() => {
                    resendTimeLeft--;
                    
                    const minutes = Math.floor(resendTimeLeft / 60);
                    const seconds = resendTimeLeft % 60;
                    
                    resendTimer.textContent = `(${minutes}:${seconds.toString().padStart(2, '0')})`;
                    
                    if (resendTimeLeft <= 0) {
                        clearInterval(resendTimerInterval);
                        resendBtn.disabled = false;
                        resendTimer.textContent = '';
                    }
                }, 1000);
            }

            // Initialize timers
            startTimer();
            startResendTimer();

            // Form submission handling
            if (verificationForm && verifyBtn) {
                verificationForm.addEventListener('submit', function(e) {
                    const code = verificationCode.value;
                    
                    if (code.length !== 6) {
                        e.preventDefault();
                        shakeOTPInputs();
                        return;
                    }

                    if (timeLeft <= 0) {
                        e.preventDefault();
                        showAlert('Code has expired. Please request a new one.', 'danger');
                        return;
                    }

                    // Show loading overlay
                    loadingOverlay.classList.add('active');
                    
                    // Update button text
                    verifyBtn.disabled = true;
                    btnText.innerHTML = '<span class="spinner"></span> Verifying...';
                    
                    // Simulate minimum loading time for better UX
                    setTimeout(() => {
                        if (!verificationForm.checkValidity()) {
                            verifyBtn.disabled = false;
                            btnText.textContent = 'Verify Code';
                            loadingOverlay.classList.remove('active');
                        }
                    }, 1500);
                });
            }

            // Resend button handler
            resendBtn.addEventListener('click', function() {
                if (this.disabled) return;
                
                // Show loading
                loadingOverlay.classList.add('active');
                
                // Reset OTP inputs
                otpInputs.forEach(input => {
                    input.value = '';
                    input.classList.remove('filled');
                });
                verificationCode.value = '';
                verifyBtn.disabled = true;
                
                // Reset and restart timers
                clearInterval(timerInterval);
                clearInterval(resendTimerInterval);
                
                timer.classList.remove('expired');
                timer.innerHTML = 'Code expires in: <span id="time">02:00</span>';
                timeSpan = document.getElementById('time');
                
                // Restart timers
                startTimer();
                startResendTimer();
                
                // Focus first input
                otpInputs[0].focus();
                
                // Simulate API call
                setTimeout(() => {
                    loadingOverlay.classList.remove('active');
                    showAlert('A new verification code has been sent to your email.', 'success');
                }, 2000);
            });

            // Create ripple effect for button
            verifyBtn.addEventListener('click', function(e) {
                createRippleEffect(this, e);
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'all 0.5s ease';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && verificationForm && verificationForm.checkValidity()) {
                    if (!verifyBtn.disabled) {
                        verifyBtn.click();
                    }
                }
                
                // Escape to go back
                if (e.key === 'Escape') {
                    window.history.back();
                }
            });

            // Create particles function
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = 15;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    // Random properties
                    const size = Math.random() * 4 + 2;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const duration = Math.random() * 15 + 10;
                    const delay = Math.random() * 5;
                    
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.left = `${posX}%`;
                    particle.style.top = `${posY}%`;
                    particle.style.animationDuration = `${duration}s`;
                    particle.style.animationDelay = `${delay}s`;
                    
                    particlesContainer.appendChild(particle);
                }
            }

            // Ripple effect function
            function createRippleEffect(button, event = null) {
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                
                const rect = button.getBoundingClientRect();
                let x, y;
                
                if (event) {
                    x = event.clientX - rect.left;
                    y = event.clientY - rect.top;
                } else {
                    x = rect.width / 2;
                    y = rect.height / 2;
                }
                
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                button.style.position = 'relative';
                button.style.overflow = 'hidden';
                button.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }

            // Shake OTP inputs
            function shakeOTPInputs() {
                const otpContainer = document.getElementById('otpContainer');
                otpContainer.style.animation = 'none';
                setTimeout(() => {
                    otpContainer.style.animation = 'shake 0.5s ease-in-out';
                }, 10);
                
                // Remove animation after it completes
                setTimeout(() => {
                    otpContainer.style.animation = '';
                }, 500);
            }

            // Show alert function
            function showAlert(message, type = 'info') {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type}`;
                
                let icon = 'fa-info-circle';
                if (type === 'danger') icon = 'fa-exclamation-circle';
                if (type === 'success') icon = 'fa-check-circle';
                
                alert.innerHTML = `
                    <i class="fas ${icon}"></i> ${message}
                `;
                
                // Insert after verification header
                const verificationHeader = document.querySelector('.verification-header');
                verificationHeader.parentNode.insertBefore(alert, verificationHeader.nextSibling);
                
                // Auto remove
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'all 0.5s ease';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            }

            // Add shake animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>