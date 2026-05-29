<!doctype html>
<html lang="{{ config('app.locale') }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}" />

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/owl.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    @stack('style-lib')

    @stack('style')

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">
</head>

<body>

    @stack('fbComment')

    <div class="overlay"></div>

    <a href="{{ route('home') }}" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <style>
        /* Enhanced VIP Orbital Preloader */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #020202;
            /* Deep Black */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999999;
        }

        .orbital-loader {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .orbit {
            position: absolute;
            border-radius: 50%;
            border: 2px solid transparent;
            box-sizing: border-box;
            filter: drop-shadow(0 0 10px rgba(255, 0, 0, 0.5));
        }

        .orbit-1 {
            width: 100%;
            height: 100%;
            border-top-color: #ff0000;
            border-bottom-color: #ff3333;
            animation: spinOrbit 4s linear infinite;
        }

        .orbit-2 {
            width: 75%;
            height: 75%;
            border-left-color: #ff4d4d;
            border-right-color: #990000;
            animation: spinOrbitReverse 3s linear infinite;
            filter: drop-shadow(0 0 8px rgba(255, 51, 51, 0.4));
        }

        .orbit-3 {
            width: 50%;
            height: 50%;
            border-top-color: #ffffff;
            border-bottom-color: #ff0000;
            animation: spinOrbit 2s linear infinite;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3));
        }

        .loader-center-icon {
            position: absolute;
            font-size: 28px;
            color: #ffffff;
            animation: pulseGlow 1.5s ease-in-out infinite;
            text-shadow: 0 0 15px #ff0000, 0 0 25px #ff3333;
            z-index: 10;
        }

        @keyframes spinOrbit {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes spinOrbitReverse {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                transform: scale(0.9);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
                text-shadow: 0 0 20px #ff0000, 0 0 35px #ff0000, 0 0 45px #ff3333;
            }
        }

        /* Premium Logout Modal */
        .logout-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000000;
        }

        .logout-modal-overlay.active {
            display: flex;
        }

        .logout-modal-content {
            background: #0a0a0a;
            border: 1px solid rgba(255, 0, 0, 0.2);
            border-radius: 20px;
            padding: 35px;
            width: 90%;
            max-width: 380px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9), 0 0 30px rgba(255, 0, 0, 0.1);
            animation: modalIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .logout-modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #ff0000;
            box-shadow: 0 0 15px #ff0000;
            border-radius: 20px 20px 0 0;
        }

        @keyframes modalIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .logout-icon-box {
            width: 70px;
            height: 70px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #ff0000;
            font-size: 32px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.1);
        }

        .logout-modal-content h2 {
            color: white;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .logout-modal-content p {
            color: #888;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .logout-modal-footer {
            display: flex;
            gap: 12px;
        }

        .btn-logout-cancel,
        .btn-logout-confirm {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-logout-cancel {
            background: #1a1a1a;
            color: white;
            border: 1px solid #333;
        }

        .btn-logout-cancel:hover {
            background: #222;
        }

        .btn-logout-confirm {
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
            color: white !important;
            border: none;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.2);
        }

        .btn-logout-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(255, 0, 0, 0.4);
        }
    </style>
    <div class="preloader">
        <div class="orbital-loader">
            <div class="orbit orbit-1"></div>
            <div class="orbit orbit-2"></div>
            <div class="orbit orbit-3"></div>
            <i class="fas fa-network-wired loader-center-icon"></i>
        </div>
    </div>

    @yield('panel')


    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a
                    href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <button class="btn cmn-btn w-100 policy btn--base btn-lg">@lang('Allow')</button>
            </div>
        </div>
        <!-- cookies dark version end -->
    @endif


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <!-- magnific popup plugin -->
    <script src="{{ asset($activeTemplateTrue . 'js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/owl.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/nice-select.js') }}"></script>

    <!-- dashboard custom js -->
    <script src="{{ asset($activeTemplateTrue . 'js/app.js') }}"></script>

    @stack('script-lib')

    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')


    <script>
        (function ($) {
            "use strict";
            $(".langSel").on("change", function () {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            var inputElements = $('input,select');
            $.each(inputElements, function (index, element) {
                element = $(element);
                var type = element.attr('type');
                if (type != 'checkbox') {
                    element.closest('.contact-form-group').find('label').attr('for', element.attr('name'));
                    element.attr('id', element.attr('name'))
                }
            });

            $('.policy').on('click', function () {
                $.get('{{ route('cookie.accept') }}', function (response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function () {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            $.each($('input, select, textarea'), function (i, element) {
                if (element.hasAttribute('required') && $(element).attr('type') != 'checkbox') {
                    $(element).closest('.contact-form-group').find('label').addClass('required');
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });

            $('.showFilterBtn').on('click', function () {
                $('.responsive-filter-card').slideToggle();
            });

            // Global Logout Interceptor
            $(document).on('click', 'a[href*="logout"]:not(#confirmLogoutBtn)', function (e) {
                e.preventDefault();
                const logoutUrl = $(this).attr('href');
                $('#confirmLogoutBtn').attr('href', logoutUrl);
                $('#logoutModalOverlay').addClass('active');
            });

            window.closeLogoutModal = function () {
                $('#logoutModalOverlay').removeClass('active');
            };

            // Close on outside click
            $('#logoutModalOverlay').on('click', function (e) {
                if (e.target === this) closeLogoutModal();
            });

            Array.from(document.querySelectorAll('table')).forEach(table => {
                let heading = table.querySelectorAll('thead tr th');
                Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                    Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                        colum.setAttribute('data-label', heading[i].innerText)
                    });
                });
            });

        })(jQuery);
    </script>

    <!-- Logout Modal Structure -->
    <div class="logout-modal-overlay" id="logoutModalOverlay">
        <div class="logout-modal-content">
            <div class="logout-icon-box">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h2>Taking a Break?</h2>
            <p>Are you sure you want to log out? We'll save your spot and keep everything ready for your next session!
            </p>
            <div class="logout-modal-footer">
                <button class="btn-logout-cancel" onclick="closeLogoutModal()">No, Stay</button>
                <a href="{{ route('user.logout') }}" class="btn-logout-confirm" id="confirmLogoutBtn">Yes, Logout</a>
            </div>
        </div>
    </div>

</body>

</html>