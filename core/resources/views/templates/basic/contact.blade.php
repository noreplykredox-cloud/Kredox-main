@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/" class="nav__link">
    <i class="material-icons nav__icon">home</i>
    <span class="nav__text">Home</span>
  </a>
  <a href="https://yukotrader.com/about" class="nav__link nav__link">
    <i class="material-icons nav__icon">settings_accessibility</i>
    <span class="nav__text">About-Us</span>
  </a>
  <a href="https://yukotrader.com/how-it-works" class="nav__link">
    <i class="material-icons nav__icon">receipt_long</i>
    <span class="nav__text">how it works</span>
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
    margin: 0 0 55px 0;
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
    z-index:2;
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
    font-family: sans-serif;
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

  </style>
    <div class="contact-section padding-top padding-bottom">
        <div class="container">
            <div class="row g-4 justify-content-center mb-5">
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Phone')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a
                                        href="Tel:{{ @$content->data_values->contact_number }}">{{ __(@$content->data_values->contact_number) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Email')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a
                                        href="mailto:{{ __(@$content->data_values->email_address) }}">{{ __(@$content->data_values->email_address) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact__item">
                        <div class="contact__icon">
                            <i class="fas fa-map-marker"></i>
                        </div>
                        <div class="contact__body">
                            <h5 class="contact__title">@lang('Address')</h5>
                            <ul class="contact__info">
                                <li>
                                    <a href="javascript:void(0)">{{ __(@$content->data_values->contact_address) }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-wrapper">
                <h3 class="title text-center cl-white mb-20 mb-lg-4">{{ __(@$content->data_values->title) }}</h3>
                <form class="contact-form row mb--25 verify-gcaptcha" action="" method="POST">
                    @csrf
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Name')</label>
                            <input type="text" placeholder="@lang('Enter Name')" id="name"
                                value="@if (auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif"
                                @if (auth()->user()) readonly @endif required name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label>@lang('Email')</label>
                            <input type="email" placeholder="@lang('Enter Email')" id="email"
                                value="@if (auth()->user()) {{ auth()->user()->email }} @else {{ old('email') }} @endif"
                                @if (auth()->user()) readonly @endif required name="email">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Subject')</label>
                            <input type="text" placeholder="@lang('Enter Subject')" id="subject"
                                value="{{ old('subject') }}" required name="subject">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <label>@lang('Message')</label>
                            <textarea name="message" id="message" placeholder="@lang('Enter Message')" required="">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <x-captcha />
                    </div>

                    <div class="col-md-12">
                        <div class="contact-form-group">
                            <button type="submit" class="w-100">@lang('Send Message')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
