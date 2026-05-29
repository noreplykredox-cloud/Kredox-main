@extends($activeTemplate . 'layouts.frontend')

@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        :root {
            --primary-color: #122edbba;
            --secondary-color: #122edbba;
            --dark-bg: #1a1a2e;
            --darker-bg: #16213e;
            --text-light: #f1f1f1;
            --text-lighter: #ffffff;
            --accent-color: #00cec9;
            --danger-color: #ff7675;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Mobile Navigation */
        .nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 65px;
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            overflow-x: auto;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            min-width: 50px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav__link:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--accent-color);
        }

        .nav__icon {
            font-size: 22px;
            margin-bottom: 3px;
        }

        .nav__text {
            font-size: 12px;
            opacity: 0.9;
        }

        .nav__link--active {
            color: var(--accent-color);
        }

        /* Login Container */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            padding: 20px;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #myVideo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            opacity: 0.15;
            filter: blur(3px);
        }

        .login-box {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(7px);
            padding: 2.5rem;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.8s ease-in-out;
            position: relative;
            overflow-y: auto;
            max-height: 90vh;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .login-box::-webkit-scrollbar {
            display: none;
        }

        .login-box h3 {
            margin-bottom: 1.5rem;
            color: var(--text-lighter);
            font-weight: 600;
            text-align: center;
            font-size: 1.8rem;
            animation: slideInFromTop 0.8s ease-out;
        }

        .login-box p {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-box label {
            display: block;
            margin-bottom: 0.8rem;
            color: var(--text-light);
            font-weight: 400;
            font-size: 0.95rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .login-box input,
        .login-box select {
            width: 100%;
            padding: 0.9rem 1.2rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--text-lighter);
            font-size: 1rem;
            transition: all 0.3s ease;
            margin-bottom: 0;
        }

        .login-box input:focus,
        .login-box select:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 206, 201, 0.2);
        }

        .login-box button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-box button:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
        }

        .account-logo {
            display: inline-block;
            transition: all 0.5s ease;
            animation: bounceIn 1s ease-out;
        }

        .account-logo img {
            max-height: 50px;
            margin-bottom: 1.5rem;
            transition: all 0.5s ease;
        }

        .account-logo:hover {
            transform: scale(1.05);
        }

        .account-logo:hover img {
            transform: rotate(5deg);
        }

        /* Form elements animation */
        .contact-form-group {
            opacity: 0;
            margin-bottom: 1.5rem;
        }

        .contact-form-group:nth-child(odd) {
            animation: slideInFromLeft 0.6s ease-out forwards;
        }

        .contact-form-group:nth-child(even) {
            animation: slideInFromRight 0.6s ease-out forwards;
        }

        .contact-form-group:nth-child(1) { animation-delay: 0.2s; }
        .contact-form-group:nth-child(2) { animation-delay: 0.4s; }
        .contact-form-group:nth-child(3) { animation-delay: 0.6s; }
        .contact-form-group:nth-child(4) { animation-delay: 0.8s; }
        .contact-form-group:nth-child(5) { animation-delay: 1.0s; }
        .contact-form-group:nth-child(6) { animation-delay: 1.2s; }

        /* Checkbox styling */
        .checkgroup {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkgroup input {
            width: auto;
            margin-right: 10px;
        }

        .checkgroup label {
            margin-bottom: 0;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInFromLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInFromRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInFromTop {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            70% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-box {
                padding: 2rem 1.5rem;
            }

            .contact-form-group:nth-child(odd),
            .contact-form-group:nth-child(even) {
                animation: slideInFromBottom 0.6s ease-out forwards;
            }

            @keyframes slideInFromBottom {
                from { opacity: 0; transform: translateY(50px); }
                to { opacity: 1; transform: translateY(0); }
            }
        }

        @media (min-width: 768px) {
            .nav {
                display: none;
            }
        }
    </style>

    <!-- Mobile Navigation -->
    <nav class="nav">
        <a href="https://kredox.org/" class="nav__link">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="https://kredox.org/about" class="nav__link">
            <i class="material-icons nav__icon">info</i>
            <span class="nav__text">About</span>
        </a>
        <a href="https://kredox.org/how-it-works" class="nav__link">
            <i class="material-icons nav__icon">help</i>
            <span class="nav__text">How It Works</span>
        </a>
        <a href="https://kredox.org/contact" class="nav__link">
            <i class="material-icons nav__icon">mail</i>
            <span class="nav__text">Contact</span>
        </a>
        <a href="https://kredox.org/user/dashboard" class="nav__link nav__link--active">
            <i class="material-icons nav__icon">login</i>
            <span class="nav__text">Login</span>
        </a>
    </nav>

    <div class="login-container">
        <div class="video-background">
            <video autoplay muted loop id="myVideo">
                <source src="https://kredox.org/All-Media/Dashboard.webm" type="video/mp4">
            </video>
        </div>

        <div style="margin-top: 60px" class="login-box">
            <div class="top w-100 text-center">
                <a href="{{ route('home') }}" class="account-logo">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')">
                </a>
            </div>

            <form method="POST" action="{{ route('user.data.submit') }}" class="contact-form row verify-gcaptcha">
                @csrf

                <div class="col-md-12 contact-form-group">
                    <label>@lang('First Name')</label>
                    <input type="text" name="firstname" class="checkUser" placeholder="@lang('First Name')" value="{{ old('firstname') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <label>@lang('Last Name')</label>
                    <input type="text" name="lastname" class="checkUser" placeholder="@lang('Last Name')" value="{{ old('lastname') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <label>@lang('Address')</label>
                    <input type="text" name="address" class="checkUser" placeholder="@lang('Address')" value="{{ old('address') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <label>@lang('State')</label>
                    <input type="text" name="state" class="checkUser" placeholder="@lang('State')" value="{{ old('state') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <label>@lang('Zip Code')</label>
                    <input type="text" name="zip" class="checkUser" placeholder="@lang('Zip Code')" value="{{ old('zip') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <label>@lang('City')</label>
                    <input type="text" name="city" class="checkUser" placeholder="@lang('City')" value="{{ old('city') }}" required>
                </div>

                <div class="col-md-12 contact-form-group">
                    <button type="submit" class="mt-3">@lang('submit')</button>
                </div>
            </form>
        </div>
    </div>

@endsection
