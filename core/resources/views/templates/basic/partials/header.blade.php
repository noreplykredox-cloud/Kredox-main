<style>
    :root {
        --trx-dark: #050505;
        --trx-red: #E60000;
        --trx-red-glow: rgba(230, 0, 0, 0.4);
        --trx-white: #ffffff;
    }

    .trx-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background: rgba(5, 5, 5, 0.6);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 2px solid rgba(255, 0, 0, 0.35);
        box-shadow: 0 4px 20px rgba(255, 0, 0, 0.25);
        transition: all 0.4s ease;
    }

    .trx-header.scrolled {
        background: rgba(0, 0, 0, 0.95);
        border-bottom: 2px solid rgba(255, 0, 0, 0.6);
        box-shadow: 0 8px 30px rgba(255, 0, 0, 0.45), 0 4px 15px rgba(0, 0, 0, 0.7);
    }

    .trx-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .trx-header-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 80px;
        transition: height 0.4s ease;
    }

    .trx-header.scrolled .trx-header-wrapper {
        height: 70px;
    }

    .trx-logo {
        position: relative;
        z-index: 2001;
    }

    .trx-logo img {
        height: 178px;
        max-width: 99%;
        filter: drop-shadow(0 0 8px var(--trx-red-glow));
    }

    .trx-nav {
        display: flex;
        align-items: center;
        gap: 35px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .trx-nav-link {
        color: var(--trx-white);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        position: relative;
        padding: 5px 0;
        transition: color 0.3s ease;
    }

    .trx-nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 2px;
        background: var(--trx-red);
        transition: width 0.3s ease;
        box-shadow: 0 0 8px var(--trx-red);
    }

    .trx-nav-link:hover {
        color: var(--trx-white);
    }

    .trx-nav-link:hover::after {
        width: 100%;
    }

    .trx-actions {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 2001;
    }

    .trx-btn-outline {
        border: 1px solid rgba(255, 0, 0, 0.4);
        background: transparent;
        color: var(--trx-white);
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .trx-btn-outline:hover {
        background: rgba(255, 0, 0, 0.05);
        border-color: var(--trx-red);
        color: var(--trx-white);
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
    }

    .trx-btn-primary {
        background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
        color: var(--trx-white);
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        text-decoration: none;
        box-shadow: 0 5px 15px var(--trx-red-glow);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .trx-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5);
        color: var(--trx-white);
    }

    /* Hamburger Menu */
    .trx-hamburger {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 32px;
        height: 22px;
        cursor: pointer;
    }

    .trx-hamburger span {
        width: 100%;
        height: 2px;
        background: var(--trx-white);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .trx-hamburger.active span:nth-child(1) {
        transform: translateY(10px) rotate(45deg);
        background: var(--trx-red);
    }

    .trx-hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .trx-hamburger.active span:nth-child(3) {
        transform: translateY(-10px) rotate(-45deg);
        background: var(--trx-red);
    }

    .trx-mobile-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(5, 5, 5, 0.85);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        z-index: 3000;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform: scale(1.05);
    }

    .trx-close-btn {
        position: absolute;
        top: 25px;
        right: 30px;
        font-size: 45px;
        color: var(--trx-white);
        cursor: pointer;
        line-height: 1;
        transition: transform 0.3s ease, color 0.3s ease, text-shadow 0.3s ease;
        z-index: 3001;
    }

    .trx-close-btn:hover {
        color: var(--trx-red);
        transform: rotate(90deg) scale(1.1);
        text-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
    }

    .trx-mobile-overlay.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .trx-mobile-nav {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0;
        width: 80%;
        max-width: 350px;
    }

    .trx-mobile-nav>li {
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .trx-mobile-nav>li:last-child {
        border-bottom: none;
    }

    .trx-mobile-nav-link {
        display: block;
        font-size: 18px;
        font-weight: 800;
        color: var(--trx-white);
        text-transform: uppercase;
        letter-spacing: 2px;
        text-decoration: none;
        padding: 20px 0;
        width: 100%;
        text-align: center;
        border: none;
        background: transparent;
        transition: all 0.3s ease;
    }

    .trx-mobile-nav-link:hover {
        color: var(--trx-red);
        background: rgba(255, 255, 255, 0.02);
    }

    @media (max-width: 991px) {
        .trx-nav {
            display: none;
        }

        .trx-actions .trx-btn-outline,
        .trx-actions .trx-btn-primary {
            display: none;
        }

        .trx-hamburger {
            display: flex;
        }

        .trx-actions {
            gap: 15px;
        }

        .trx-logo img {
            height: 132px;
        }

        .trx-header-wrapper {
            height: 65px;
        }

        .trx-header.scrolled .trx-header-wrapper {
            height: 60px;
        }
    }
</style>

@php
    $userAgent = request()->header('User-Agent');
    $isApp = strpos($userAgent, 'trxApp') !== false;
@endphp

<div class="trx-mobile-overlay" id="trxMobileMenu">
    <div class="trx-close-btn" id="trxCloseBtn">&times;</div>
    <ul class="trx-mobile-nav">
        <li><a href="{{ route('home') }}" class="trx-mobile-nav-link">Home</a></li>
        <li><a href="#about-section" class="trx-mobile-nav-link">Institution</a></li>
        <li><a href="#how-it-works" class="trx-mobile-nav-link">Protocol</a></li>
        <li><a href="{{ route('contact') }}" class="trx-mobile-nav-link">Support</a></li>

        <li
            style="display: flex; flex-direction: column; align-items: center; gap: 15px; margin-top: 30px; padding-bottom: 20px;">
            @guest
                <a href="{{ route('user.login') }}" class="trx-mobile-nav-link"
                    style="border: 1px solid rgba(255,0,0,0.3); background: rgba(255,0,0,0.05); font-size: 15px; padding: 14px 0; border-radius: 8px;"><i
                        class="fas fa-fingerprint" style="margin-right: 8px;"></i> Secure Login</a>
                <a href="{{ route('user.register') }}" class="trx-mobile-nav-link"
                    style="background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%); border: none; box-shadow: 0 5px 15px rgba(230,0,0,0.4); font-size: 15px; padding: 14px 0; border-radius: 8px;"><i
                        class="fas fa-user-plus" style="margin-right: 8px;"></i> Sign Up</a>
            @endguest

            @auth
                <a href="{{ route('user.home') }}" class="trx-mobile-nav-link"
                    style="background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%); border: none; box-shadow: 0 5px 15px rgba(230,0,0,0.4); font-size: 15px; padding: 14px 0; border-radius: 8px;"><i
                        class="fas fa-th-large" style="margin-right: 8px;"></i> Dashboard</a>
            @endauth
        </li>
    </ul>
</div>

<header class="trx-header" id="trxHeader">
    <div class="trx-container">
        <div class="trx-header-wrapper">
            <div class="trx-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="TRX Logo">
                </a>
            </div>

            <ul class="trx-nav">
                <li><a href="{{ route('home') }}" class="trx-nav-link">Home</a></li>
                <li><a href="#about-section" class="trx-nav-link">Institution</a></li>
                <li><a href="#how-it-works" class="trx-nav-link">Protocol</a></li>
                <li><a href="{{ route('contact') }}" class="trx-nav-link">Support</a></li>
            </ul>

            <div class="trx-actions">
                @guest
                    <a href="{{ route('user.login') }}" class="trx-btn-outline">
                        <i class="fas fa-fingerprint"></i> Secure Login
                    </a>
                @endguest

                @auth
                    <a href="{{ route('user.home') }}" class="trx-btn-outline">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                @endauth

                <!-- Hamburger Button -->
                <div class="trx-hamburger" id="trxHamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Header Scroll Effect
    window.addEventListener('scroll', function () {
        const header = document.getElementById('trxHeader');
        if (window.scrollY > 30) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Isolated Mobile Menu Logic
    const hamburger = document.getElementById('trxHamburger');
    const mobileMenu = document.getElementById('trxMobileMenu');
    const mobileLinks = document.querySelectorAll('.trx-mobile-nav-link');
    const closeBtn = document.getElementById('trxCloseBtn');

    hamburger.addEventListener('click', () => {
        hamburger.classList.add('active');
        mobileMenu.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    closeBtn.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    });

    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    });
</script>