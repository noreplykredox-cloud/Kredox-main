@extends($activeTemplate . 'layouts.app')
@section('panel')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <nav class="nav">
        <a href="https://yukotrader.com/" class="nav__link">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="https://yukotrader.com/about" class="nav__link nav__link">
            <i class="material-icons nav__icon">settings_accessibility</i>
            <span class="nav__text">About Us</span>
        </a>
        <a href="https://yukotrader.com/how-it-works" class="nav__link">
            <i class="material-icons nav__icon">receipt_long</i>
            <span class="nav__text">How it Works</span>
        </a>
        <a href="https://yukotrader.com/contact" class="nav__link">
            <i class="material-icons nav__icon">connect_without_contact</i>
            <span class="nav__text">Contact</span>
        </a>
        <a href="https://yukotrader.com/user/dashboard" class="nav__link">
            <i class="material-icons nav__icon">input</i>
            <span class="nav__text">Login/Signup</span>
        </a>
    </nav>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: #f4f4f9;
        }

        .nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 55px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            background: -webkit-linear-gradient(-90deg, #124656 0%, #063a4a 45%, #063b46 100%);
            display: flex;
            overflow-x: auto;
            z-index: 2;
        }

        .nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            min-width: 50px;
            overflow: hidden;
            white-space: nowrap;
            font-size: 13px;
            color: #e1d4d4;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            transition: background-color 0.1s ease-in-out;
        }

        .nav__link:hover {
            background-color: #eeeeee;
        }

        .nav__link--active {
            color: #009578;
        }

        .nav__icon {
            font-size: 21px;
        }

        @media screen and (min-width: 600px) {
            .nav {
                display: none;
            }
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
             background-size: cover;
    background-image: url(https://t4.ftcdn.net/jpg/07/05/25/85/360_F_705258557_3L5bAIeNgPXvFGwvqQPhhy7LOnBLSBMr.jpg);
    background-repeat: no-repeat;
        }

        .login-box {
            background-color: white;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            background: radial-gradient(#685731, transparent);
    border: 1px solid #f1f1f1;
    backdrop-filter: url(https://t4.ftcdn.net/jpg/07/05/25/85/360_F_705258557_3L5bAIeNgPXvFGwvqQPhhy7LOnBLSBMr.jpg);
        }

        .login-box h3 {
    margin-bottom: 3rem;
    color: #d7cfcf;
}
.login-box label {
    display: block;
    text-align: left;
    margin-bottom: 0.5rem;
    color: #e2d2ff;
}

        .login-box input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-box button {
            width: 100%;
            padding: 0.75rem;
            background-color: #009578;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-box button:hover {
            background-color: #007a5c;
        }

        .login-box a {
            color: #009578;
            text-decoration: none;
        }

        .login-box p {
            margin-top: 1rem;
            color: #666;
        }
    </style>

    <div class="login-container">
        <div class="login-box">
            <div class="top w-100 text-center">
                <a href="{{ route('home') }}" class="account-logo"><img
                        src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')"></a>
            </div>
            <h3>@lang('Sign In to your account')</h3>
            <form method="POST" action="{{ route('user.login') }}" class="contact-form verify-gcaptcha">
                @csrf
                <div>
                    <label>@lang('Username or Email')</label>
                    <input type="text" value="{{ old('username') }}" id="username" name="username" required>
                </div>
                <div>
                    <label>@lang('Your Password')</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <x-captcha />
                </div>
                <div>
                    <button type="submit">@lang('Sign In')</button>
                </div>
                <p>@lang("Don'\t have an account?") <a href="{{ route('user.register') }}" class="text-theme">@lang('Sign Up')</a></p>
                <p><a href="{{ route('user.password.request') }}" class="text-theme">@lang('Forgot Password')</a></p>
            </form>
        </div>
    </div>
@endsection
