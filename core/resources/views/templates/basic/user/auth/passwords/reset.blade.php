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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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
            cursor: pointer;
            transition: var(--transition);
        }

        .input-icon:hover {
            color: var(--light-red);
        }

        /* Password Strength Popup */
        .input-popup {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
            border: 1px solid var(--border-red);
            display: none;
            transition: var(--transition);
        }
        
        .hover-input-popup .input-popup {
            display: block;
            animation: slideInDown 0.3s ease;
        }

        .input-popup p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        
        .input-popup p::before {
            content: 'close';
            font-family: 'Material Icons';
            font-size: 14px;
            color: var(--danger-red);
        }
        
        .input-popup p.success {
            color: var(--success-green);
        }
        
        .input-popup p.success::before {
            content: 'check_circle';
            color: var(--success-green);
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
            from { opacity: 0; }
            to { opacity: 1; }
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
            to { transform: rotate(360deg); }
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
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-10px) translateX(-10px); }
            75% { transform: translateY(-30px) translateX(5px); }
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
            body { padding: 20px; }
            .password-reset-container { padding: 10px; }
            .reset-card { padding: 30px 25px; }
            .back-btn {
                top: 20px;
                left: 20px;
                padding: 8px 15px;
                font-size: 13px;
            }
            .logo img { max-width: 150px; }
            .reset-icon {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }
            .reset-title { font-size: 24px; }
            .form-input { padding: 14px 16px; }
            .reset-btn { padding: 16px; }
        }

        @media screen and (max-width: 480px) {
            .reset-card { padding: 25px 20px; }
            .reset-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }
            .reset-title { font-size: 22px; }
            .reset-subtitle { font-size: 14px; }
            .back-btn {
                top: 15px;
                left: 15px;
                padding: 6px 12px;
                font-size: 12px;
            }
            .logo img { max-width: 130px; }
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
        <div class="status-text">Secure Credentials</div>
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
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="reset-title">Reset Password</h1>
                <p class="reset-subtitle">
                    Create a strong, secure new password for your account to finish recovery
                </p>
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                    @foreach($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

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
            <form method="POST" action="{{ route('user.password.update') }}" class="reset-form" id="resetForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Enter new password" 
                               required 
                               autofocus>
                        <i class="fas fa-eye-slash input-icon" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                    
                    @if ($general->secure_password)
                        <div class="input-popup">
                            <p class="error lower">@lang('1 small letter minimum')</p>
                            <p class="error capital">@lang('1 capital letter minimum')</p>
                            <p class="error number">@lang('1 number minimum')</p>
                            <p class="error special">@lang('1 special character minimum')</p>
                            <p class="error minimum">@lang('6 character password')</p>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" 
                               class="form-input" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Confirm new password" 
                               required>
                        <i class="fas fa-eye-slash input-icon" id="toggleConfirmPassword"></i>
                    </div>
                </div>

                <button type="submit" class="reset-btn" id="submitBtn">
                    <i class="fas fa-shield-alt"></i>
                    <span id="btnText">Update Password</span>
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
                <span class="security-text">Your connection is encrypted with SSL secure protocols</span>
            </div>
        </div>
    </div>

    <!-- jQuery & secure_password check -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @if ($general->secure_password)
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create floating particles
            createParticles();

            // Toggle Password Visibility
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            if(togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordConfirmation = document.getElementById('password_confirmation');
            if(toggleConfirmPassword && passwordConfirmation) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordConfirmation.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Form submission handling
            const resetForm = document.getElementById('resetForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');

            if (resetForm && submitBtn) {
                resetForm.addEventListener('submit', function(e) {
                    // Show loading overlay
                    loadingOverlay.classList.add('active');
                    
                    // Validate pass matches
                    const passVal = password.value;
                    const confirmVal = passwordConfirmation.value;
                    
                    if (passVal !== confirmVal) {
                        e.preventDefault();
                        loadingOverlay.classList.remove('active');
                        alert("Passwords do not match!");
                        createRippleEffect(submitBtn);
                        return;
                    }

                    // Update button text
                    submitBtn.disabled = true;
                    btnText.innerHTML = '<span class="spinner"></span> Updating...';
                });
            }

            // Create ripple effect for button
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    createRippleEffect(this, e);
                });
            }

            // Input focus effects for secure password popup
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.form-group').classList.add('hover-input-popup');
                    this.parentElement.style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.form-group').classList.remove('hover-input-popup');
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
        });
    </script>
</body>
</html>
