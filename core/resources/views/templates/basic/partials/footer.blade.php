@php
    $footerMenu = getContent('policy_pages.element', false);
@endphp

<style>
    .footer-section {
        background: #000000 !important;
        border-top: 1px solid rgba(255, 0, 0, 0.1);
        padding: 80px 0 30px;
        position: relative;
        overflow: hidden;
    }

    /* Animated Tech Background */
    .footer-tech-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 10% 10%, rgba(255, 0, 0, 0.03) 0%, transparent 20%),
            radial-gradient(circle at 90% 90%, rgba(255, 0, 0, 0.03) 0%, transparent 20%),
            linear-gradient(rgba(255, 255, 255, 0.01) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.01) 1px, transparent 1px);
        background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
        z-index: 1;
        pointer-events: none;
        animation: gridMove 20s linear infinite;
    }

    @keyframes gridMove {
        0% { background-position: 0 0, 0 0, 0 0, 0 0; }
        100% { background-position: 0 0, 0 0, 40px 40px, 40px 40px; }
    }

    .footer-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #ff0000, transparent);
        box-shadow: 0 0 15px #ff0000;
        z-index: 2;
        animation: scanLine 4s ease-in-out infinite;
    }

    @keyframes scanLine {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0%); }
        100% { transform: translateX(100%); }
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr 1fr;
        gap: 30px;
        position: relative;
        z-index: 5;
        margin: 0 auto 30px;
        max-width: 1140px;
    }

    .footer-col-title {
        color: #fff;
        font-size: 13px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .footer-col-title i {
        color: #ff0000;
        font-size: 16px;
        text-shadow: 0 0 10px #ff0000;
    }

    .footer-about-text {
        color: #888;
        font-size: 15px;
        line-height: 1.8;
        margin-bottom: 25px;
    }

    /* List Styling */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 25px;
    }

    .footer-links li a {
        color: #666;
        text-decoration: none !important;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-links li a::before {
        content: '▹';
        color: #ff0000;
        opacity: 0.5;
    }

    .footer-links li a:hover {
        color: #fff;
        transform: translateX(5px);
        text-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
    }

    /* Column 2 - Core focus */
    .service-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .service-card:hover {
        background: rgba(255, 0, 0, 0.03);
        border-color: rgba(255, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .service-card h6 {
        color: #fff;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 5px;
        letter-spacing: 1px;
    }

    .service-card p {
        color: #666;
        font-size: 12px;
        margin-bottom: 0;
    }

    /* Column 3 - Brand & App */
    .footer-brand-hub {
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .footer-logo img {
        max-width: 150px;
        margin-bottom: 15px;
        filter: drop-shadow(0 0 10px rgba(255, 0, 0, 0.2));
        transition: all 0.5s ease;
    }

    .footer-logo:hover img {
        transform: scale(1.05);
        filter: drop-shadow(0 0 25px rgba(255, 0, 0, 0.4));
    }

    .logo-description {
        color: #666;
        font-size: 16px;
        line-height: 1.4;
        margin-bottom: 15px;
        max-width: 220px;
        font-weight: 500;
    }

    .app-cta {
        color: #ff0000;
        font-size: 9px;
        font-weight: 900;
        margin-bottom: 10px;
        letter-spacing: 1px;
        text-transform: uppercase;
        opacity: 0.9;
        text-shadow: 0 0 5px rgba(255, 0, 0, 0.2);
    }

    .footer-apk-btn {
        background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
        color: white !important;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 900;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 25px rgba(255, 0, 0, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-apk-btn:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px rgba(255, 0, 0, 0.5);
        filter: brightness(1.2);
    }

    .footer-apk-btn i {
        font-size: 14px;
        animation: pulsePhone 2s infinite;
    }

    @keyframes pulsePhone {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    /* Bottom Bar */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 5;
        max-width: 1140px;
        margin: 0 auto;
    }

    .copyright {
        color: #444;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .copyright a {
        color: #ff0000;
        font-weight: 900;
        text-decoration: none;
    }

    .payment-icons {
        display: flex;
        gap: 20px;
        opacity: 0.3;
        filter: grayscale(1);
        transition: all 0.3s ease;
    }

    .payment-icons:hover {
        opacity: 0.7;
        filter: grayscale(0);
    }

    .payment-icons i {
        font-size: 18px;
        color: #fff;
    }

    @media (max-width: 1199px) {
        .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
        .footer-brand-hub { grid-column: span 2; align-items: center; text-align: center; margin-top: 20px; }
    }

    @media (max-width: 767px) {
        .footer-section { padding: 50px 0 20px; }
        .footer-grid { grid-template-columns: 1fr; gap: 40px; }
        .footer-brand-hub { grid-column: span 1; }
        .footer-links { grid-template-columns: 1fr; }
        .footer-bottom { flex-direction: column; gap: 20px; text-align: center; }
    }
</style>

<footer class="footer-section">
    <div class="footer-tech-bg"></div>

    <div class="container">
        <div class="footer-grid">
            <!-- Column 1: Institutional Core -->
            <div class="footer-col">
                <h4 class="footer-col-title"><i class="fas fa-university"></i> Institutional Hub</h4>
                <p class="footer-about-text">
                    The world's most advanced ecosystem for professional decentralized asset management and secure institutional-grade trading protocols.
                </p>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Terminal Home</a></li>
                    <li><a href="{{ route('contact') }}">Elite Support</a></li>
                    @foreach($footerMenu as $policy)
                        <li>
                            <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">
                                {{__($policy->data_values->title)}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Column 2: Security & Infrastructure -->
            <div class="footer-col">
                <h4 class="footer-col-title"><i class="fas fa-shield-check"></i> Security Protocol</h4>
                <div class="service-card">
                    <h6>End-to-End Encryption</h6>
                    <p>AES-256 institutional standard</p>
                </div>
                <div class="service-card">
                    <h6>Cold Storage Vaults</h6>
                    <p>Distributed asset architecture</p>
                </div>
                <div class="service-card">
                    <h6>Real-time Monitoring</h6>
                    <p>24/7 AI-driven threat detection</p>
                </div>
            </div>

            <!-- Column 3: Command Center -->
            <div class="footer-col footer-brand-hub">
                <p class="logo-description">The global benchmark for institutional decentralized asset management and secure trading.</p>
                <p class="app-cta">Command Terminal Access</p>
                <a href="https://kredox.org/All-Media/kredox.apk" class="footer-apk-btn">
                    <i class="fas fa-mobile-alt"></i>
                    <span>DOWNLOAD MOBILE APK v2.4</span>
                </a>

                <div class="footer-logo mt-4">
                    <a href="{{ route('home') }}">
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="TRX Logo">
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                &copy; {{ date('Y') }} Institutional Access. Global Markets Ecosystem. 
                Powered By <a href="{{route('home')}}">{{__($general->site_name)}}</a>
            </div>
            
            <div class="payment-icons">
                <i class="fab fa-bitcoin"></i>
                <i class="fab fa-ethereum"></i>
                <i class="fas fa-coins"></i>
                <i class="fas fa-credit-card"></i>
            </div>
        </div>
    </div>
</footer>
