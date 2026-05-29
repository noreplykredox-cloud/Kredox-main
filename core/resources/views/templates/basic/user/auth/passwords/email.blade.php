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
        .password-reset-container {
            width: 100%;
            max-width: 480px;
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

        /* Reset Card */
        .reset-card {
            background: var(--gradient-card);
            border-radius: 20px;
            border: 1px solid var(--border-red);
            padding: 40px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.5s ease 0.2s backwards;
        }

        .reset-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
        }

        .reset-card::after {
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
        .reset-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reset-icon {
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

        .reset-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .reset-subtitle {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
        }

        /* Form Styles */
        .reset-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-red);
            border-radius: 12px;
            color: var(--text-white);
            font-size: 15px;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: var(--transition);
        }

        /* Button */
        .reset-btn {
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

        .reset-btn:hover {
            background: var(--light-red);
            transform: translateY(-3px);
            box-shadow: var(--shadow-red);
        }

        .reset-btn:active {
            transform: translateY(0);
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

        .invalid-feedback {
            color: var(--danger-red);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .is-invalid {
            border-color: var(--danger-red) !important;
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

        /* Mobile Responsive */
        @media screen and (max-width: 768px) {
            body {
                padding: 20px;
            }

            .password-reset-container {
                padding: 10px;
            }

            .reset-card {
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

            .reset-icon {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .reset-title {
                font-size: 24px;
            }

            .form-input {
                padding: 14px 16px;
            }

            .reset-btn {
                padding: 16px;
            }
        }

        @media screen and (max-width: 480px) {
            .reset-card {
                padding: 25px 20px;
            }

            .reset-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .reset-title {
                font-size: 22px;
            }

            .reset-subtitle {
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
    </style>
</head>
<body>
    <!-- Back Button -->
    <a href="{{ route('user.login') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Login</span>
    </a>

    <!-- Status Indicator -->
    <div class="status-indicator">
        <div class="status-dot"></div>
        <div class="status-text">Secure Session</div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    <div class="particles" id="particles"></div>
    <div class="password-reset-container">
        <div class="reset-card">
            <!-- Header -->
            <div class="reset-header">
                <div class="reset-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1 class="reset-title">Recover Your Account</h1>
                <p class="reset-subtitle">
                    Enter your username or email address below and we will send a 6-digit secure verification OTP to authorize your password reset
                </p>
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
            <form method="POST" action="{{ route('user.password.email') }}" class="reset-form" id="resetForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username or Email Address</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-input @error('value') is-invalid @enderror" 
                               id="value" 
                               name="value" 
                               value="{{ old('value') }}" 
                               placeholder="Enter your username or email address" 
                               required 
                               autofocus>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('value')
                        <span class="invalid-feedback" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="reset-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span id="btnText">Send Verification OTP</span>
                </button>
            </form>

            <!-- Back to Login -->
            <div class="back-to-login">
                Remember your password?
                <a href="{{ route('user.login') }}">Sign In</a>
            </div>

            <!-- Security Badge -->
            <div class="security-badge">
                <i class="fas fa-shield-alt security-icon"></i>
                <span class="security-text">Your information is protected with 256-bit encryption</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create floating particles
            createParticles();

            // Form submission handling
            const resetForm = document.getElementById('resetForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');

            if (resetForm && submitBtn) {
                resetForm.addEventListener('submit', function(e) {
                    // Show loading overlay
                    loadingOverlay.classList.add('active');
                    
                    // Validate required field
                    const value = document.getElementById('value').value.trim();
                    
                    if (!value) {
                        e.preventDefault();
                        loadingOverlay.classList.remove('active');
                        createRippleEffect(submitBtn);
                        return;
                    }

                    // Update button text
                    submitBtn.disabled = true;
                    btnText.innerHTML = '<span class="spinner"></span> Sending OTP...';
                    
                    // Simulate minimum loading time for better UX
                    setTimeout(() => {
                        if (!resetForm.checkValidity()) {
                            submitBtn.disabled = false;
                            btnText.textContent = 'Send Verification OTP';
                            loadingOverlay.classList.remove('active');
                        }
                    }, 1500);
                });
            }

            // Create ripple effect for button
            submitBtn.addEventListener('click', function(e) {
                createRippleEffect(this, e);
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });

                // Remove error state on input
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                        const errorElement = this.parentElement.parentElement.querySelector('.invalid-feedback');
                        if (errorElement) {
                            errorElement.remove();
                        }
                    }
                });
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
                if (e.key === 'Enter' && resetForm && resetForm.checkValidity()) {
                    submitBtn.click();
                }
                
                // Escape to go back
                if (e.key === 'Escape') {
                    window.history.back();
                }
            });

            // Create particles function
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const particleCount = 20;

                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    // Random properties
                    const size = Math.random() * 5 + 2;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const duration = Math.random() * 20 + 10;
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

            // Add shake animation on error
            const hasErrors = document.querySelectorAll('.is-invalid, .alert-danger').length > 0;
            if (hasErrors && resetForm) {
                setTimeout(() => {
                    resetForm.style.animation = 'none';
                    setTimeout(() => {
                        resetForm.style.animation = 'shake 0.5s ease-in-out';
                    }, 10);
                }, 300);
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