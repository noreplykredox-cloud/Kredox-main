@extends($activeTemplate . 'layouts.app')
@section('panel')
    @include($activeTemplate . 'partials.header')

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
            padding-top: 80px;
            /* Account for fixed header */
            position: relative;
            z-index: 1;
            overflow: hidden;
            /* Prevent scrolling */
        }

        .content-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.95), rgba(0, 0, 0, 0.98));
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: relative;
            overflow-y: auto;
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

        .login-section {
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

        .login-section::before {
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

        .login-section::after {
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
            margin: auto;
            /* Replaces justify-content: center to prevent clipping */
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
            border-radius: 12px;
            padding: 15px;
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
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
            background: var(--gradient-red);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: var(--light-red);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
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

        .login-box {
            width: 100%;
            max-width: 420px;
            margin: auto;
            /* Replaces justify-content: center to prevent clipping */
            background: var(--gradient-card);
            border-radius: 20px;
            border: 1px solid var(--border-red);
            padding: 30px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.8s ease;
        }

        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-red);
            box-shadow: var(--glow-red);
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-white);
            margin-bottom: 5px;
            background: linear-gradient(to right, var(--text-white), var(--light-red));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .login-subtitle {
            color: var(--text-muted);
            font-size: 15px;
        }

        /* Form Styles */
        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            color: var(--text-light);
            font-size: 13px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-red);
            border-radius: 10px;
            color: var(--text-white);
            font-size: 14px;
            transition: var(--transition);
            font-family: 'Inter', sans-serif;
        }

        .input-group .form-input {
            padding-right: 45px;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        /* Hide native password visibility toggle and credentials icons */
        .form-input::-ms-reveal,
        .form-input::-ms-clear {
            display: none !important;
        }

        .form-input::-webkit-contacts-auto-fill-button,
        .form-input::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
        }

        .input-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
            z-index: 10;
        }

        .input-icon:hover {
            color: var(--light-red);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--light-red);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--light-red);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: var(--hover-red);
        }

        /* Captcha */
        .captcha-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid var(--border-red);
            margin-bottom: 15px;
            transform: scale(0.85);
            /* Make captcha smaller */
            transform-origin: center;
        }

        .h-captcha {
            display: flex;
            justify-content: center;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            background: var(--light-red);
            transform: translateY(-3px);
            box-shadow: var(--shadow-red);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Register Link */
        .register-link {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-red);
        }

        .register-link a {
            color: var(--light-red);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: var(--transition);
        }

        .register-link a:hover {
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

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(255, 0, 0, 0);
            }
        }

        @keyframes bounceArrow {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-5px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
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

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        /* Session Indicators - Desktop Only */
        .session-indicator {
            position: fixed;
            top: 30px;
            left: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            animation: slideInLeft 0.5s ease;
            pointer-events: none;
        }

        .session-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--light-red);
            animation: pulse 2s infinite;
        }

        .session-label {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .session-content {
            position: fixed;
            top: 30px;
            right: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 100;
            animation: slideInRight 0.5s ease;
            pointer-events: none;
        }

        /* Mobile Responsive */
        @media screen and (max-width: 992px) {
            .split-container {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }

            /* Mobile Order - Login First, Content Second */
            .login-section {
                order: 1 !important;
                /* Mobile: Login first */
                min-height: 100vh;
                padding-top: 100px;
                /* Space for mobile header */
                border: none;
                border-bottom: 2px solid var(--border-red);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 30px;
                animation: slideInDown 0.8s ease;
                overflow-y: auto;
            }

            .login-section::after {
                display: none;
            }

            .content-section {
                order: 2 !important;
                /* Mobile: Content second */
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

            /* Session Indicators Mobile Fix */
            .session-indicator {
                position: fixed;
                top: 20px;
                left: 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
                background: rgba(13, 13, 13, 0.8);
                padding: 10px 15px;
                border-radius: 8px;
                border: 1px solid var(--border-red);
                backdrop-filter: blur(10px);
                pointer-events: auto;
                max-width: 200px;
            }

            .session-content {
                position: fixed;
                top: 20px;
                right: 20px;
                background: rgba(13, 13, 13, 0.8);
                padding: 10px 15px;
                border-radius: 8px;
                border: 1px solid var(--border-red);
                backdrop-filter: blur(10px);
                pointer-events: auto;
                max-width: 200px;
            }

            .session-label {
                font-size: 11px;
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

            .login-box {
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

            /* Mobile specific adjustments */
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

                0%,
                20%,
                50%,
                80%,
                100% {
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

            .content-section,
            .login-section {
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

            .login-box {
                padding: 25px 20px;
            }

            .login-title {
                font-size: 24px;
            }

            .remember-forgot {
                gap: 15px;
                align-items: flex-start;
            }

            .feature-item {
                padding: 12px;
                margin-bottom: 15px;
            }

            /* Mobile session indicators */
            .session-indicator {
                top: 15px;
                left: 15px;
                padding: 8px 12px;
                max-width: 150px;
            }

            .session-content {
                top: 15px;
                right: 15px;
                padding: 8px 12px;
                max-width: 150px;
            }

            .session-label {
                font-size: 10px;
            }

            .mobile-content-header {
                text-align: center;
                margin-bottom: 30px;
                padding-top: 20px;
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

            .login-box {
                padding: 20px 15px;
            }

            .form-input {
                padding: 14px 16px;
            }

            .login-btn {
                padding: 16px;
            }

            /* Hide session indicators on very small screens */
            .session-indicator,
            .session-content {
                display: none;
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

        /* Mobile content header */
        .mobile-content-header {
            display: none;
        }

        /* Mobile only elements */
        .mobile-only {
            display: none;
        }
    </style>



    <div class="split-container">
        <!-- Desktop Order: Content First -->
        <div class="content-section">

            <div class="content-wrapper">
                <div class="content-badge">
                    <i class="fas fa-shield-alt"></i> SECURE PLATFORM
                </div>

                <h1 class="content-title">Access Your Digital Wealth Portfolio</h1>

                <p class="content-subtitle">
                    Secure login to manage your investments, track performance, and maximize returns in our advanced trading
                    ecosystem.
                </p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Active Traders</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-number">$2.1B+</div>
                        <div class="stat-label">Volume Traded</div>
                    </div>
                </div>

                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="feature-text">
                            <h4 class="feature-title">Bank-Level Security</h4>
                            <p class="feature-desc">256-bit encryption & 2FA protection for maximum security</p>
                        </div>
                    </li>

                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-text">
                            <h4 class="feature-title">Real-Time Analytics</h4>
                            <p class="feature-desc">Live portfolio tracking with instant notifications</p>
                        </div>
                    </li>


                </ul>
            </div>
        </div>

        <!-- Center Divider - Desktop Only -->
        <div class="section-divider">
            <i class="fas fa-arrow-right divider-arrow"></i>
        </div>

        <!-- Desktop Order: Login Second -->
        <div class="login-section">


            <div class="login-box">
                <div class="login-header">
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to access your account</p>
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

                <form method="POST" action="{{ route('user.login') }}" class="login-form verify-gcaptcha" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Username or Email</label>
                        <div class="input-group">
                            <input type="text" class="form-input @error('username') is-invalid @enderror" id="username"
                                name="username" value="{{ old('username') }}" placeholder="Enter username or email"
                                minlength="3" maxlength="100" required autofocus>
                            <i class="fas fa-user input-icon"></i>
                        </div>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-input @error('password') is-invalid @enderror" id="password"
                                name="password" placeholder="Enter your password" minlength="6" maxlength="32" required>
                            <i class="fas fa-eye input-icon" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror

                        <div class="remember-forgot">
                            <label class="remember-me">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span>Remember me</span>
                            </label>
                            <a href="{{ route('user.password.request') }}" class="forgot-password">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <x-captcha />
                    </div>

                    <button type="submit" class="login-btn" id="submitBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="btnText">Sign In</span>
                    </button>
                </form>

                <div class="register-link">
                    Don't have an account?
                    <a href="{{ route('user.register') }}">Sign Up Now</a>
                </div>

                <div class="security-badge">
                    <i class="fas fa-lock security-icon"></i>
                    <span class="security-text">Your security is our priority. All sessions are encrypted.</span>
                </div>
            </div>
        </div>


    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Set body opacity to 1 after load
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);

            // Check if mobile view
            const isMobile = window.innerWidth <= 992;

            // Show/hide mobile only elements
            if (isMobile) {
                document.querySelectorAll('.mobile-only').forEach(el => {
                    el.style.display = 'block';
                });
                document.querySelector('.mobile-content-header').style.display = 'block';
            }

            // Password toggle
            const togglePassword = document.getElementById('togglePassword');
            if (togglePassword) {
                togglePassword.addEventListener('click', function () {
                    const passwordInput = this.parentElement.querySelector('input');
                    if (passwordInput) {
                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                        passwordInput.setAttribute('type', type);
                        this.classList.toggle('fa-eye');
                        this.classList.toggle('fa-eye-slash');
                    }
                });
            }

            // Form elements
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Form submission handling (AJAX)
            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Show loading overlay
                    loadingOverlay.classList.add('active');
                    submitBtn.disabled = true;
                    btnText.innerHTML = '<span class="spinner"></span> Validating...';

                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    const passwordInput = document.getElementById('password');

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            // Laravel returns 302 for success redirect in some cases even with AJAX
                            // or it returns 200 with a JSON redirect if we were to customize it.
                            // Standard AuthenticatesUsers returns a redirect.
                            if (response.redirected) {
                                window.location.href = response.url;
                                return;
                            }
                            return response.json().then(data => ({ status: response.status, data }));
                        })
                        .then(res => {
                            if (!res) return; // Already handled redirection

                            if (res.status === 200 || (res.data && res.data.redirect)) {
                                window.location.href = res.data.redirect || "{{ route('user.home') }}";
                            } else {
                                // Error handling
                                loadingOverlay.classList.remove('active');
                                submitBtn.disabled = false;
                                btnText.innerHTML = 'Sign In';

                                // Shake animation
                                loginForm.classList.add('shake');
                                setTimeout(() => loginForm.classList.remove('shake'), 500);

                                // UI Feedback: Red Border and Clear Password
                                passwordInput.value = '';
                                passwordInput.classList.add('is-invalid-red');

                                // Show Notification
                                let errorMessage = 'Invalid credentials provided.';
                                if (res.data && res.data.errors) {
                                    errorMessage = Object.values(res.data.errors)[0][0];
                                } else if (res.data && res.data.message) {
                                    errorMessage = res.data.message;
                                }

                                if (typeof notify === 'function') {
                                    notify('error', errorMessage);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Login Error:', error);
                            loadingOverlay.classList.remove('active');
                            submitBtn.disabled = false;
                            btnText.innerHTML = 'Sign In';

                            if (typeof notify === 'function') {
                                notify('error', 'Something went wrong. Please try again.');
                            }
                        });
                });
            }

            // Remove red border when user starts typing in password field
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function () {
                    if (this.classList.contains('is-invalid-red')) {
                        this.classList.remove('is-invalid-red');
                    }
                });
            }

            // Ripple effect for buttons
            const buttons = document.querySelectorAll('.login-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    createRippleEffect(this, e);
                });
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function () {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function () {
                    this.parentElement.style.transform = 'translateY(0)';
                });

                // Remove error state on input
                input.addEventListener('input', function () {
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

            // Feature card hover effects
            const featureItems = document.querySelectorAll('.feature-item');
            featureItems.forEach((item, index) => {
                item.style.animationDelay = `${0.3 + (index * 0.1)}s`;

                item.addEventListener('mouseenter', function () {
                    const icon = this.querySelector('.feature-icon');
                    if (icon) {
                        icon.style.animation = 'float 0.5s ease';
                        setTimeout(() => {
                            icon.style.animation = 'float 3s ease-in-out infinite';
                        }, 500);
                    }
                });
            });
            const statCards = document.querySelectorAll('.stat-card');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            statCards.forEach(card => {
                observer.observe(card);
            });

            const sessionDots = document.querySelectorAll('.session-dot');
            sessionDots.forEach((dot, index) => {
                dot.style.animationDelay = `${index * 0.5}s`;
            });

            const dividerArrow = document.querySelector('.divider-arrow');
            if (dividerArrow) {
                setInterval(() => {
                    dividerArrow.style.animation = 'none';
                    setTimeout(() => {
                        dividerArrow.style.animation = 'bounceArrow 1.5s infinite';
                    }, 10);
                }, 5000);
            }
            const hasErrors = document.querySelectorAll('.is-invalid, .alert-danger').length > 0;
            if (hasErrors && loginForm) {
                setTimeout(() => {
                    loginForm.classList.add('shake');
                    setTimeout(() => {
                        loginForm.classList.remove('shake');
                    }, 500);
                }, 300);
            }
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && loginForm && loginForm.checkValidity()) {
                    submitBtn.click();
                }
            });

            const scrollIndicator = document.querySelector('.scroll-indicator');
            if (scrollIndicator && isMobile) {
                scrollIndicator.addEventListener('click', function () {
                    const contentSection = document.querySelector('.content-section');
                    contentSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }

            if (isMobile) {
                let lastScrollTop = 0;
                window.addEventListener('scroll', function () {
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
            let resizeTimer;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    const isNowMobile = window.innerWidth <= 992;

                    if (isNowMobile) {
                        document.querySelectorAll('.mobile-only').forEach(el => {
                            el.style.display = 'block';
                        });
                        document.querySelector('.mobile-content-header').style.display = 'block';
                    } else {
                        document.querySelectorAll('.mobile-only').forEach(el => {
                            el.style.display = 'none';
                        });
                        document.querySelector('.mobile-content-header').style.display = 'none';
                    }
                }, 250);
            });

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
            if (isMobile) {
                const contentSection = document.querySelector('.content-section');
                const loginSection = document.querySelector('.login-section');

                if (contentSection && loginSection) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.style.animationPlayState = 'running';
                            }
                        });
                    }, { threshold: 0.1 });

                    observer.observe(contentSection);
                    observer.observe(loginSection);
                }
            }
            if (isMobile) {
                const phoneNumbers = document.querySelectorAll('.phone-number');
                phoneNumbers.forEach(number => {
                    number.addEventListener('click', function () {
                        const phoneNum = this.textContent.trim();
                        if (confirm(`Call ${phoneNum}?`)) {
                            window.location.href = `tel:${phoneNum}`;
                        }
                    });
                });
            }
        });
        function showMobileDialer() {
            if (window.innerWidth <= 992) {
                const phoneNumber = "+1234567890";
                if (confirm(`Call ${phoneNumber}?`)) {
                    window.location.href = `tel:${phoneNumber}`;
                }
            }
        }
    </script>
@endsection