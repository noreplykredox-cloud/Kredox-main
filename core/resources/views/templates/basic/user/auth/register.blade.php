@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')

    @php
        $policys = getContent('policy_pages.element', false, null, true);
    @endphp

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
            overflow-x: hidden;
            min-height: 100vh;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .split-container {
            display: flex;
            height: 100vh;
            padding-top: 80px; /* Account for fixed header */
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .content-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.95), rgba(0, 0, 0, 0.98));
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            overflow-y: hidden;
            overflow-x: hidden;
            border-right: 2px solid var(--border-red);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.7);
            z-index: 2;
            order: 1;
        }

        .content-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 70% 30%, rgba(139, 0, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 30% 70%, rgba(255, 0, 0, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .content-section::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 3px;
            height: 100%;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
            z-index: 3;
        }

        .register-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(17, 17, 17, 0.95), rgba(13, 13, 13, 0.98));
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            border-left: 2px solid var(--border-red);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.7);
            z-index: 2;
            order: 2;
        }

        .register-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 30% 30%, rgba(255, 0, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(139, 0, 0, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .register-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
            z-index: 3;
        }

        .section-divider {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: var(--gradient-black);
            border: 2px solid var(--border-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            box-shadow: var(--shadow-red);
            animation: pulseDivider 2s infinite;
        }

        .divider-arrow {
            color: var(--light-red);
            font-size: 28px;
            animation: bounceArrow 1.5s infinite;
        }

        .content-wrapper {
            max-width: 600px;
            margin: auto; /* Replaces justify-content: center to prevent clipping */
            position: relative;
            width: 100%;
        }

        .content-badge {
            display: inline-block;
            background: var(--gradient-red);
            color: white;
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 15px;
            text-transform: uppercase;
            box-shadow: var(--shadow-red);
            animation: slideInLeft 0.8s ease;
        }

        .content-title {
            font-size: 34px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 15px;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: slideInLeft 0.8s ease 0.2s backwards;
        }

        .content-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            margin-bottom: 25px;
            line-height: 1.5;
            animation: slideInLeft 0.8s ease 0.4s backwards;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            animation: slideInLeft 0.8s ease 0.6s backwards;
        }

        .stat-card {
            background: var(--gradient-card);
            border: 1px solid var(--border-red);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-red);
            border-color: var(--light-red);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 15px;
            background: var(--gradient-red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--light-red);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
        }

        .features-list {
            list-style: none;
            animation: slideInLeft 0.8s ease 0.8s backwards;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 10px;
            border-left: 3px solid var(--light-red);
            transition: var(--transition);
        }

        .feature-item:hover {
            background: rgba(255, 0, 0, 0.05);
            transform: translateX(5px);
        }

        .feature-icon {
            width: 35px;
            height: 35px;
            background: var(--gradient-red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
            color: white;
        }

        .feature-text {
            flex: 1;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-white);
            margin-bottom: 2px;
        }

        h4 {
            margin-top: 0px !important;
        }
        .feature-desc {
            font-size: 12px;
            color: var(--text-muted);
        }

        .register-box {
            width: 100%;
            max-width: 480px;
            margin: auto; /* Replaces justify-content: center to prevent clipping */
            background: var(--gradient-card);
            border-radius: 20px;
            border: 1px solid var(--border-red);
            padding: 20px 25px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.8s ease;
        }

        .register-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
        }

        .register-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .register-subtitle {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Form Styles */
        .register-form {
            display: flex;
            flex-direction: column;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }

        .form-group {
            position: relative;
            margin-bottom: 0;
        }

        .span-2 {
            grid-column: span 2;
        }

        .form-label {
            display: block;
            color: var(--text-light);
            font-size: 13px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-red);
            border-radius: 10px;
            color: var(--text-white);
            font-size: 13px;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
        }

        /* Prevent white background on browser autofill */
        .form-input:-webkit-autofill,
        .form-input:-webkit-autofill:hover, 
        .form-input:-webkit-autofill:focus, 
        .form-input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #0c0c0c inset !important;
            -webkit-text-fill-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
        }

        .input-icon:hover {
            color: var(--light-red);
        }

        /* Checkbox Group */
        .checkgroup {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 10px 12px;
            background: rgba(255, 0, 0, 0.05);
            border-radius: 10px;
            border: 1px solid var(--border-red);
        }

        .checkgroup input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--light-red);
            cursor: pointer;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .checkgroup label {
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.4;
            cursor: pointer;
        }

        .agreement-text a {
            color: var(--light-red);
            text-decoration: none;
            transition: var(--transition);
        }

        .agreement-text a:hover {
            text-decoration: underline;
            color: var(--hover-red);
        }

        /* Captcha */
        .captcha-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--border-red);
            margin-bottom: 15px;
        }

        /* Register Button */
        .register-btn {
            width: 100%;
            padding: 12px;
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .register-btn:hover {
            background: var(--light-red);
            transform: translateY(-3px);
            box-shadow: var(--shadow-red);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        /* Login Link */
        .login-link {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-top: -25px;
            padding-top: 15px;
            border-top: 1px solid var(--border-red);
        }

        .login-link a {
            color: var(--light-red);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: var(--transition);
        }

        .login-link a:hover {
            text-decoration: underline;
            color: var(--hover-red);
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

        /* Alerts */
        .alert {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            font-size: 13px;
            border-left: 4px solid;
            animation: slideInRight 0.5s ease;
            display: flex;
            align-items: center;
            gap: 10px;
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

        .invalid-feedback, .invalid-feedback-ajax {
            color: var(--danger-red);
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .is-invalid {
            border-color: var(--danger-red) !important;
        }

        .is-invalid-red {
            border-color: #ff3333 !important;
            box-shadow: 0 0 10px rgba(255, 51, 51, 0.3) !important;
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
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

        @keyframes pulseDivider {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(255, 0, 0, 0);
            }
        }

        @keyframes bounceArrow {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(-5px);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* Mobile Responsive */
        @media screen and (max-width: 992px) {
            .split-container {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }
            
            /* Mobile Order - Register First, Content Second */
            .register-section {
                order: 1 !important;
                min-height: 100vh;
                padding-top: 100px; /* Space for mobile header */
                border: none;
                border-bottom: 2px solid var(--border-red);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
                padding-left: 15px;
                padding-right: 15px;
                padding-bottom: 30px;
                animation: slideInDown 0.8s ease;
            }
            
            .register-section::after {
                display: none;
            }
            
            .content-section {
                order: 2 !important;
                min-height: 100vh;
                border: none;
                border-top: 2px solid var(--border-red);
                box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.7);
                padding: 40px 20px;
                animation: slideInUp 0.8s ease 0.3s backwards;
            }
            
            .content-section::after {
                display: none;
            }
            
            .section-divider {
                display: none;
            }
            
            .content-title {
                font-size: 32px;
                text-align: center;
                animation: slideInUp 0.8s ease 0.5s backwards;
            }
            
            .content-subtitle {
                text-align: center;
                animation: slideInUp 0.8s ease 0.6s backwards;
            }
            
            .content-wrapper {
                padding: 10px;
                max-width: 100%;
            }
            
            .register-box {
                max-width: 100%;
                margin: 0 auto;
                padding: 30px 25px;
                animation: slideInDown 0.8s ease 0.2s backwards;
            }
            
            .stats-grid {
                animation: slideInUp 0.8s ease 0.7s backwards;
            }
            
            .features-list {
                animation: slideInUp 0.8s ease 0.8s backwards;
            }
            
            .content-badge {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin: 0 auto 30px;
                width: fit-content;
            }
            
            /* Mobile scroll indicator */
            .scroll-indicator {
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                color: var(--light-red);
                font-size: 24px;
                animation: bounce 2s infinite;
                cursor: pointer;
                z-index: 100;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .scroll-text {
                font-size: 12px;
                color: var(--text-muted);
                letter-spacing: 1px;
                text-transform: uppercase;
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% {
                    transform: translateX(-50%) translateY(0);
                }
                40% {
                    transform: translateX(-50%) translateY(-10px);
                }
                60% {
                    transform: translateX(-50%) translateY(-5px);
                }
            }
        }

        @media screen and (max-width: 576px) {
            .content-section, .register-section {
                padding: 20px 15px;
                min-height: auto;
            }
            
            .content-title {
                font-size: 28px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .register-box {
                padding: 20px 15px;
            }
            
            .register-title {
                font-size: 24px;
            }
            
            .feature-item {
                padding: 12px;
                margin-bottom: 15px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .span-2 {
                grid-column: span 1;
            }
        }

        /* Small Mobile */
        @media screen and (max-width: 400px) {
            .content-title {
                font-size: 24px;
            }
            
            .content-subtitle {
                font-size: 16px;
            }
            
            .stat-number {
                font-size: 24px;
            }
            
            .register-box {
                padding: 20px 15px;
            }
            
            .form-input {
                padding: 12px 14px;
            }
            
            .register-btn {
                padding: 14px;
            }
        }

        /* Desktop Grid */
        @media screen and (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px 15px;
            }
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

        @keyframes spin {
            to {
                transform: rotate(360deg);
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

        .loading-spinner::before,
        .loading-spinner::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            border: 3px solid transparent;
        }

        .loading-spinner::before {
            border-top-color: var(--deep-red);
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            animation: spin 2s linear infinite;
        }

        .loading-spinner::after {
            border-top-color: var(--accent-red);
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            animation: spin 1.5s linear infinite reverse;
        }

        /* Form shake animation */
        .shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    <div class="split-container">
        <!-- Desktop Order: Content First -->
        <div class="content-section">
            <div class="content-wrapper">
                <div class="content-badge">
                    <i class="fas fa-crown"></i> PREMIUM TRADING
                </div>
                
                <h1 class="content-title">Join The Trading Revolution</h1>
                
                <p class="content-subtitle">
                    Create your account and unlock access to advanced trading tools, real-time analytics, and expert market insights.
                </p>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">New Members Monthly</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                </div>
                
                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="feature-text">
                            <h4 class="feature-title">Advanced Analytics</h4>
                            <p class="feature-desc">Real-time market data and predictive analytics</p>
                        </div>
                    </li>
                    
                    <!-- <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4 class="feature-title">Secure Platform</h4>
                            <p class="feature-desc">Bank-grade security with 2FA protection</p>
                        </div>
                    </li> -->
                    
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="feature-text">
                            <h4 class="feature-title">24/7 Support</h4>
                            <p class="feature-desc">Dedicated customer support team</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Center Divider - Desktop Only -->
        <div class="section-divider">
            <i class="fas fa-arrow-right divider-arrow"></i>
        </div>

        <!-- Desktop Order: Register Second -->
        <div class="register-section">
            <div class="register-box">
                <div class="register-header">
                    <h1 class="register-title">Create Account</h1>
                    <p class="register-subtitle">Join KREDOX and start your 4X trading journey</p>
                </div>

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

                <form action="{{ route('user.register') }}" method="POST" class="register-form verify-gcaptcha" id="registerForm">
                    @csrf
                    
                    <div class="form-grid">
                        @if (session()->get('reference') != null)
                            <div class="form-group">
                                <label class="form-label">@lang('Reference By')</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-input" 
                                           name="referBy" 
                                           value="{{ session()->get('reference') }}" 
                                           readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Username')</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-input @error('username') is-invalid @enderror checkUser" 
                                           name="username" 
                                           placeholder="@lang('Username')" 
                                           value="{{ old('username') }}" 
                                           required>
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </span>
                                @enderror
                                <small class="text--danger usernameExist"></small>
                            </div>
                        @else
                            <div class="form-group span-2">
                                <label class="form-label">@lang('Username')</label>
                                <div class="input-group">
                                    <input type="text" 
                                           class="form-input @error('username') is-invalid @enderror checkUser" 
                                           name="username" 
                                           placeholder="@lang('Username')" 
                                           value="{{ old('username') }}" 
                                           required>
                                    <i class="fas fa-user input-icon"></i>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </span>
                                @enderror
                                <small class="text--danger usernameExist"></small>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="form-label">@lang('First Name')</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-input @error('firstname') is-invalid @enderror" 
                                       name="firstname" 
                                       placeholder="@lang('Enter First Name')" 
                                       value="{{ old('firstname') }}" 
                                       required>
                            </div>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Last Name')</label>
                            <div class="input-group">
                                <input type="text" 
                                       class="form-input @error('lastname') is-invalid @enderror" 
                                       name="lastname" 
                                       placeholder="@lang('Enter Last Name')" 
                                       value="{{ old('lastname') }}" 
                                       required>
                            </div>
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group span-2">
                            <label class="form-label">@lang('Email Address')</label>
                            <div class="input-group">
                                <input type="email" 
                                       class="form-input @error('email') is-invalid @enderror checkUser" 
                                       name="email" 
                                       placeholder="@lang('Email Address')" 
                                       value="{{ old('email') }}" 
                                       required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group span-2">
                            <label class="form-label">@lang('Mobile')</label>
                            <div class="input-group">
                                <input type="hidden" name="mobile_code" value="91">
                                <input type="hidden" name="country_code" value="IN">
                                <input type="number" 
                                       class="form-input @error('mobile') is-invalid @enderror checkUser" 
                                       name="mobile" 
                                       placeholder="@lang('Your Phone Number')" 
                                       value="{{ old('mobile') }}"
                                       oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);" 
                                       pattern="[0-9]{10}"
                                       required>
                                <i class="fas fa-phone input-icon"></i>
                            </div>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                            <small class="text--danger mobileExist"></small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Password')</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-input @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="@lang('Enter Password')" 
                                       required>
                                <i class="fas fa-eye input-icon toggle-password" data-target="password"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Confirm Password')</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-input @error('password_confirmation') is-invalid @enderror" 
                                       id="confirmPassword" 
                                       name="password_confirmation" 
                                       placeholder="@lang('Confirm Password')" 
                                       required>
                                <i class="fas fa-eye input-icon toggle-password" data-target="confirmPassword"></i>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group span-2">
                            <x-captcha />
                        </div>

                        @if ($general->agree)
                            <div class="checkgroup span-2">
                                <input type="checkbox" 
                                       id="agree" 
                                       name="agree" 
                                       required 
                                       {{ old('agree') ? 'checked' : '' }}>
                                <label for="agree" class="agreement-text">
                                    @lang('I agree with')
                                    @foreach ($policys as $policy)
                                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                            {{ __($policy->data_values->title) }}
                                        </a>@if (!$loop->last),@endif
                                    @endforeach
                                </label>
                            </div>
                        @endif

                        <div class="form-group span-2">
                            <button type="submit" class="register-btn" id="submitBtn">
                                <i class="fas fa-user-plus"></i>
                                <span id="btnText">Create Account</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="login-link">
                    Already have an account?
                    <a href="{{ route('user.login') }}">Sign In Now</a>
                </div>
<!-- 
                <div class="security-badge">
                    <i class="fas fa-lock security-icon"></i>
                    <span class="security-text">Your data is protected with 256-bit encryption</span>
                </div> -->
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: var(--card-black); color: var(--text-white);">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('You are with us')</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('You already have an account please Sign in')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="custom-button theme btn-sm text-white">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set body opacity to 1 after load
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);

            // Check if mobile view
            const isMobile = window.innerWidth <= 992;
            
            // Password toggle functionality
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });

            // Form elements
            const registerForm = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Form submission handling (AJAX)
            if (registerForm && submitBtn) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Show loading overlay
                    loadingOverlay.classList.add('active');
                    submitBtn.disabled = true;
                    btnText.innerHTML = '<span class="spinner"></span> Creating Account...';
                    
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }
                        return response.json().then(data => ({ status: response.status, data }));
                    })
                    .then(res => {
                        if (!res) return;

                        if (res.status === 200 || (res.data && res.data.redirect)) {
                            window.location.href = res.data.redirect || "{{ route('user.home') }}";
                        } else {
                            // Error handling
                            loadingOverlay.classList.remove('active');
                            submitBtn.disabled = false;
                            btnText.innerHTML = 'Create Account';
                            
                            // Shake animation
                            registerForm.classList.add('shake');
                            setTimeout(() => registerForm.classList.remove('shake'), 500);

                            // UI Feedback: Highlight error fields and show messages beneath them
                            document.querySelectorAll('.invalid-feedback-ajax').forEach(el => el.remove());
                            
                            let firstErrorMessage = 'Registration failed. Please check the form.';
                            
                            if (res.data && res.data.errors) {
                                Object.keys(res.data.errors).forEach(field => {
                                    const input = document.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid-red');
                                        
                                        // Create error message element
                                        const errorMsg = document.createElement('span');
                                        errorMsg.classList.add('invalid-feedback-ajax');
                                        errorMsg.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${res.data.errors[field][0]}`;
                                        
                                        // Insert after input-group or directly after input
                                        const inputGroup = input.closest('.input-group');
                                        if (inputGroup) {
                                            inputGroup.parentNode.insertBefore(errorMsg, inputGroup.nextSibling);
                                        } else {
                                            input.parentNode.insertBefore(errorMsg, input.nextSibling);
                                        }
                                    }
                                });
                                firstErrorMessage = Object.values(res.data.errors)[0][0];
                            } else if (res.data && res.data.message) {
                                firstErrorMessage = res.data.message;
                            }
                            
                            if (typeof notify === 'function') {
                                notify('error', firstErrorMessage);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Registration Error:', error);
                        loadingOverlay.classList.remove('active');
                        submitBtn.disabled = false;
                        btnText.innerHTML = 'Create Account';
                        
                        if (typeof notify === 'function') {
                            notify('error', 'Something went wrong. Please try again.');
                        }
                    });
                });
            }

            // Ripple effect for buttons
            const buttons = document.querySelectorAll('.register-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    createRippleEffect(this, e);
                });
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
                    if (this.classList.contains('is-invalid') || this.classList.contains('is-invalid-red')) {
                        this.classList.remove('is-invalid');
                        this.classList.remove('is-invalid-red');
                        
                        // Remove injected AJAX error messages
                        const parent = this.closest('.form-group');
                        if (parent) {
                            const ajaxError = parent.querySelector('.invalid-feedback-ajax');
                            if (ajaxError) ajaxError.remove();
                        }
                        
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

            // Feature card hover effects
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach((item, index) => {
                item.style.animationDelay = `${0.3 + (index * 0.1)}s`;
                
                item.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('.feature-icon');
                    if (icon) {
                        icon.style.animation = 'float 0.5s ease';
                        setTimeout(() => {
                            icon.style.animation = 'float 3s ease-in-out infinite';
                        }, 500);
                    }
                });
            });

            // Check for existing user
            const checkUserInputs = document.querySelectorAll('.checkUser');
            checkUserInputs.forEach(input => {
                input.addEventListener('focusout', function(e) {
                    const url = '{{ route('user.checkUser') }}';
                    const value = this.value;
                    const fieldName = this.getAttribute('name');
                    const token = '{{ csrf_token() }}';
                    
                    if (!value) return;
                    
                    let data = {};
                    
                    if (fieldName === 'mobile') {
                        const mobileCode = document.querySelector('input[name=mobile_code]').value || '91';
                        data = {
                            mobile: mobileCode + value,
                            _token: token
                        };
                    } else if (fieldName === 'email' || fieldName === 'username') {
                        data = {
                            [fieldName]: value,
                            _token: token
                        };
                    }
                    
                    if (Object.keys(data).length === 0) return;
                    
                    $.post(url, data, function(response) {
                        if (response.data !== false && response.type === 'email') {
                            $('#existModalCenter').modal('show');
                        } else if (response.data !== false) {
                            const errorElement = document.querySelector(`.${response.type}Exist`);
                            if (errorElement) {
                                errorElement.textContent = `${response.type} already exists`;
                                errorElement.style.color = 'var(--danger-red)';
                            }
                        } else {
                            const errorElement = document.querySelector(`.${response.type}Exist`);
                            if (errorElement) {
                                errorElement.textContent = '';
                            }
                        }
                    });
                });
            });

            // Add shake animation if there are errors
            const hasErrors = document.querySelectorAll('.is-invalid, .alert-danger').length > 0;
            if (hasErrors && registerForm) {
                setTimeout(() => {
                    registerForm.classList.add('shake');
                    setTimeout(() => {
                        registerForm.classList.remove('shake');
                    }, 500);
                }, 300);
            }

            // Enter key submission
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && registerForm && registerForm.checkValidity()) {
                    submitBtn.click();
                }
            });

            // Mobile scroll indicator
            const scrollIndicator = document.querySelector('.scroll-indicator');
            if (scrollIndicator && isMobile) {
                scrollIndicator.addEventListener('click', function() {
                    const contentSection = document.querySelector('.content-section');
                    contentSection.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }

            // Mobile scroll detection for hiding indicator
            if (isMobile) {
                let lastScrollTop = 0;
                window.addEventListener('scroll', function() {
                    const scrollIndicator = document.querySelector('.scroll-indicator');
                    if (!scrollIndicator) return;
                    
                    const st = window.pageYOffset || document.documentElement.scrollTop;
                    if (st > lastScrollTop) {
                        scrollIndicator.style.opacity = '0';
                    } else {
                        scrollIndicator.style.opacity = '1';
                    }
                    lastScrollTop = st <= 0 ? 0 : st;
                });
            }

            // Responsive resize handling
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Handle any responsive changes if needed
                }, 250);
            });

            // Helper function for ripple effect
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

            // Mobile intersection observer for animations
            if (isMobile) {
                const contentSection = document.querySelector('.content-section');
                const registerSection = document.querySelector('.register-section');
                
                if (contentSection && registerSection) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.animationPlayState = 'running';
                            }
                        });
                    }, { threshold: 0.1 });
                    
                    observer.observe(contentSection);
                    observer.observe(registerSection);
                }
            }
        });
    </script>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
<script>
    "use strict";
    (function($) {
        @if ($mobileCode)
        $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
        @endif
        
        $('select[name=country]').change(function() {
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        });
        
        $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
        $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
        $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
        
        // Secure password validation if enabled
        @if ($general->secure_password)
            $('input[name=password]').on('input', function() {
                secure_password($(this));
            });

            $('.prevent-double-click').click(function() {
                if ($('.password-input').hasClass('is-invalid')) {
                    return false;
                }
                return true;
            });
        @endif
    })(jQuery);
</script>
@endpush