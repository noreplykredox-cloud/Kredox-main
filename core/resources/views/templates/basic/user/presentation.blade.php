@extends(request()->routeIs('user.presentation') ? $activeTemplate . 'layouts.master' : $activeTemplate . 'layouts.frontend')

@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Outfit:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --cyber-bg: #050204;
            --cyber-card: rgba(12, 5, 8, 0.92);
            --cyber-cyan: #ff003c;
            --cyber-cyan-glow: rgba(255, 0, 60, 0.5);
            --cyber-red: #ff003c;
            --cyber-red-glow: rgba(255, 0, 60, 0.6);
            --cyber-gold: #ffb700;
            --cyber-gold-glow: rgba(255, 183, 0, 0.4);
            --cyber-green: #00ff88;
            --cyber-green-glow: rgba(0, 255, 136, 0.4);
            --font-tech: 'Orbitron', sans-serif;
            --font-main: 'Outfit', sans-serif;
        }

        @if (!request()->routeIs('user.presentation'))
        /* Public Page View Layout Adjustments (Without Dashboard Sidebar) */
        .ppt-page-container {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 95px 20px 30px 20px !important;
            box-sizing: border-box;
            transition: all 0.3s ease;
            min-height: calc(100vh - 20px);
            display: flex;
            flex-direction: column;
        }

        footer,
        .footer,
        .footer-area,
        .footer-section,
        .footer-wrapper,
        .site-footer {
            display: block !important;
        }
        @else
        /* Hide Website / Dashboard Footer on Dashboard Presentation Page */
        footer,
        .footer,
        .footer-area,
        .footer-section,
        .footer-wrapper,
        .dashboard-footer,
        .site-footer {
            display: none !important;
        }

        /* Container Layout Offset for Sidebar */
        .ppt-page-container {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 10px 15px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            min-height: calc(100vh - 20px);
            display: flex;
            flex-direction: column;
        }
        @endif

        @media (max-width: 1024px) {
            .ppt-page-container {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 10px !important;
            }
        }

        .cyber-ppt-wrapper {
            background: #050204 url("{{ asset('assets/images/ppt/cyber_bg.jpg') }}") no-repeat center center / cover;
            color: #ffffff;
            font-family: var(--font-main);
            border-radius: 20px;
            padding: 15px 20px;
            border: 1px solid rgba(255, 0, 60, 0.45);
            box-shadow: 0 0 60px rgba(0, 0, 0, 0.95), inset 0 0 40px rgba(255, 0, 60, 0.12);
            position: relative;
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: calc(100vh - 45px);
        }

        /* Animated Video-like Grid & Ambient Overlay */
        .cyber-grid-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(12, 4, 8, 0.6) 0%, rgba(5, 2, 4, 0.96) 100%),
                linear-gradient(rgba(255, 0, 60, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 0, 60, 0.06) 1px, transparent 1px);
            background-size: 100% 100%, 40px 40px, 40px 40px;
            pointer-events: none;
            z-index: 0;
            animation: redVideoPulse 6s ease-in-out infinite alternate;
        }

        @keyframes redVideoPulse {
            0% {
                opacity: 0.8;
                filter: brightness(1) drop-shadow(0 0 10px rgba(255, 0, 60, 0.2));
            }

            100% {
                opacity: 1;
                filter: brightness(1.3) drop-shadow(0 0 30px rgba(255, 0, 60, 0.5));
            }
        }

        .hud-compass {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 1px dashed rgba(255, 0, 60, 0.25);
            border-radius: 50%;
            pointer-events: none;
            animation: rotateHud 35s linear infinite;
        }

        .hud-compass.top-right {
            top: -100px;
            right: -100px;
        }

        .hud-compass.bottom-left {
            bottom: -100px;
            left: -100px;
            animation-direction: reverse;
        }

        @keyframes rotateHud {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Header Control Bar */
        .ppt-control-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 0, 60, 0.25);
            position: relative;
            z-index: 2;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ppt-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ppt-brand-icon {
            background: linear-gradient(135deg, var(--cyber-red), var(--cyber-gold));
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-tech);
            font-weight: 900;
            font-size: 16px;
            color: #fff;
            box-shadow: 0 0 15px var(--cyber-red-glow);
        }

        .ppt-brand-name {
            font-family: var(--font-tech);
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
        }

        .ppt-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cyber-btn {
            background: rgba(255, 0, 60, 0.1);
            border: 1px solid rgba(255, 0, 60, 0.4);
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 8px;
            font-family: var(--font-tech);
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
        }

        .cyber-btn:hover {
            background: var(--cyber-red);
            color: #fff;
            box-shadow: 0 0 20px var(--cyber-red-glow);
            transform: translateY(-2px);
        }

        .cyber-btn-gold {
            background: linear-gradient(135deg, var(--cyber-gold), #ff8800);
            color: #000;
            border: none;
            font-weight: 900;
        }

        .cyber-btn-gold:hover {
            background: linear-gradient(135deg, #fff, var(--cyber-gold));
            box-shadow: 0 0 25px var(--cyber-gold-glow);
            color: #000;
        }

        .cyber-btn-green {
            background: linear-gradient(135deg, rgba(0, 255, 136, 0.25), rgba(0, 180, 90, 0.5));
            border: 1px solid #00ff88;
            color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
            font-weight: 800;
        }

        .cyber-btn-green:hover {
            background: #00ff88;
            color: #000000;
            box-shadow: 0 0 25px rgba(0, 255, 136, 0.8);
        }

        .cyber-btn-cyan,
        .cyber-btn-red {
            background: linear-gradient(135deg, rgba(255, 0, 60, 0.25), rgba(180, 0, 40, 0.5));
            border: 1px solid var(--cyber-red);
            color: #ffffff;
            box-shadow: 0 0 15px rgba(255, 0, 60, 0.3);
            font-weight: 800;
        }

        .cyber-btn-cyan:hover,
        .cyber-btn-red:hover {
            background: var(--cyber-red);
            color: #ffffff;
            box-shadow: 0 0 25px var(--cyber-red-glow);
        }

        /* High-Tech Cyber Share Modal */
        .share-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(3, 1, 4, 0.88);
            backdrop-filter: blur(14px);
            z-index: 9999999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .share-modal-card {
            background: linear-gradient(145deg, rgba(14, 5, 10, 0.96), rgba(4, 1, 3, 0.98));
            border: 1.5px solid #00ff88;
            border-radius: 18px;
            padding: 28px 24px;
            box-shadow: 0 0 40px rgba(0, 255, 136, 0.35), inset 0 0 20px rgba(0, 255, 136, 0.15);
            max-width: 450px;
            width: 90%;
            position: relative;
            color: #ffffff;
            font-family: var(--font-main);
        }

        .share-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            border-bottom: 1px dashed rgba(0, 255, 136, 0.3);
            padding-bottom: 10px;
        }

        .share-modal-title {
            font-family: var(--font-tech);
            font-size: 16px;
            font-weight: 900;
            color: #00ff88;
            margin: 0;
            letter-spacing: 1px;
        }

        .share-modal-close {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 24px;
            cursor: pointer;
            line-height: 1;
            transition: color 0.2s ease;
        }

        .share-modal-close:hover {
            color: var(--cyber-red);
        }

        .share-modal-desc {
            font-size: 13px;
            color: #b0b7c7;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .share-options-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
        }

        .share-btn {
            border: none;
            border-radius: 10px;
            padding: 12px 14px;
            font-family: var(--font-tech);
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .share-btn.whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35);
        }

        .share-btn.telegram {
            background: linear-gradient(135deg, #0088cc, #005580);
            box-shadow: 0 4px 15px rgba(0, 136, 204, 0.35);
        }

        .share-btn.facebook {
            background: linear-gradient(135deg, #1877F2, #0d47a1);
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.35);
        }

        .share-btn.copylink {
            background: linear-gradient(135deg, #ff003c, #8b0000);
            box-shadow: 0 4px 15px rgba(255, 0, 60, 0.35);
        }

        .share-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.15);
        }

        .share-link-input-group {
            display: flex;
            align-items: center;
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(0, 255, 136, 0.4);
            border-radius: 10px;
            overflow: hidden;
        }

        .share-url-input {
            background: transparent;
            border: none;
            color: #00ff88;
            padding: 10px 12px;
            font-size: 12px;
            flex: 1;
            font-family: monospace;
        }

        .share-copy-btn {
            background: var(--cyber-green);
            border: none;
            color: #000;
            padding: 10px 16px;
            font-family: var(--font-tech);
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .share-copy-btn:hover {
            background: #ffffff;
        }

        .share-copy-success {
            margin-top: 10px;
            color: #00ff88;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            font-family: var(--font-tech);
        }

        .slide-counter-badge {
            font-family: var(--font-tech);
            font-size: 11px;
            font-weight: 700;
            color: #b0b7c7;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid rgba(255, 0, 60, 0.3);
        }

        .slide-counter-badge span {
            color: var(--cyber-red);
            font-size: 15px;
        }

        /* Official USDT Crypto Green Highlights */
        .usdt-green {
            color: #00ff88 !important;
            text-shadow: 0 0 25px rgba(0, 255, 136, 0.6) !important;
        }

        .cyber-hud-box.usdt {
            border-color: #00ff88 !important;
            box-shadow: 0 0 25px rgba(0, 255, 136, 0.35), inset 0 0 15px rgba(0, 255, 136, 0.1) !important;
        }

        .cyber-hud-number.usdt {
            color: #00ff88 !important;
            text-shadow: 0 0 25px rgba(0, 255, 136, 0.6) !important;
        }

        /* Slide Stage & Cards */
        .ppt-stage {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px 0;
            z-index: 2;
            min-height: 460px;
        }

        .cyber-slide {
            width: 100%;
            height: 100%;
            display: none;
            opacity: 0;
            transform: none !important;
            transition: opacity 0.2s ease-in-out;
        }

        .cyber-slide.active {
            display: block;
            opacity: 1;
            transform: none !important;
        }

        .cyber-card {
            background: radial-gradient(circle at 82% 50%, rgba(255, 0, 60, 0.16) 0%, rgba(12, 5, 8, 0.95) 65%),
                linear-gradient(rgba(255, 0, 60, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 30px 30px;
            border: 1px solid rgba(255, 0, 60, 0.45);
            border-radius: 18px;
            padding: 36px 40px;
            position: relative;
            backdrop-filter: blur(20px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9), inset 0 0 35px rgba(255, 0, 60, 0.12);
            min-height: 460px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        /* 3D Background Overlay Art inside Slide Cards */
        .slide-bg-art {
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 480px;
            height: 480px;
            object-fit: cover;
            border-radius: 24px;
            opacity: 0.88;
            filter: drop-shadow(0 0 50px rgba(255, 0, 60, 0.7));
            pointer-events: none;
            z-index: 1;
            mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 1) 48%, rgba(0, 0, 0, 0) 84%);
            -webkit-mask-image: radial-gradient(circle at center, rgba(0, 0, 0, 1) 48%, rgba(0, 0, 0, 0) 84%);
            transition: all 0.5s ease;
        }

        .slide-bg-art.gold {
            filter: drop-shadow(0 0 50px rgba(255, 183, 0, 0.7));
        }

        .slide-bg-art.red {
            filter: drop-shadow(0 0 50px rgba(255, 0, 60, 0.7));
        }

        @keyframes float3d {

            0%,
            100% {
                transform: translateY(-50%) rotate(0deg);
            }

            50% {
                transform: translateY(-54%) rotate(2deg);
            }
        }

        .floating-anim {
            animation: float3d 6s ease-in-out infinite;
        }

        /* Signature Sci-Fi Glowing Frame Box (Reference Image Style) */
        .cyber-hud-box {
            position: relative;
            background: rgba(0, 0, 0, 0.75);
            border: 2px solid var(--cyber-cyan);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 25px var(--cyber-cyan-glow), inset 0 0 15px rgba(0, 240, 255, 0.1);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .cyber-hud-box.gold {
            border-color: var(--cyber-gold);
            box-shadow: 0 0 25px var(--cyber-gold-glow), inset 0 0 15px rgba(255, 183, 0, 0.1);
        }

        .cyber-hud-box.red {
            border-color: var(--cyber-red);
            box-shadow: 0 0 25px var(--cyber-red-glow), inset 0 0 15px rgba(255, 0, 60, 0.1);
        }



        .cyber-hud-number {
            font-family: var(--font-tech);
            font-size: 60px;
            font-weight: 900;
            color: var(--cyber-gold);
            text-shadow: 0 0 25px var(--cyber-gold-glow);
            line-height: 1;
            margin-bottom: 8px;
        }

        .cyber-hud-number.cyan {
            color: var(--cyber-cyan);
            text-shadow: 0 0 25px var(--cyber-cyan-glow);
        }

        .cyber-hud-number.red {
            color: var(--cyber-red);
            text-shadow: 0 0 25px var(--cyber-red-glow);
        }

        .cyber-hud-label {
            font-family: var(--font-tech);
            font-size: 13px;
            letter-spacing: 2px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .website-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(90deg, rgba(0, 240, 255, 0.2), rgba(0, 0, 0, 0.8));
            border: 1px solid var(--cyber-cyan);
            color: var(--cyber-cyan);
            padding: 5px 16px;
            border-radius: 20px;
            font-family: var(--font-tech);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            box-shadow: 0 0 15px rgba(0, 240, 255, 0.2);
            margin-top: 12px;
        }

        /* Slide Titles */
        .slide-header-tag {
            font-family: var(--font-tech);
            font-size: 11px;
            color: var(--cyber-cyan);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .slide-header-tag::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--cyber-cyan);
            box-shadow: 0 0 8px var(--cyber-cyan);
            display: inline-block;
        }

        .slide-main-title {
            font-family: var(--font-tech);
            font-size: 28px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .slide-desc {
            font-size: 14px;
            color: #b0b7c7;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        /* Level Grid Items */
        .lvl-req-badge {
            font-size: 10.5px;
            color: var(--cyber-green);
            background: rgba(0, 255, 136, 0.12);
            padding: 3px 8px;
            border-radius: 6px;
            display: inline-block;
            font-weight: 600;
        }

        /* Bottom Thumbnail Bar */
        .ppt-thumb-bar {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            padding: 10px 4px 6px 4px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            scrollbar-width: none;
            /* Hide scrollbar Firefox */
            -ms-overflow-style: none;
            /* Hide scrollbar IE/Edge */
            -webkit-overflow-scrolling: touch;
        }

        .ppt-thumb-bar::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar Chrome/Safari/Opera */
        }

        .thumb-box {
            flex: 0 0 auto;
            min-width: 76px;
            padding: 6px 10px;
            background: rgba(0, 0, 0, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: var(--font-tech);
            font-size: 10px;
            color: #8a92a6;
            transition: all 0.25s ease;
            user-select: none;
            white-space: nowrap;
            text-align: center;
        }

        .thumb-box span {
            font-size: 8.5px;
            color: #7a8296;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
            white-space: nowrap;
            display: block;
        }

        .thumb-box.active,
        .thumb-box:hover {
            border-color: var(--cyber-cyan);
            background: rgba(0, 240, 255, 0.18);
            color: #ffffff;
            box-shadow: 0 0 14px var(--cyber-cyan-glow);
            transform: translateY(-2px);
        }

        .thumb-box.active span {
            color: var(--cyber-gold);
            font-weight: 700;
        }

        /* Micro Animations & Per-Slide Entrance Animations */
        .cyber-slide.active[data-slide="1"] .cyber-card {
            animation: slideAnimZoom 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="2"] .cyber-card {
            animation: slideAnimFlipY 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="3"] .cyber-card {
            animation: slideAnimScaleUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="4"] .cyber-card {
            animation: slideAnimRightGlow 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="5"] .cyber-card {
            animation: slideAnimLeftScan 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="6"] .cyber-card {
            animation: slideAnimStepBounce 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="7"] .cyber-card {
            animation: slideAnimRotateFlare 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="8"] .cyber-card {
            animation: slideAnimOrbitExpand 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="9"] .cyber-card {
            animation: slideAnimScanline 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="10"] .cyber-card {
            animation: slideAnimShieldLock 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .cyber-slide.active[data-slide="11"] .cyber-card {
            animation: slideAnimPortalBurst 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideAnimZoom {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
                filter: blur(6px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0);
            }
        }

        @keyframes slideAnimFlipY {
            0% {
                opacity: 0;
                transform: perspective(800px) rotateY(-15deg) translateY(-15px);
            }

            100% {
                opacity: 1;
                transform: perspective(800px) rotateY(0deg) translateY(0);
            }
        }

        @keyframes slideAnimScaleUp {
            0% {
                opacity: 0;
                transform: scale(0.92);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideAnimRightGlow {
            0% {
                opacity: 0;
                transform: translateX(30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideAnimLeftScan {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideAnimStepBounce {
            0% {
                opacity: 0;
                transform: translateY(-25px);
            }

            70% {
                transform: translateY(4px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideAnimRotateFlare {
            0% {
                opacity: 0;
                transform: rotate(-1.5deg) scale(0.96);
            }

            100% {
                opacity: 1;
                transform: rotate(0deg) scale(1);
            }
        }

        @keyframes slideAnimOrbitExpand {
            0% {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes slideAnimScanline {
            0% {
                opacity: 0;
                transform: translateY(15px);
                filter: brightness(1.8);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
                filter: brightness(1);
            }
        }

        @keyframes slideAnimShieldLock {
            0% {
                opacity: 0;
                transform: scale(1.04);
                filter: drop-shadow(0 0 30px rgba(255, 0, 60, 0.8));
            }

            100% {
                opacity: 1;
                transform: scale(1);
                filter: drop-shadow(0 0 0px transparent);
            }
        }

        @keyframes slideAnimPortalBurst {
            0% {
                opacity: 0;
                transform: scale(0.88);
                filter: drop-shadow(0 0 50px #00ff88);
            }

            100% {
                opacity: 1;
                transform: scale(1);
                filter: drop-shadow(0 0 0px transparent);
            }
        }

        .floating-anim {
            animation: float3D 5s ease-in-out infinite alternate;
        }

        @keyframes float3D {
            0% {
                transform: translateY(-50%) translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-50%) translateY(-12px) rotate(1.5deg);
            }

            100% {
                transform: translateY(-50%) translateY(6px) rotate(-1deg);
            }
        }

        .pulse-glow-green {
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.3) !important;
            animation: pulseGreen 3s infinite alternate !important;
        }

        @keyframes pulseGreen {
            0% {
                box-shadow: 0 0 15px rgba(0, 255, 136, 0.25);
            }

            100% {
                box-shadow: 0 0 35px rgba(0, 255, 136, 0.6);
            }
        }

        .pulse-glow-gold {
            box-shadow: 0 0 20px rgba(255, 183, 0, 0.3) !important;
            animation: pulseGold 3s infinite alternate !important;
        }

        @keyframes pulseGold {
            0% {
                box-shadow: 0 0 15px rgba(255, 183, 0, 0.25);
            }

            100% {
                box-shadow: 0 0 35px rgba(255, 183, 0, 0.6);
            }
        }

        .pulse-glow-red {
            box-shadow: 0 0 20px rgba(255, 0, 60, 0.3) !important;
            animation: pulseRed 3s infinite alternate !important;
        }

        @keyframes pulseRed {
            0% {
                box-shadow: 0 0 15px rgba(255, 0, 60, 0.25);
            }

            100% {
                box-shadow: 0 0 35px rgba(255, 0, 60, 0.6);
            }
        }

        .cyber-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 30px;
            font-family: var(--font-tech);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* High-Tech 4K Multi-Image Card Showcase */
        .multi-img-card {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid rgba(255, 0, 60, 0.55);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.9), 0 0 25px rgba(255, 0, 60, 0.35), inset 0 0 20px rgba(255, 0, 60, 0.2);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(145deg, rgba(16, 6, 12, 0.95), rgba(6, 2, 4, 0.98));
            backdrop-filter: blur(14px);
        }

        .multi-img-card:hover {
            transform: translateY(-7px) scale(1.03);
            border-color: #00ff88;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.95), 0 0 35px rgba(0, 255, 136, 0.6), inset 0 0 25px rgba(0, 255, 136, 0.35);
        }

        .multi-img-card img {
            width: 100%;
            height: 125px;
            object-fit: cover;
            display: block;
            filter: brightness(0.92) contrast(1.15) drop-shadow(0 4px 12px rgba(0, 0, 0, 0.7));
            transition: all 0.35s ease;
        }

        .multi-img-card:hover img {
            filter: brightness(1.15) contrast(1.25) drop-shadow(0 6px 18px rgba(0, 255, 136, 0.4));
            transform: scale(1.06);
        }

        .multi-img-badge {
            position: absolute;
            bottom: 6px;
            left: 6px;
            right: 6px;
            background: linear-gradient(135deg, rgba(6, 2, 5, 0.94) 0%, rgba(20, 5, 12, 0.96) 100%);
            border: 1px solid rgba(255, 0, 60, 0.5);
            padding: 6px 12px;
            border-radius: 8px;
            font-family: var(--font-tech);
            font-size: 10px;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.85), inset 0 0 12px rgba(255, 0, 60, 0.2), 0 0 10px rgba(255, 0, 60, 0.3);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.9), 0 0 18px rgba(255, 0, 60, 0.6);
            letter-spacing: 1.2px;
            transition: all 0.35s ease;
        }

        .multi-img-card:hover .multi-img-badge {
            border-color: #00ff88;
            background: linear-gradient(135deg, rgba(2, 12, 6, 0.95) 0%, rgba(4, 25, 12, 0.98) 100%);
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.5), inset 0 0 15px rgba(0, 255, 136, 0.3);
            text-shadow: 0 0 12px #00ff88, 0 0 25px rgba(0, 255, 136, 0.8);
            color: #00ff88;
        }

        /* Fullscreen Mode */
        .cyber-ppt-wrapper.fullscreen-mode {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999999 !important;
            border-radius: 0 !important;
            margin: 0 !important;
            padding: 15px 25px !important;
            max-width: 100vw !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }

        .cyber-ppt-wrapper.fullscreen-mode .ppt-stage {
            flex: 1 !important;
            margin: 12px 0 !important;
            min-height: 0 !important;
            height: auto !important;
            display: flex !important;
            align-items: stretch !important;
        }

        .cyber-ppt-wrapper.fullscreen-mode .cyber-card {
            flex: 1 !important;
            height: 100% !important;
            min-height: 0 !important;
            padding: 35px 45px !important;
            justify-content: center !important;
        }

        .cyber-ppt-wrapper.fullscreen-mode .slide-bg-art {
            width: 580px !important;
            height: 580px !important;
        }

        /* Realtime Background TradingView Canvas Styles */
        .trading-bg-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.32;
        }

        .mobile-counter {
            display: none;
        }

        @media (max-width: 768px) {
            .ppt-page-container {
                margin-left: 0 !important;
                width: 100% !important;
                padding: 8px 4px 4px 4px !important;
            }

            .cyber-ppt-wrapper {
                padding: 18px 12px 12px 12px;
                border-radius: 14px;
                min-height: auto;
            }

            .ppt-control-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding-bottom: 12px;
                padding-top: 4px;
            }

            .ppt-brand {
                width: 100%;
                justify-content: space-between;
            }

            .ppt-brand-name {
                font-size: 14px;
            }

            .desktop-counter {
                display: none !important;
            }

            .mobile-counter {
                display: inline-block !important;
            }

            .fullscreen-btn-desktop {
                display: none !important;
            }

            .ppt-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1.5fr 1fr;
                gap: 4px;
                margin-top: 6px;
            }

            .cyber-btn {
                padding: 7px 4px;
                font-size: 9.5px;
                justify-content: center;
                white-space: nowrap;
                width: 100%;
                box-sizing: border-box;
                letter-spacing: 0;
            }

            .cyber-btn i {
                font-size: 10px;
                margin-right: 3px;
            }

            .ppt-stage {
                min-height: auto;
                margin: 8px 0;
            }

            .cyber-card {
                padding: 18px 14px !important;
                min-height: auto !important;
                border-radius: 14px;
            }

            .slide-main-title {
                font-size: 20px !important;
                line-height: 1.3 !important;
            }

            .slide-header-tag {
                font-size: 9.5px !important;
                margin-bottom: 6px !important;
            }

            .slide-desc {
                font-size: 12.5px !important;
                margin-bottom: 14px !important;
                line-height: 1.5 !important;
            }

            .cyber-hud-number {
                font-size: 32px !important;
                margin-bottom: 4px !important;
            }

            .cyber-hud-box {
                padding: 14px 10px !important;
            }

            .cyber-hud-label {
                font-size: 10.5px !important;
                letter-spacing: 1px !important;
            }

            .slide-bg-art {
                opacity: 0.12 !important;
                width: 220px !important;
                height: 220px !important;
                right: -20px !important;
                top: 75% !important;
            }

            .ppt-thumb-bar {
                gap: 6px;
                padding: 8px 2px 4px 2px;
            }

            .thumb-box {
                min-width: 68px;
                padding: 5px 8px;
                font-size: 9.5px;
                border-radius: 7px;
                height: auto !important;
                white-space: nowrap !important;
            }

            .thumb-box span {
                font-size: 8px;
                margin-bottom: 1px;
                white-space: nowrap !important;
            }

            /* Matrix Table in Slide 6 */
            .cyber-slide[data-slide="6"] table {
                font-size: 10px !important;
            }

            .cyber-slide[data-slide="6"] th,
            .cyber-slide[data-slide="6"] td {
                padding: 6px 4px !important;
            }

            /* Call to Action Button in Slide 11 */
            .cyber-slide[data-slide="11"] a.cyber-btn {
                padding: 14px 20px !important;
                font-size: 13.5px !important;
                width: 100% !important;
                justify-content: center !important;
                box-sizing: border-box !important;
            }

            /* Contact HUD cards in Slide 11 */
            .contact-hud-card {
                padding: 10px !important;
            }
        }

        /* Interactive Contact Card Link Hover Styles */
        .contact-hud-wrapper {
            display: block !important;
            text-decoration: none !important;
            cursor: pointer !important;
            position: relative;
            z-index: 10;
        }

        .contact-hud-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer !important;
        }

        .contact-hud-wrapper:hover .contact-hud-card {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.8), 0 0 25px currentColor !important;
            filter: brightness(1.25);
        }

        /* High-Tech PDF Generator Loader Overlay */
        .pdf-loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(4, 1, 3, 0.94);
            backdrop-filter: blur(16px);
            z-index: 9999999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #ffffff;
            font-family: var(--font-tech);
        }

        .pdf-loader-card {
            background: rgba(12, 5, 10, 0.95);
            border: 1.5px solid var(--cyber-cyan);
            border-radius: 20px;
            padding: 35px 30px;
            text-align: center;
            box-shadow: 0 0 50px var(--cyber-cyan-glow);
            max-width: 420px;
            width: 90%;
            position: relative;
        }

        .cyber-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(0, 240, 255, 0.15);
            border-top: 4px solid var(--cyber-cyan);
            border-right: 4px solid #00ff88;
            border-radius: 50%;
            margin: 0 auto 18px auto;
            animation: spinCyber 0.9s linear infinite;
        }

        @keyframes spinCyber {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .pdf-loader-title {
            font-size: 17px;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 8px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .pdf-loader-status {
            font-size: 13px;
            color: var(--cyber-cyan);
            margin-bottom: 20px;
            font-family: var(--font-main);
        }

        .pdf-progress-bar-bg {
            background: rgba(255, 255, 255, 0.1);
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid rgba(0, 240, 255, 0.3);
        }

        .pdf-progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--cyber-cyan), #00ff88);
            width: 0%;
            transition: width 0.25s ease;
            box-shadow: 0 0 10px var(--cyber-cyan-glow);
        }

        .pdf-success-toast {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #000000;
            padding: 14px 28px;
            border-radius: 30px;
            font-family: var(--font-tech);
            font-size: 13.5px;
            font-weight: 900;
            box-shadow: 0 0 30px rgba(0, 255, 136, 0.6);
            z-index: 10000000;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeInDown 0.4s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>
@endpush

@section('content')
    <!-- High-Tech PDF Generation Loader Overlay -->
    <div id="pdfLoaderOverlay" class="pdf-loader-overlay" style="display: none;">
        <div class="pdf-loader-card">
            <div class="cyber-spinner"></div>
            <div class="pdf-loader-title">Exporting Presentation</div>
            <div class="pdf-loader-status" id="pdfLoaderStatus">Preparing slide export...</div>
            <div class="pdf-progress-bar-bg">
                <div class="pdf-progress-bar-fill" id="pdfProgressFill" style="width: 0%;"></div>
            </div>
        </div>
    </div>

    <!-- High-Tech Share Modal Overlay -->
    <div id="sharePptModal" class="share-modal-overlay" style="display: none;">
        <div class="share-modal-card">
            <div class="share-modal-header">
                <h3 class="share-modal-title"><i class="fab fa-whatsapp text-success me-2"></i> SHARE PRESENTATION</h3>
                <button class="share-modal-close" onclick="closeShareModal()">&times;</button>
            </div>
            <p class="share-modal-desc">Share Kredox Official Business Presentation with your network on WhatsApp, Telegram, or copy the direct link:</p>
            
            <div class="share-options-grid">
                <button class="share-btn whatsapp" onclick="shareOnWhatsApp()">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </button>
                <button class="share-btn telegram" onclick="shareOnTelegram()">
                    <i class="fab fa-telegram-plane"></i> Telegram
                </button>
                <button class="share-btn facebook" onclick="shareOnFacebook()">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
                <button class="share-btn copylink" onclick="copyPresentationLink()">
                    <i class="fas fa-copy"></i> Copy Link
                </button>
            </div>

            <div class="share-link-input-group mt-3">
                <input type="text" id="presentationShareUrlInput" class="share-url-input" readonly value="{{ route('public.presentation') }}">
                <button class="share-copy-btn" onclick="copyPresentationLink()"><i class="fas fa-link"></i> COPY</button>
            </div>
            <div id="shareCopySuccessMsg" class="share-copy-success" style="display: none;">
                <i class="fas fa-check-circle me-1"></i> Presentation link copied to clipboard!
            </div>
        </div>
    </div>

    <div class="ppt-page-container">
        <div class="cyber-ppt-wrapper" id="pptWrapper">

            <!-- Grid Background, Realtime Trading Canvas & Ambient HUD Rings -->
            <div class="cyber-grid-bg"></div>
            <canvas id="tradingBgCanvas" class="trading-bg-canvas"></canvas>
            <div class="hud-compass top-right"></div>
            <div class="hud-compass bottom-left"></div>

            <!-- Top Header Control Bar -->
            <div class="ppt-control-header">
                <div class="ppt-brand">
                    <div class="ppt-brand-name">
                        <i class="fas fa-chart-line ppt-chart-icon" style="color: #00ff88; margin-right: 6px;"></i>
                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" class="ppt-logo-img" style="display: none; height: 65px; max-height: 70px; width: auto; object-fit: contain; vertical-align: middle; margin-right: 12px; filter: drop-shadow(0 0 15px rgba(0, 255, 136, 0.5));" alt="Kredox Logo">
                        Kredox Presentation
                    </div>
                    <div class="slide-counter-badge mobile-counter">
                        SLIDE <span class="slide-num-val">01</span> / 11
                    </div>
                </div>

                <div class="ppt-actions">
                    <div class="slide-counter-badge desktop-counter">
                        SLIDE <span class="slide-num-val">01</span> / 11
                    </div>
                    <button class="cyber-btn" onclick="prevSlide()"><i class="fas fa-arrow-left"></i> PREV</button>
                    <button class="cyber-btn cyber-btn-cyan" id="downloadPdfBtn" onclick="downloadPresentationPDF()"><i
                            class="fas fa-file-pdf"></i> <span class="btn-text">DOWNLOAD PDF</span></button>
                    <button class="cyber-btn" onclick="nextSlide()">NEXT <i class="fas fa-arrow-right"></i></button>
                    <button class="cyber-btn cyber-btn-gold fullscreen-btn-desktop" onclick="toggleFullscreen()"><i
                            class="fas fa-expand"></i> <span class="btn-text">FULL</span></button>
                </div>
            </div>

            <!-- Slide Stage -->
            <div class="ppt-stage">

                <!-- SLIDE 1: WELCOME & OVERVIEW -->
                <div class="cyber-slide active" data-slide="1">
                    <div class="cyber-card">
                        <!-- Blended 3D Background Art -->
                        <img src="{{ asset('assets/images/ppt/character.jpg') }}" alt="3D Character Art"
                            class="slide-bg-art floating-anim">

                        <div class="row align-items-center" style="position: relative; z-index: 2;">
                            <div class="col-lg-8">
                                <div class="slide-header-tag">SLIDE 001 // INTRODUCTION</div>
                                <h1 class="slide-main-title">WELCOME TO KREDOX NETWORK</h1>
                                <p class="slide-desc" style="max-width: 680px; font-size: 15px;">
                                    Unlock premium fintech growth opportunities with secure <strong
                                        class="usdt-green">BEP-20 USDT</strong> smart contract protocols, daily ROI yield,
                                    and a 10-level referral reward matrix.
                                </p>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="p-3"
                                            style="background: rgba(0,255,136,0.08); border: 1px solid #00ff88; border-radius: 12px; backdrop-filter: blur(10px); box-shadow: 0 0 15px rgba(0,255,136,0.15);">
                                            <div style="color: #00ff88; font-size: 24px; margin-bottom: 8px;"><i
                                                    class="fas fa-shield-alt"></i></div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 14px; font-weight: 700; color: #00ff88;">
                                                BEP-20 USDT</div>
                                            <div style="font-size: 12px; color: #b0b7c7; margin-top: 4px;">Fast & Low-Fee
                                                BSC Smart Contract</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3"
                                            style="background: rgba(255,183,0,0.08); border: 1px solid var(--cyber-gold); border-radius: 12px; backdrop-filter: blur(10px); box-shadow: 0 0 15px rgba(255,183,0,0.15);">
                                            <div style="color: var(--cyber-gold); font-size: 24px; margin-bottom: 8px;"><i
                                                    class="fas fa-chart-line"></i></div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 14px; font-weight: 700; color: var(--cyber-gold);">
                                                12% Monthly ROI</div>
                                            <div style="font-size: 12px; color: #b0b7c7; margin-top: 4px;"><strong
                                                    class="usdt-green">0.6% Daily USDT</strong> Yield (Mon - Fri)</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3"
                                            style="background: rgba(255,0,60,0.08); border: 1px solid var(--cyber-red); border-radius: 12px; backdrop-filter: blur(10px); box-shadow: 0 0 15px rgba(255,0,60,0.15);">
                                            <div style="color: var(--cyber-red); font-size: 24px; margin-bottom: 8px;"><i
                                                    class="fas fa-sitemap"></i></div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 14px; font-weight: 700; color: var(--cyber-red);">
                                                10-Level Matrix</div>
                                            <div style="font-size: 12px; color: #b0b7c7; margin-top: 4px;">Multi-Tier
                                                <strong class="usdt-green">USDT Commission</strong> Tree</div>
                                        </div>
                                    </div>
                                </div>

                                <a href="https://kredox.org/" target="_blank" class="website-pill usdt-pill"
                                    style="margin-top: 22px; border-color: #00ff88; color: #00ff88; text-decoration: none;"><i
                                        class="fas fa-globe"></i> Official Platform Portal: <span class="usdt-green"
                                        style="font-weight: 800;">www.kredox.org</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 2: CURRENCY & WALLET DETAILS -->
                <div class="cyber-slide" data-slide="2">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/red_wallet.jpg') }}" alt="3D Red Crypto Wallet Art"
                            class="slide-bg-art red floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 002 // FINANCIAL STANDARDS</div>
                            <h2 class="slide-main-title">Currency & Wallet Protocol</h2>
                            <p class="slide-desc" style="font-size: 15px;">High-speed, low-fee decentralized stablecoin
                                ecosystem for all global transactions</p>

                            <div class="row g-3 mt-1">
                                <!-- CARD 1: USDT TETHER -->
                                <div class="col-md-4">
                                    <div class="cyber-hud-box usdt pulse-glow-green" style="padding: 22px 18px; border-radius: 16px; position: relative; overflow: hidden; background: linear-gradient(145deg, rgba(4, 20, 12, 0.94), rgba(6, 2, 8, 0.98)); border: 1.5px solid rgba(0, 255, 136, 0.5); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.8), inset 0 0 20px rgba(0,255,136,0.15);">
                                        <div style="position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(0, 255, 136, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(0, 255, 136, 0.35);">
                                                <span style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: #00ff88; letter-spacing: 1px;">
                                                    <i class="fas fa-coins text-warning me-1"></i> USDT TETHER
                                                </span>
                                                <span style="background: rgba(0, 255, 136, 0.15); border: 1px solid #00ff88; color: #00ff88; font-size: 9.5px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 1px;">
                                                    STABLECOIN
                                                </span>
                                            </div>
                                            <div class="text-center my-3 py-2" style="background: rgba(0, 255, 136, 0.06); border-radius: 12px; border: 1px solid rgba(0, 255, 136, 0.25); position: relative;">
                                                <div style="font-size: 34px; color: #00ff88; filter: drop-shadow(0 0 15px rgba(0, 255, 136, 0.8));">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <div class="cyber-hud-number usdt-green" style="font-size: 42px; line-height: 1; margin-top: 4px; font-weight: 900;">USDT</div>
                                            </div>
                                            <div class="cyber-hud-label" style="color: #00ff88; font-size: 13px; font-weight: 700; margin-bottom: 6px;">01. Primary Currency</div>
                                            <p style="font-size: 12.5px; color: #cbd5e1; line-height: 1.5; margin: 0;">
                                                All investments & payouts operate strictly in <strong class="usdt-green">USDT (Tether)</strong>, guaranteeing zero volatility risk and price stability.
                                            </p>
                                        </div>
                                        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(0, 255, 136, 0.2); display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: #00ff88; font-family: var(--font-tech);">
                                            <span><i class="fas fa-lock me-1"></i> PEG 1:1 USD</span>
                                            <span>VOLATILITY: 0%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD 2: BEP-20 BSC -->
                                <div class="col-md-4">
                                    <div class="cyber-hud-box gold pulse-glow-gold" style="padding: 22px 18px; border-radius: 16px; position: relative; overflow: hidden; background: linear-gradient(145deg, rgba(20, 16, 4, 0.94), rgba(6, 2, 8, 0.98)); border: 1.5px solid rgba(255, 183, 0, 0.5); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.8), inset 0 0 20px rgba(255, 183, 0, 0.15);">
                                        <div style="position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(255, 183, 0, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(255, 183, 0, 0.35);">
                                                <span style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: var(--cyber-gold); letter-spacing: 1px;">
                                                    <i class="fas fa-network-wired text-info me-1"></i> BEP-20 BSC
                                                </span>
                                                <span style="background: rgba(255, 183, 0, 0.15); border: 1px solid var(--cyber-gold); color: var(--cyber-gold); font-size: 9.5px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 1px;">
                                                    FAST & LOW FEE
                                                </span>
                                            </div>
                                            <div class="text-center my-3 py-2" style="background: rgba(255, 183, 0, 0.06); border-radius: 12px; border: 1px solid rgba(255, 183, 0, 0.25); position: relative;">
                                                <div style="font-size: 34px; color: var(--cyber-gold); filter: drop-shadow(0 0 15px rgba(255, 183, 0, 0.8));">
                                                    <i class="fas fa-bolt"></i>
                                                </div>
                                                <div class="cyber-hud-number" style="font-size: 42px; line-height: 1; margin-top: 4px; color: var(--cyber-gold); font-weight: 900;">BEP-20</div>
                                            </div>
                                            <div class="cyber-hud-label" style="color: var(--cyber-gold); font-size: 13px; font-weight: 700; margin-bottom: 6px;">02. Network Standard</div>
                                            <p style="font-size: 12.5px; color: #cbd5e1; line-height: 1.5; margin: 0;">
                                                Powered by Binance Smart Chain (<strong style="color: var(--cyber-gold);">BEP-20</strong>) for lightning-fast execution and ultra-low gas fee costs.
                                            </p>
                                        </div>
                                        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 183, 0, 0.2); display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: var(--cyber-gold); font-family: var(--font-tech);">
                                            <span><i class="fas fa-tachometer-alt me-1"></i> 3 SEC BLOCK</span>
                                            <span>GAS FEE: LOW</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD 3: $100 START -->
                                <div class="col-md-4">
                                    <div class="cyber-hud-box usdt pulse-glow-green" style="padding: 22px 18px; border-radius: 16px; position: relative; overflow: hidden; background: linear-gradient(145deg, rgba(4, 20, 16, 0.94), rgba(6, 2, 8, 0.98)); border: 1.5px solid rgba(0, 255, 136, 0.5); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.8), inset 0 0 20px rgba(0, 255, 136, 0.15);">
                                        <div style="position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(0, 255, 136, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(0, 255, 136, 0.35);">
                                                <span style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: #00ff88; letter-spacing: 1px;">
                                                    <i class="fas fa-wallet text-success me-1"></i> $100 START
                                                </span>
                                                <span style="background: rgba(0, 255, 136, 0.15); border: 1px solid #00ff88; color: #00ff88; font-size: 9.5px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 1px;">
                                                    MIN PACKAGE
                                                </span>
                                            </div>
                                            <div class="text-center my-3 py-2" style="background: rgba(0, 255, 136, 0.06); border-radius: 12px; border: 1px solid rgba(0, 255, 136, 0.25); position: relative;">
                                                <div style="font-size: 34px; color: #00ff88; filter: drop-shadow(0 0 15px rgba(0, 255, 136, 0.8));">
                                                    <i class="fas fa-layer-group"></i>
                                                </div>
                                                <div class="cyber-hud-number usdt-green" style="font-size: 42px; line-height: 1; margin-top: 4px; font-weight: 900;">$100</div>
                                            </div>
                                            <div class="cyber-hud-label" style="color: #00ff88; font-size: 13px; font-weight: 700; margin-bottom: 6px;">03. Min Deposit (USDT)</div>
                                            <p style="font-size: 12.5px; color: #cbd5e1; line-height: 1.5; margin: 0;">
                                                Start building your portfolio with an accessible minimum package of <strong class="usdt-green">100 USDT</strong>. Expand & upgrade anytime.
                                            </p>
                                        </div>
                                        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(0, 255, 136, 0.2); display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: #00ff88; font-family: var(--font-tech);">
                                            <span><i class="fas fa-check-circle me-1"></i> ENTRY LEVEL</span>
                                            <span>UPGRADE: ANYTIME</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-3 justify-content-center">
                                <span class="cyber-badge-pill green"><i class="fas fa-bolt"></i> Instant BSC
                                    Execution</span>
                                <span class="cyber-badge-pill gold"><i class="fas fa-shield-alt"></i> Zero Volatility
                                    Tether</span>
                                <span class="cyber-badge-pill red"><i class="fas fa-chart-line"></i> 100% Transparent
                                    Ledger</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3: INVESTMENT BASICS - START WITH $100 -->
                <div class="cyber-slide" data-slide="3">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/character.jpg') }}" alt="3D Character Art"
                            class="slide-bg-art gold floating-anim">

                        <div class="row align-items-center" style="position: relative; z-index: 2;">
                            <div class="col-lg-5 text-center mb-4 mb-lg-0">
                                <div class="cyber-hud-box usdt pulse-glow-green mb-3" style="padding: 16px; border-radius: 14px; text-align: center; background: rgba(0,255,136,0.06); border: 1.5px solid rgba(0,255,136,0.35);">
                                    <div style="font-size: 28px; color: #00ff88; margin-bottom: 2px;"><i class="fas fa-gem text-warning"></i></div>
                                    <div style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: #00ff88; letter-spacing: 1px;">ACCESSIBLE STAKING</div>
                                    <div style="font-size: 10px; color: #00ff88; font-weight: 700; opacity: 0.8; margin-top: 2px;">100 USDT MINIMUM</div>
                                </div>
                                <div class="cyber-hud-box usdt pulse-glow-green" style="padding: 25px 20px;">
                                    <div class="cyber-hud-number usdt-green" style="font-size: 48px;">$100 USDT</div>
                                    <div class="cyber-hud-label usdt-green" style="font-size: 14px; letter-spacing: 1.5px;">
                                        MINIMUM INVESTMENT PACKAGE</div>
                                    <div
                                        style="margin-top: 14px; background: rgba(0,255,136,0.12); border: 1px solid #00ff88; color: #00ff88; padding: 12px; border-radius: 12px; font-size: 12px; font-weight: 700; line-height: 1.5;">
                                        <i class="fas fa-check-circle" style="font-size: 15px; margin-right: 5px;"></i>
                                        <strong>ACCESSIBLE CAPITAL:</strong> Start with 100 USDT and upgrade your package
                                        anytime to amplify returns.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7 text-center text-lg-start">
                                <div class="slide-header-tag">SLIDE 003 // INVESTMENT BASICS</div>
                                <h2 class="slide-main-title">Investment Rules & Limits</h2>
                                <p class="slide-desc" style="font-size: 14.5px;">Flexible capital allocation structured for
                                    maximum scalability</p>

                                <div class="p-3 mb-2"
                                    style="background: rgba(0,0,0,0.65); border-left: 4px solid #00ff88; border-radius: 10px; backdrop-filter: blur(10px);">
                                    <h4
                                        style="font-family: var(--font-tech); font-size: 15px; color: #00ff88; margin: 0; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-coins"></i> Minimum Package: 100 USDT
                                    </h4>
                                    <p style="font-size: 12.5px; color: #b0b7c7; margin: 3px 0 0 0;">Low barrier to entry
                                        makes Kredox accessible to all investors globally.</p>
                                </div>

                                <div class="p-3 mb-2"
                                    style="background: rgba(0,0,0,0.65); border-left: 4px solid var(--cyber-gold); border-radius: 10px; backdrop-filter: blur(10px);">
                                    <h4
                                        style="font-family: var(--font-tech); font-size: 15px; color: var(--cyber-gold); margin: 0; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-infinity"></i> No Maximum Investment Limit
                                    </h4>
                                    <p style="font-size: 12.5px; color: #b0b7c7; margin: 3px 0 0 0;">Invest as much as you
                                        desire — expand and scale your capital without any upper cap.</p>
                                </div>

                                <div class="p-3 mb-3"
                                    style="background: rgba(0,0,0,0.65); border-left: 4px solid var(--cyber-red); border-radius: 10px; backdrop-filter: blur(10px);">
                                    <h4
                                        style="font-family: var(--font-tech); font-size: 15px; color: var(--cyber-red); margin: 0; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-bolt"></i> Instant Package Activation
                                    </h4>
                                    <p style="font-size: 12.5px; color: #b0b7c7; margin: 3px 0 0 0;">Your deposit package
                                        instantly earns daily ROI yield credited directly to your balance.</p>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="p-2 text-center" style="background: rgba(0,255,136,0.06); border: 1px dashed rgba(0,255,136,0.35); border-radius: 10px;">
                                            <span style="font-family: var(--font-tech); font-size: 11px; color: #00ff88; font-weight: 700;">
                                                <i class="fas fa-level-up-alt text-success me-1"></i> CAPITAL UPGRADES: <span class="text-warning">ANYTIME</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-2 text-center" style="background: rgba(0,240,255,0.06); border: 1px dashed rgba(0,240,255,0.35); border-radius: 10px;">
                                            <span style="font-family: var(--font-tech); font-size: 11px; color: var(--cyber-cyan); font-weight: 700;">
                                                <i class="fas fa-cubes text-info me-1"></i> DEPOSIT ALLOCATION: <span class="text-success">FLEXIBLE</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 4: 12% MONTHLY TARGET ROI -->
                <div class="cyber-slide" data-slide="4">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="3D Network Nodes"
                            class="slide-bg-art floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 004 // TARGET RETURN ON INVESTMENT</div>
                            <h2 class="slide-main-title">12% Monthly Target ROI</h2>
                            <p class="slide-desc" style="font-size: 15px;">Automated quantitative trading yield generated
                                directly for active investors</p>

                            <div class="row align-items-center mt-3">
                                <div class="col-lg-5 mb-4 mb-lg-0">
                                    <div class="cyber-hud-box usdt pulse-glow-green" style="padding: 40px 20px;">
                                        <div class="cyber-hud-number usdt-green">12%</div>
                                        <div class="cyber-hud-label usdt-green" style="font-size: 14px;">MONTHLY RETURN ON
                                            INVESTMENT</div>
                                        <div
                                            style="font-family: var(--font-tech); font-size: 22px; color: var(--cyber-gold); margin-top: 18px; font-weight: 800;">
                                            <i class="fas fa-chart-line"></i> <span class="usdt-green">0.6%</span> / ACTIVE
                                            DAY</div>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="p-4"
                                        style="background: rgba(0,0,0,0.75); border: 1px solid rgba(0,255,136,0.4); border-radius: 16px; backdrop-filter: blur(15px); box-shadow: 0 0 30px rgba(0,255,136,0.15);">
                                        <h4
                                            style="font-family: var(--font-tech); color: #00ff88; font-size: 18px; margin-bottom: 14px; display: flex; align-items: center; gap: 10px;">
                                            <i class="fas fa-coins" style="color: #00ff88;"></i> Daily Automated Payouts
                                        </h4>
                                        <p style="font-size: 14px; color: #e0e0e0; line-height: 1.7;">
                                            Earn consistent returns with daily <strong class="usdt-green">0.6% USDT
                                                ROI</strong> payouts calculated across active market sessions, achieving a
                                            full <strong class="usdt-green">12% monthly yield</strong>.
                                        </p>
                                        <hr style="border-color: rgba(255,255,255,0.15); margin: 15px 0;">
                                        <div
                                            style="color: var(--cyber-gold); font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 12px; line-height: 1.5;">
                                            <i class="fas fa-shield-alt"
                                                style="font-size: 26px; color: var(--cyber-gold); flex-shrink: 0;"></i>
                                            <span>Stablecoin execution in BEP-20 USDT ensures your return value remains
                                                completely immune to market crypto crashes.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 5: TRADING SCHEDULE & WEEKEND PAUSE -->
                <div class="cyber-slide" data-slide="5">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/character.jpg') }}" alt="3D Trading Character Art"
                            class="slide-bg-art red floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 005 // TRADING SESSION CALENDAR</div>
                            <h2 class="slide-main-title">Trading Schedule & Market Sessions</h2>
                            <p class="slide-desc" style="font-size: 14.5px;">Disciplined algorithmic trading execution
                                optimized for risk control</p>

                            <div class="row g-3 mt-1">
                                <!-- CARD 1: MONDAY TO FRIDAY ACTIVE TRADING -->
                                <div class="col-md-6">
                                    <div class="cyber-hud-box usdt pulse-glow-green" style="padding: 22px 20px; border-radius: 16px; position: relative; overflow: hidden; background: linear-gradient(145deg, rgba(4, 20, 12, 0.94), rgba(6, 2, 8, 0.98)); border: 1.5px solid rgba(0, 255, 136, 0.5); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.8), inset 0 0 20px rgba(0, 255, 136, 0.15);">
                                        <div style="position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(0, 255, 136, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(0, 255, 136, 0.35);">
                                                <span style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: #00ff88; letter-spacing: 1px;">
                                                    <i class="fas fa-chart-line text-success me-1"></i> MONDAY TO FRIDAY
                                                </span>
                                                <span style="background: rgba(0, 255, 136, 0.15); border: 1px solid #00ff88; color: #00ff88; font-size: 9.5px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 1px;">
                                                    0.6% DAILY ROI
                                                </span>
                                            </div>
                                            <div class="text-center my-3 py-2" style="background: rgba(0, 255, 136, 0.06); border-radius: 12px; border: 1px solid rgba(0, 255, 136, 0.25); position: relative;">
                                                <div style="font-size: 34px; color: #00ff88; filter: drop-shadow(0 0 15px rgba(0, 255, 136, 0.8));">
                                                    <i class="fas fa-business-time"></i>
                                                </div>
                                                <div class="cyber-hud-number usdt-green" style="font-size: 36px; line-height: 1; margin-top: 4px; font-weight: 900;">ACTIVE TRADING</div>
                                            </div>
                                            <div class="cyber-hud-label usdt-green" style="font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">5 Days Active Execution</div>
                                            <p style="font-size: 12.5px; color: #cbd5e1; line-height: 1.55; margin: 0;">
                                                Quant algorithmic bots run on institutional global liquidity pools during open weekdays (Mon - Fri), generating <strong class="usdt-green">0.6% daily ROI</strong>.
                                            </p>
                                        </div>
                                        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(0, 255, 136, 0.2); display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: #00ff88; font-family: var(--font-tech);">
                                            <span><i class="fas fa-calendar-check me-1"></i> 5 ACTIVE DAYS/WEEK</span>
                                            <span>DAILY PAYOUT</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD 2: SATURDAY & SUNDAY TRADING PAUSE -->
                                <div class="col-md-6">
                                    <div class="cyber-hud-box red pulse-glow-red" style="padding: 22px 20px; border-radius: 16px; position: relative; overflow: hidden; background: linear-gradient(145deg, rgba(24, 4, 8, 0.94), rgba(6, 2, 8, 0.98)); border: 1.5px solid rgba(255, 0, 60, 0.5); height: 100%; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 10px 30px rgba(0,0,0,0.8), inset 0 0 20px rgba(255, 0, 60, 0.15);">
                                        <div style="position: absolute; top: -20px; right: -20px; width: 140px; height: 140px; background: radial-gradient(circle, rgba(255, 0, 60, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px dashed rgba(255, 0, 60, 0.35);">
                                                <span style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: var(--cyber-red); letter-spacing: 1px;">
                                                    <i class="fas fa-pause-circle text-danger me-1"></i> SATURDAY & SUNDAY
                                                </span>
                                                <span style="background: rgba(255, 0, 60, 0.15); border: 1px solid var(--cyber-red); color: var(--cyber-red); font-size: 9.5px; font-weight: 800; padding: 3px 8px; border-radius: 6px; letter-spacing: 1px;">
                                                    RISK PROTECTION
                                                </span>
                                            </div>
                                            <div class="text-center my-3 py-2" style="background: rgba(255, 0, 60, 0.06); border-radius: 12px; border: 1px solid rgba(255, 0, 60, 0.25); position: relative;">
                                                <div style="font-size: 34px; color: var(--cyber-red); filter: drop-shadow(0 0 15px rgba(255, 0, 60, 0.8));">
                                                    <i class="fas fa-shield-alt"></i>
                                                </div>
                                                <div class="cyber-hud-number" style="font-size: 36px; line-height: 1; margin-top: 4px; color: var(--cyber-red); font-weight: 900;">TRADING PAUSE</div>
                                            </div>
                                            <div class="cyber-hud-label" style="color: var(--cyber-red); font-size: 13.5px; font-weight: 700; margin-bottom: 6px;">Weekend Capital Safeguard</div>
                                            <p style="font-size: 12.5px; color: #cbd5e1; line-height: 1.55; margin: 0;">
                                                Weekend markets are closed to protect capital from low liquidity spikes and extreme slippage, maintaining zero-risk fund management.
                                            </p>
                                        </div>
                                        <div class="mt-3 pt-2" style="border-top: 1px solid rgba(255, 0, 60, 0.2); display: flex; align-items: center; justify-content: space-between; font-size: 10.5px; color: var(--cyber-red); font-family: var(--font-tech);">
                                            <span><i class="fas fa-user-shield me-1"></i> ZERO MARKET SLIPPAGE</span>
                                            <span>CAPITAL SAFEGUARD</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 mt-3"
                                style="background: rgba(0,0,0,0.7); border: 1px solid rgba(0,255,136,0.3); border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-robot" style="font-size: 24px; color: #00ff88;"></i>
                                    <div>
                                        <div
                                            style="font-family: var(--font-tech); font-weight: 700; font-size: 13.5px; color: #ffffff;">
                                            QUANT ALGORITHMIC TRADING BOT</div>
                                        <div style="font-size: 11.5px; color: #b0b7c7;">Institutional global liquidity pool
                                            execution</div>
                                    </div>
                                </div>
                                <span class="cyber-badge-pill green"><i class="fas fa-circle" style="font-size: 8px;"></i>
                                    24/5 LIVE MONITORING</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 6: MASTER 10-LEVEL REFERRAL MATRIX (ULTRA-PREMIUM "EK NUMBER" DESIGN) -->
                <div class="cyber-slide" data-slide="6">
                    <div class="cyber-card"
                        style="position: relative; background: radial-gradient(circle at 75% 50%, rgba(255, 0, 60, 0.25) 0%, rgba(4, 1, 3, 0.96) 70%), url('{{ asset('assets/images/ppt/cyber_bg.jpg') }}') no-repeat center center / cover; padding: 25px 35px;">

                        <!-- 3D Network Art Floating in Background -->
                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="3D 10-Level Network Matrix"
                            class="slide-bg-art floating-anim"
                            style="opacity: 0.45; right: -25px; width: 480px; height: 480px; filter: drop-shadow(0 0 50px rgba(0, 255, 136, 0.4));">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 006 // MULTI-TIER NETWORK COMMISSIONS</div>
                            <h2 class="slide-main-title" style="margin-bottom: 2px; font-size: 30px;">Team Level <span
                                    class="usdt-green">Commission Matrix</span></h2>
                            <p class="slide-desc" style="font-size: 14px; margin-bottom: 12px; color: #d0d7e5;">
                                Earn up to <strong class="usdt-green" style="font-size: 15px;">67% Total Referral
                                    Yield</strong> across 10 deep downline tiers
                            </p>

                            <div class="row align-items-center g-3">
                                <!-- Left Column: Clean High-Tech Cyber Matrix Table -->
                                <div class="col-lg-7 col-md-7">
                                    <div
                                        style="border: 1.5px solid rgba(0, 255, 136, 0.4); border-radius: 16px; overflow: hidden; background: rgba(12, 5, 10, 0.92); backdrop-filter: blur(16px); box-shadow: 0 0 35px rgba(0, 255, 136, 0.18); position: relative;">

                                        <table class="table mb-0 align-middle text-center"
                                            style="font-size: 12px; color: #ffffff; border-collapse: separate; border-spacing: 0;">
                                            <thead>
                                                <tr
                                                    style="background: rgba(0, 255, 136, 0.12); border-bottom: 2px solid #00ff88;">
                                                    <th
                                                        style="font-family: var(--font-tech); color: #ffffff; padding: 10px 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 11.5px;">
                                                        LEVEL</th>
                                                    <th
                                                        style="font-family: var(--font-tech); color: #00ff88; padding: 10px 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; font-size: 11.5px; text-shadow: 0 0 10px rgba(0,255,136,0.6);">
                                                        INCOME YIELD</th>
                                                    <th
                                                        style="font-family: var(--font-tech); color: #ffffff; padding: 10px 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; font-size: 11.5px;">
                                                        QUALIFICATION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0, 255, 136, 0.06);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 1</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px; text-shadow: 0 0 12px rgba(0,255,136,0.6);">
                                                        15%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.15); color: #00ff88; border: 1px solid rgba(0,255,136,0.45); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; box-shadow: 0 0 8px rgba(0,255,136,0.2); display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 1
                                                            Direct</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.4);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 2</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        12%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 2
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0, 255, 136, 0.04);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 3</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        10%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 3
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.4);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 4</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        8%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 4
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0, 255, 136, 0.04);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 5</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        6%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 5
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.4);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 6</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        5%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 6
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0, 255, 136, 0.04);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 7</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        5%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 7
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0,0,0,0.4);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 8</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        3%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 8
                                                            Directs</span></td>
                                                </tr>
                                                <tr
                                                    style="border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(0, 255, 136, 0.04);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 800; color: #ffffff; padding: 7.5px 10px;">
                                                        <i class="fas fa-layer-group"
                                                            style="color: #00ff88; margin-right: 6px;"></i> LEVEL 9</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; padding: 7.5px 10px;">
                                                        2%</td>
                                                    <td style="padding: 7.5px 10px;"><span
                                                            style="background: rgba(0,255,136,0.12); color: #00ff88; border: 1px solid rgba(0,255,136,0.35); padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-user-check" style="font-size: 10px;"></i> 9
                                                            Directs</span></td>
                                                </tr>
                                                <tr style="background: rgba(0, 255, 136, 0.16);">
                                                    <td
                                                        style="font-family: var(--font-tech); font-weight: 900; color: #ffffff; padding: 8px 10px;">
                                                        <span style="color: var(--cyber-gold); margin-right: 6px;">★</span>
                                                        LEVEL 10</td>
                                                    <td class="usdt-green"
                                                        style="font-family: var(--font-tech); font-weight: 900; font-size: 16px; padding: 8px 10px; text-shadow: 0 0 15px rgba(0,255,136,0.9);">
                                                        1%</td>
                                                    <td style="padding: 8px 10px;"><span
                                                            style="background: #00ff88; color: #000000; padding: 5px 16px; border-radius: 20px; font-size: 11px; font-weight: 900; box-shadow: 0 0 15px rgba(0,255,136,0.7); display: inline-flex; align-items: center; gap: 5px;"><i
                                                                class="fas fa-crown" style="font-size: 11px;"></i> 10
                                                            Directs</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Right Column: Clean Uniform Qualification HUD Panel -->
                                <div class="col-lg-5 col-md-5 text-center">
                                    <div class="p-4"
                                        style="background: rgba(10, 4, 8, 0.88); border: 1.5px solid #00ff88; border-radius: 20px; backdrop-filter: blur(16px); box-shadow: 0 0 35px rgba(0, 255, 136, 0.25); position: relative; overflow: hidden;">

                                        <!-- Embedded 3D Network Graphic Overlay -->
                                        <div
                                            style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; background: url('{{ asset('assets/images/ppt/nodes.jpg') }}') no-repeat center center / cover; opacity: 0.22; pointer-events: none;">
                                        </div>

                                        <!-- Panel Title Badge (Clean Solid Green) -->
                                        <div class="d-inline-block mb-3"
                                            style="background: linear-gradient(135deg, #00ff88, #00cc66); padding: 8px 30px; border-radius: 30px; box-shadow: 0 0 20px rgba(0, 255, 136, 0.4); position: relative; z-index: 2;">
                                            <h3
                                                style="font-family: var(--font-tech); font-weight: 900; font-size: 15px; color: #000000; margin: 0; letter-spacing: 2px; text-transform: uppercase;">
                                                <i class="fas fa-shield-alt" style="margin-right: 6px;"></i> QUALIFICATION
                                                ENGINE
                                            </h3>
                                        </div>

                                        <!-- Condition Cards Container -->
                                        <div
                                            style="display: flex; flex-direction: column; gap: 14px; font-size: 13.5px; color: #ffffff; text-align: center; position: relative; z-index: 2;">

                                            <!-- Card 1: Direct Rules -->
                                            <div
                                                style="background: rgba(0,0,0,0.75); border: 1px solid rgba(0, 255, 136, 0.4); border-radius: 14px; padding: 16px; backdrop-filter: blur(12px); box-shadow: 0 0 15px rgba(0,255,136,0.15);">
                                                <div
                                                    style="font-size: 13px; color: #b0b7c7; margin-bottom: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                                                    <i class="fas fa-unlock-alt"
                                                        style="color: #00ff88; margin-right: 6px;"></i> Tier Qualification
                                                    Rule</div>
                                                <div style="font-weight: 800; font-size: 15px; line-height: 1.6;">
                                                    <span class="usdt-green" style="font-size: 16px;">1 Direct</span> = 1
                                                    Level Unlocked<br>
                                                    <span class="usdt-green"
                                                        style="font-weight: 900; font-size: 17px; text-shadow: 0 0 12px rgba(0,255,136,0.7);">10
                                                        Directs</span> = <span
                                                        style="color: #00ff88; text-shadow: 0 0 12px rgba(0,255,136,0.8);">All
                                                        10 Levels Open</span>
                                                </div>
                                            </div>

                                            <!-- Card 2: Min Package -->
                                            <div
                                                style="background: rgba(255, 183, 0, 0.1); border: 1.5px dashed var(--cyber-gold); border-radius: 14px; padding: 14px; backdrop-filter: blur(12px); box-shadow: 0 0 15px rgba(255,183,0,0.15);">
                                                <div
                                                    style="color: var(--cyber-gold); font-weight: 900; font-size: 14px; letter-spacing: 1px; text-transform: uppercase;">
                                                    <i class="fas fa-coins" style="margin-right: 6px;"></i> Min Direct
                                                    Package
                                                </div>
                                                <div style="font-size: 13.5px; color: #e0e0e0; margin-top: 4px;">
                                                    Each Direct must deposit minimum <strong class="usdt-green"
                                                        style="font-size: 16px; font-family: var(--font-tech);">100
                                                        USDT</strong>
                                                </div>
                                            </div>

                                            <!-- Card 3: Gold Note -->
                                            <div
                                                style="background: rgba(255, 183, 0, 0.12); border: 1px solid var(--cyber-gold); border-radius: 12px; padding: 12px 14px; color: var(--cyber-gold); font-family: var(--font-tech); font-weight: 900; font-size: 13px; text-shadow: 0 0 12px rgba(255, 183, 0, 0.4);">
                                                <i class="fas fa-star" style="margin-right: 6px;"></i> SYSTEM NOTE: 10
                                                Active Directs for all 10 Levels
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 7: 3X INCOME CAP & RE-TOPUP ENGINE -->
                <div class="cyber-slide" data-slide="7">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/lock_cube.jpg') }}" alt="3D Crypto Lock"
                            class="slide-bg-art floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 007 // CAPITAL SUSTAINABILITY</div>
                            <h2 class="slide-main-title">3X Income Cap & Re-Topup Protocol</h2>
                            <p class="slide-desc" style="font-size: 14.5px;">Smart ecosystem protection mechanism ensuring
                                long-term liquidity balance</p>

                            <div class="row align-items-center mt-2">
                                <div class="col-lg-5 mb-4 mb-lg-0">
                                    <div class="multi-img-card mb-3" style="max-width: 320px; margin: 0 auto;">
                                        <img src="{{ asset('assets/images/ppt/lock_cube.jpg') }}" alt="300% Earning Cap"
                                            style="height: 120px;">
                                        <div class="multi-img-badge">
                                            <span><i class="fas fa-shield-alt text-danger"></i> 3X EARNING LIMIT</span>
                                            <span class="text-warning">300% CAP</span>
                                        </div>
                                    </div>
                                    <div class="cyber-hud-box red" style="padding: 25px 20px;">
                                        <div class="cyber-hud-number red" style="font-size: 52px;">300%</div>
                                        <div class="cyber-hud-label" style="color: var(--cyber-red); font-size: 14px;">
                                            MAXIMUM EARNING CAP (3X)</div>
                                        <div
                                            style="margin-top: 12px; background: rgba(255,0,60,0.15); border: 1px solid var(--cyber-red); color: #ff6b6b; padding: 10px; border-radius: 10px; font-size: 12px; font-weight: 700;">
                                            <i class="fas fa-sync-alt" style="margin-right: 5px;"></i> Re-Topup required to
                                            reactivate income streams.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <div class="multi-img-card">
                                                <img src="{{ asset('assets/images/ppt/red_wallet.jpg') }}"
                                                    alt="Re-Topup Vault" style="height: 90px;">
                                                <div class="multi-img-badge" style="font-size: 9.5px;">
                                                    <span><i class="fas fa-redo text-warning"></i> RE-TOPUP ENGINE</span>
                                                    <span class="text-success">100 USDT</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="multi-img-card">
                                                <img src="{{ asset('assets/images/ppt/character.jpg') }}"
                                                    alt="Sustainability Officer" style="height: 90px;">
                                                <div class="multi-img-badge" style="font-size: 9.5px;">
                                                    <span><i class="fas fa-balance-scale text-info"></i> CAPITAL
                                                        BALANCE</span>
                                                    <span class="text-success">SUSTAINABLE</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3"
                                        style="background: rgba(0,0,0,0.75); border: 1px solid rgba(255,0,60,0.4); border-radius: 14px; backdrop-filter: blur(15px); box-shadow: 0 0 25px rgba(255,0,60,0.15);">
                                        <h4
                                            style="font-family: var(--font-tech); color: var(--cyber-red); font-size: 16px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                                            <i class="fas fa-shield-alt"></i> Sustainable System Architecture
                                        </h4>
                                        <p style="font-size: 13px; color: #e0e0e0; line-height: 1.6; margin-bottom: 10px;">
                                            Total accumulated earnings (ROI yield + Level bonus commissions) are capped at
                                            <strong style="color: var(--cyber-red);">300% (3X)</strong> of your active
                                            deposit package.
                                        </p>
                                        <hr style="border-color: rgba(255,255,255,0.15); margin: 10px 0;">
                                        <div
                                            style="color: #00ff88; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; gap: 10px; line-height: 1.4;">
                                            <i class="fas fa-check-circle"
                                                style="font-size: 22px; color: #00ff88; flex-shrink: 0;"></i>
                                            <span>Once 3X limit is reached, re-topup your account with <strong
                                                    class="usdt-green">100 USDT minimum</strong> to continue earning daily
                                                returns & downline bonuses seamlessly.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 8: WITHDRAWAL METHODS -->
                <div class="cyber-slide" data-slide="8">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/red_wallet.jpg') }}" alt="3D Lock Cube"
                            class="slide-bg-art red floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 008 // WITHDRAWAL POLICY</div>
                            <h2 class="slide-main-title">Withdrawal Options & Settlement</h2>
                            <p class="slide-desc" style="font-size: 14.5px;">Transparent withdrawal terms with instant
                                automated processing</p>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/crypto_ring.jpg') }}" alt="0% Fee Withdrawal"
                                            style="height: 110px;">
                                        <div class="multi-img-badge">
                                            <span><i class="fas fa-check-circle text-success"></i> CURRENT BALANCE</span>
                                            <span class="text-success">0% ZERO FEE</span>
                                        </div>
                                    </div>
                                    <div class="cyber-hud-box usdt" style="padding: 20px;">
                                        <div class="cyber-hud-number usdt-green" style="font-size: 48px;">0%</div>
                                        <div class="cyber-hud-label usdt-green" style="font-size: 13.5px;">Method 1: Current
                                            Balance</div>
                                        <p style="font-size: 12.5px; color: #b0b7c7; margin-top: 10px; line-height: 1.5;">
                                            Withdraw directly from your earned income balance with <strong
                                                class="usdt-green">0% Zero Fees/Deductions</strong>. Full 100% amount sent
                                            directly to your <strong class="usdt-green">BEP-20 USDT Wallet</strong>.
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/lock_cube.jpg') }}" alt="Principal Early Exit"
                                            style="height: 110px;">
                                        <div class="multi-img-badge">
                                            <span><i class="fas fa-exclamation-triangle text-danger"></i> PRINCIPAL
                                                CAPITAL</span>
                                            <span class="text-danger">20% EXIT FEE</span>
                                        </div>
                                    </div>
                                    <div class="cyber-hud-box red" style="padding: 20px;">
                                        <div class="cyber-hud-number red" style="font-size: 48px;">20%</div>
                                        <div class="cyber-hud-label" style="color: var(--cyber-red); font-size: 13.5px;">
                                            Method 2: Principal Capital</div>
                                        <p style="font-size: 12.5px; color: #b0b7c7; margin-top: 10px; line-height: 1.5;">
                                            Option to withdraw from your invested principal capital with a <strong
                                                style="color: var(--cyber-red);">20% early exit fee</strong> applied for
                                            liquidity balancing.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 9: DUAL PASSIVE REVENUE MATRIX -->
                <div class="cyber-slide" data-slide="9">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="3D Crypto Ring"
                            class="slide-bg-art floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 009 // REVENUE MATRIX</div>
                            <h2 class="slide-main-title">Dual Passive Revenue Matrix</h2>
                            <p class="slide-desc" style="font-size: 14.5px;">Dual passive revenue engines: Daily ROI +
                                10-Tier Referral Engine</p>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/crypto_ring.jpg') }}" alt="Engine A ROI"
                                            style="height: 110px;">
                                        <div class="multi-img-badge">
                                            <span><i class="fas fa-chart-bar text-success"></i> ENGINE A: DAILY ROI</span>
                                            <span class="text-success">12% MONTHLY</span>
                                        </div>
                                    </div>
                                    <div class="cyber-hud-box usdt" style="padding: 20px;">
                                        <div class="cyber-hud-number usdt-green" style="font-size: 48px;">12%</div>
                                        <div class="cyber-hud-label usdt-green" style="font-size: 13.5px;">Monthly
                                            Investment ROI</div>
                                        <p style="font-size: 12.5px; color: #b0b7c7; margin-top: 10px; line-height: 1.5;">
                                            Earn consistent returns with automated daily <strong class="usdt-green">0.6%
                                                USDT ROI</strong> payouts calculated across active weekdays (Mon - Fri).
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="Engine B Referral"
                                            style="height: 110px;">
                                        <div class="multi-img-badge">
                                            <span><i class="fas fa-sitemap text-warning"></i> ENGINE B: 10-TIER TREE</span>
                                            <span class="text-warning">67% TOTAL</span>
                                        </div>
                                    </div>
                                    <div class="cyber-hud-box gold" style="padding: 20px;">
                                        <div class="cyber-hud-number" style="font-size: 48px; color: var(--cyber-gold);">10
                                        </div>
                                        <div class="cyber-hud-label" style="color: var(--cyber-gold); font-size: 13.5px;">
                                            10-Level Referral Matrix</div>
                                        <p style="font-size: 12.5px; color: #b0b7c7; margin-top: 10px; line-height: 1.5;">
                                            Unlock deep team commission rewards ranging from <strong class="usdt-green">15%
                                                on Level 1</strong> down to <strong class="usdt-green">1% on Level
                                                10</strong>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 10: SECURITY & CLOUD INFRASTRUCTURE -->
                <div class="cyber-slide" data-slide="10">
                    <div class="cyber-card">
                        <img src="{{ asset('assets/images/ppt/lock_cube.jpg') }}" alt="3D Security Lock"
                            class="slide-bg-art red floating-anim">

                        <div style="position: relative; z-index: 2;">
                            <div class="slide-header-tag">SLIDE 010 // SECURITY & SUPPORT</div>
                            <h2 class="slide-main-title">Security & System Infrastructure</h2>
                            <p class="slide-desc" style="font-size: 14.5px;">Enterprise-grade security protecting your funds
                                & transactions 24/7</p>

                            <div class="row g-3 mt-1">
                                <div class="col-md-3 col-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/lock_cube.jpg') }}" alt="SSL Encryption"
                                            style="height: 80px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 2px 6px;">
                                            <span>256-BIT SSL</span>
                                        </div>
                                    </div>
                                    <div class="p-2 text-center"
                                        style="background: rgba(0,0,0,0.65); border: 1px solid var(--cyber-red); border-radius: 12px; backdrop-filter: blur(10px);">
                                        <div style="font-size: 22px; color: var(--cyber-red); margin-bottom: 4px;"><i
                                                class="fas fa-lock"></i></div>
                                        <div
                                            style="font-family: var(--font-tech); font-size: 11.5px; font-weight: 700; color: #fff;">
                                            SSL ENCRYPTION</div>
                                        <div style="font-size: 10.5px; color: #b0b7c7; margin-top: 2px;">256-Bit Protection
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/crypto_ring.jpg') }}" alt="BEP-20 Verified"
                                            style="height: 80px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 2px 6px;">
                                            <span>BSC SMART CONTRACT</span>
                                        </div>
                                    </div>
                                    <div class="p-2 text-center"
                                        style="background: rgba(0,0,0,0.65); border: 1px solid #00ff88; border-radius: 12px; backdrop-filter: blur(10px);">
                                        <div style="font-size: 22px; color: #00ff88; margin-bottom: 4px;"><i
                                                class="fas fa-check-circle"></i></div>
                                        <div
                                            style="font-family: var(--font-tech); font-size: 11.5px; font-weight: 700; color: #00ff88;">
                                            SMART CONTRACT</div>
                                        <div style="font-size: 10.5px; color: #b0b7c7; margin-top: 2px;">BEP-20 Verified
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="Cloud Servers"
                                            style="height: 80px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 2px 6px;">
                                            <span>99.9% UPTIME</span>
                                        </div>
                                    </div>
                                    <div class="p-2 text-center"
                                        style="background: rgba(0,0,0,0.65); border: 1px solid var(--cyber-gold); border-radius: 12px; backdrop-filter: blur(10px);">
                                        <div style="font-size: 22px; color: var(--cyber-gold); margin-bottom: 4px;"><i
                                                class="fas fa-server"></i></div>
                                        <div
                                            style="font-family: var(--font-tech); font-size: 11.5px; font-weight: 700; color: var(--cyber-gold);">
                                            CLOUD SERVERS</div>
                                        <div style="font-size: 10.5px; color: #b0b7c7; margin-top: 2px;">Global Edge Nodes
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="multi-img-card mb-2">
                                        <img src="{{ asset('assets/images/ppt/character.jpg') }}" alt="24/7 Desk"
                                            style="height: 80px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 2px 6px;">
                                            <span>24/7 SUPPORT</span>
                                        </div>
                                    </div>
                                    <div class="p-2 text-center"
                                        style="background: rgba(0,0,0,0.65); border: 1px solid var(--cyber-red); border-radius: 12px; backdrop-filter: blur(10px);">
                                        <div style="font-size: 22px; color: var(--cyber-red); margin-bottom: 4px;"><i
                                                class="fas fa-headset"></i></div>
                                        <div
                                            style="font-family: var(--font-tech); font-size: 11.5px; font-weight: 700; color: #fff;">
                                            24/7 DESK</div>
                                        <div style="font-size: 10.5px; color: #b0b7c7; margin-top: 2px;">Dedicated Support
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 11: GET STARTED TODAY! -->
                <div class="cyber-slide" data-slide="11">
                    <div class="cyber-card text-center" style="position: relative; overflow: hidden; padding: 35px 25px;">
                        <img src="{{ asset('assets/images/ppt/character.jpg') }}" alt="3D Character Art"
                            class="slide-bg-art gold floating-anim"
                            style="opacity: 0.35; right: -30px; width: 440px; height: 440px;">

                        <div style="position: relative; z-index: 2; max-width: 900px; margin: 0 auto;">
                            <div class="slide-header-tag justify-content-center">SLIDE 011 // CALL TO ACTION</div>
                            <h1 class="slide-main-title"
                                style="font-size: 38px; text-shadow: 0 0 25px rgba(0, 255, 136, 0.4);">Get Started Today!
                            </h1>
                            <p class="slide-desc"
                                style="max-width: 680px; margin: 0 auto 20px auto; font-size: 14.5px; color: #d0d7e5; line-height: 1.5;">
                                Ready to unlock your financial growth with Kredox? Join global investors receiving daily ROI
                                yield and multi-level rewards in <strong
                                    style="color: #00ff88; text-shadow: 0 0 10px rgba(0,255,136,0.6);">BEP-20 USDT</strong>.
                            </p>

                            <!-- Multi-Image 3D Showcase Deck -->
                            <div class="row justify-content-center g-3 mb-3" style="max-width: 780px; margin: 0 auto;">
                                <div class="col-4">
                                    <div class="multi-img-card">
                                        <img src="{{ asset('assets/images/ppt/red_wallet.jpg') }}" alt="Deposit Chest"
                                            style="height: 85px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 3px 6px;">
                                            <span>START DEPOSIT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="multi-img-card">
                                        <img src="{{ asset('assets/images/ppt/crypto_ring.jpg') }}" alt="USDT Yield"
                                            style="height: 85px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 3px 6px;">
                                            <span>BEP-20 USDT YIELD</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="multi-img-card">
                                        <img src="{{ asset('assets/images/ppt/nodes.jpg') }}" alt="10-Tier Network"
                                            style="height: 85px;">
                                        <div class="multi-img-badge" style="font-size: 8.5px; padding: 3px 6px;">
                                            <span>10-TIER REWARDS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Call to Action Button with Clean High Contrast -->
                            <div style="margin-bottom: 25px;">
                                <a href="{{ route('user.deposit.index') }}" class="cyber-btn"
                                    style="background: linear-gradient(135deg, #00ff88 0%, #00cc66 100%); color: #000000; padding: 15px 45px; font-size: 16px; font-weight: 900; border-radius: 40px; box-shadow: 0 0 35px rgba(0, 255, 136, 0.6), inset 0 0 10px rgba(255, 255, 255, 0.4); text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 10px; border: none; text-shadow: none;">
                                    <i class="fas fa-rocket" style="font-size: 18px;"></i> INVEST NOW ($100 USDT MIN)
                                </a>
                            </div>

                            <!-- High-Tech Contact Info HUD Cards -->
                            <div class="row justify-content-center g-3" style="max-width: 860px; margin: 0 auto;">
                                <div class="col-md-4">
                                    <a href="tel:+18002345678" class="contact-hud-wrapper">
                                        <div class="p-3 text-center contact-hud-card"
                                            style="background: rgba(12, 6, 10, 0.85); border: 1.5px solid var(--cyber-gold); border-radius: 14px; backdrop-filter: blur(12px); box-shadow: 0 0 20px rgba(255, 183, 0, 0.25); color: var(--cyber-gold);">
                                            <div
                                                style="width: 44px; height: 44px; margin: 0 auto 8px auto; background: rgba(255, 183, 0, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-phone-alt"
                                                    style="color: var(--cyber-gold); font-size: 18px;"></i>
                                            </div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: var(--cyber-gold); letter-spacing: 1px; text-transform: uppercase;">
                                                24/7 CALL DESK</div>
                                            <div
                                                style="font-size: 13.5px; font-weight: 700; color: #ffffff; margin-top: 3px; text-decoration: underline; text-underline-offset: 3px;">
                                                +1 (800) 234-5678</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="mailto:support@kredox.org" class="contact-hud-wrapper">
                                        <div class="p-3 text-center contact-hud-card"
                                            style="background: rgba(12, 6, 10, 0.85); border: 1.5px solid var(--cyber-red); border-radius: 14px; backdrop-filter: blur(12px); box-shadow: 0 0 20px rgba(255, 0, 60, 0.25); color: var(--cyber-red);">
                                            <div
                                                style="width: 44px; height: 44px; margin: 0 auto 8px auto; background: rgba(255, 0, 60, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-envelope"
                                                    style="color: var(--cyber-red); font-size: 18px;"></i>
                                            </div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: var(--cyber-red); letter-spacing: 1px; text-transform: uppercase;">
                                                EMAIL SUPPORT</div>
                                            <div
                                                style="font-size: 13.5px; font-weight: 700; color: #ffffff; margin-top: 3px; text-decoration: underline; text-underline-offset: 3px;">
                                                support@kredox.org</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-4">
                                    <a href="https://kredox.org/" target="_blank" class="contact-hud-wrapper">
                                        <div class="p-3 text-center contact-hud-card"
                                            style="background: rgba(12, 6, 10, 0.85); border: 1.5px solid #00ff88; border-radius: 14px; backdrop-filter: blur(12px); box-shadow: 0 0 20px rgba(0, 255, 136, 0.25); color: #00ff88;">
                                            <div
                                                style="width: 44px; height: 44px; margin: 0 auto 8px auto; background: rgba(0, 255, 136, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-globe" style="color: #00ff88; font-size: 18px;"></i>
                                            </div>
                                            <div
                                                style="font-family: var(--font-tech); font-size: 11px; font-weight: 800; color: #00ff88; letter-spacing: 1px; text-transform: uppercase;">
                                                OFFICIAL PORTAL</div>
                                            <div
                                                style="font-size: 13.5px; font-weight: 700; color: #00ff88; margin-top: 3px; text-decoration: underline; text-underline-offset: 3px;">
                                                https://kredox.org/</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Thumbnail Bar -->
            <div class="ppt-thumb-bar">
                <div class="thumb-box active" onclick="goToSlide(1)"><span>SLIDE 01</span>Overview</div>
                <div class="thumb-box" onclick="goToSlide(2)"><span>SLIDE 02</span>Protocol</div>
                <div class="thumb-box" onclick="goToSlide(3)"><span>SLIDE 03</span>$100 Start</div>
                <div class="thumb-box" onclick="goToSlide(4)"><span>SLIDE 04</span>ROI 12%</div>
                <div class="thumb-box" onclick="goToSlide(5)"><span>SLIDE 05</span>Trading</div>
                <div class="thumb-box" onclick="goToSlide(6)"><span>SLIDE 06</span>10 Levels</div>
                <div class="thumb-box" onclick="goToSlide(7)"><span>SLIDE 07</span>3X Cap</div>
                <div class="thumb-box" onclick="goToSlide(8)"><span>SLIDE 08</span>Withdrawal</div>
                <div class="thumb-box" onclick="goToSlide(9)"><span>SLIDE 09</span>Dual Matrix</div>
                <div class="thumb-box" onclick="goToSlide(10)"><span>SLIDE 10</span>Security</div>
                <div class="thumb-box" onclick="goToSlide(11)"><span>SLIDE 11</span>Action</div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        let currentSlide = 1;
        const totalSlides = 11;

        // Realtime Background High-Tech Trading Canvas Engine
        let bgChartInterval = null;
        let bgCandleData = [];

        function initBgTradingChartData() {
            bgCandleData = [];
            let basePrice = 100.00;
            const now = Date.now();
            for (let i = 35; i >= 0; i--) {
                const change = (Math.random() - 0.44) * 0.45;
                const open = basePrice;
                const close = basePrice + change;
                const high = Math.max(open, close) + Math.random() * 0.25;
                const low = Math.min(open, close) - Math.random() * 0.25;
                bgCandleData.push({ time: now - i * 60000, open, high, low, close });
                basePrice = close;
            }
        }

        function renderBgTradingChart() {
            const canvas = document.getElementById('tradingBgCanvas');
            if (!canvas) return;

            const wrapper = document.getElementById('pptWrapper');
            if (!wrapper) return;

            const rect = wrapper.getBoundingClientRect();
            if (rect.width === 0 || rect.height === 0) return;

            canvas.width = rect.width;
            canvas.height = rect.height;

            const ctx = canvas.getContext('2d');
            const width = rect.width;
            const height = rect.height;

            ctx.clearRect(0, 0, width, height);

            // Draw Cyber Grid Lines
            ctx.strokeStyle = 'rgba(255, 0, 60, 0.08)';
            ctx.lineWidth = 1;
            const gridRows = 8;
            const gridCols = 12;
            for (let i = 0; i <= gridRows; i++) {
                const y = (height / gridRows) * i;
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(width, y);
                ctx.stroke();
            }
            for (let j = 0; j <= gridCols; j++) {
                const x = (width / gridCols) * j;
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, height);
                ctx.stroke();
            }

            if (bgCandleData.length === 0) return;

            let minP = Math.min(...bgCandleData.map(c => c.low));
            let maxP = Math.max(...bgCandleData.map(c => c.high));
            minP -= 0.2;
            maxP += 0.2;

            const candleWidth = width / (bgCandleData.length + 2);

            // Draw Background Candlesticks & Glowing Moving Average Wave
            const points = [];
            bgCandleData.forEach((c, idx) => {
                const x = (idx + 1) * candleWidth;
                const openY = height - ((c.open - minP) / (maxP - minP)) * (height - 100) - 50;
                const closeY = height - ((c.close - minP) / (maxP - minP)) * (height - 100) - 50;
                const highY = height - ((c.high - minP) / (maxP - minP)) * (height - 100) - 50;
                const lowY = height - ((c.low - minP) / (maxP - minP)) * (height - 100) - 50;

                points.push({ x, y: closeY });

                const isGreen = c.close >= c.open;
                const color = isGreen ? '#00ff88' : '#ff003c';

                ctx.strokeStyle = color;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(x, highY);
                ctx.lineTo(x, lowY);
                ctx.stroke();

                const bodyTop = Math.min(openY, closeY);
                const bodyHeight = Math.max(Math.abs(closeY - openY), 4);
                ctx.fillStyle = isGreen ? 'rgba(0, 255, 136, 0.75)' : 'rgba(255, 0, 60, 0.75)';
                ctx.shadowColor = color;
                ctx.shadowBlur = 10;
                ctx.fillRect(x - candleWidth * 0.35, bodyTop, candleWidth * 0.7, bodyHeight);
                ctx.shadowBlur = 0;
            });

            // Glowing Trendline Wave Overlay
            if (points.length > 1) {
                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                for (let i = 1; i < points.length; i++) {
                    ctx.lineTo(points[i].x, points[i].y);
                }
                ctx.strokeStyle = '#00ff88';
                ctx.lineWidth = 3;
                ctx.shadowColor = '#00ff88';
                ctx.shadowBlur = 18;
                ctx.stroke();
                ctx.shadowBlur = 0;

                const grad = ctx.createLinearGradient(0, 0, 0, height);
                grad.addColorStop(0, 'rgba(0, 255, 136, 0.18)');
                grad.addColorStop(1, 'rgba(0, 255, 136, 0)');

                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                for (let i = 1; i < points.length; i++) {
                    ctx.lineTo(points[i].x, points[i].y);
                }
                ctx.lineTo(points[points.length - 1].x, height);
                ctx.lineTo(points[0].x, height);
                ctx.closePath();
                ctx.fillStyle = grad;
                ctx.fill();
            }

            // Price Marker Badge on Background Right Axis
            const lastCandle = bgCandleData[bgCandleData.length - 1];
            const lastY = points[points.length - 1].y;

            ctx.setLineDash([6, 6]);
            ctx.strokeStyle = '#00ff88';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(0, lastY);
            ctx.lineTo(width, lastY);
            ctx.stroke();
            ctx.setLineDash([]);

            ctx.fillStyle = '#00ff88';
            ctx.shadowColor = '#00ff88';
            ctx.shadowBlur = 20;
            ctx.beginPath();
            ctx.arc(points[points.length - 1].x, lastY, 6, 0, Math.PI * 2);
            ctx.fill();
            ctx.shadowBlur = 0;
        }

        function updateBgLiveTick() {
            if (bgCandleData.length === 0) return;
            const last = bgCandleData[bgCandleData.length - 1];
            const delta = (Math.random() - 0.4) * 0.18;
            last.close += delta;
            last.high = Math.max(last.high, last.close);
            last.low = Math.min(last.low, last.close);
            renderBgTradingChart();
        }

        function startBgTradingEngine() {
            if (bgChartInterval) clearInterval(bgChartInterval);
            initBgTradingChartData();
            setTimeout(renderBgTradingChart, 100);
            bgChartInterval = setInterval(updateBgLiveTick, 900);
        }

        function updateSlide() {
            document.querySelectorAll('.cyber-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            document.querySelectorAll('.thumb-box').forEach(thumb => {
                thumb.classList.remove('active');
            });

            const activeSlide = document.querySelector(`.cyber-slide[data-slide="${currentSlide}"]`);
            if (activeSlide) {
                activeSlide.classList.add('active');
            }

            const activeThumb = document.querySelectorAll('.thumb-box')[currentSlide - 1];
            if (activeThumb) {
                activeThumb.classList.add('active');
                const thumbBar = document.querySelector('.ppt-thumb-bar');
                if (thumbBar && thumbBar.scrollWidth > thumbBar.clientWidth) {
                    const scrollLeft = activeThumb.offsetLeft - (thumbBar.clientWidth / 2) + (activeThumb.clientWidth / 2);
                    thumbBar.scrollTo({ left: scrollLeft, behavior: 'smooth' });
                }
            }

            const slideStr = currentSlide < 10 ? `0${currentSlide}` : currentSlide;
            document.querySelectorAll('.slide-num-val').forEach(el => {
                el.innerText = slideStr;
            });
        }

        // Touch Swipe Gesture Engine for Mobile Devices
        let touchStartX = 0;
        let touchEndX = 0;

        function handleSwipe() {
            const swipeThreshold = 40;
            if (touchEndX < touchStartX - swipeThreshold) {
                nextSlide();
            } else if (touchEndX > touchStartX + swipeThreshold) {
                prevSlide();
            }
        }
        async function preprocessSlideArtImages() {
            const artImages = document.querySelectorAll('.slide-bg-art');
            const promises = Array.from(artImages).map(img => {
                return new Promise((resolve) => {
                    if (img.dataset.masked === 'true') return resolve();

                    const applyMask = () => {
                        try {
                            const canvas = document.createElement('canvas');
                            const w = img.naturalWidth || 500;
                            const h = img.naturalHeight || 500;
                            canvas.width = w;
                            canvas.height = h;

                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, w, h);

                            ctx.globalCompositeOperation = 'destination-in';
                            const grad = ctx.createRadialGradient(
                                w / 2, h / 2, 0,
                                w / 2, h / 2, Math.min(w, h) * 0.46
                            );
                            grad.addColorStop(0, 'rgba(0,0,0,1)');
                            grad.addColorStop(0.55, 'rgba(0,0,0,0.95)');
                            grad.addColorStop(0.82, 'rgba(0,0,0,0.25)');
                            grad.addColorStop(1, 'rgba(0,0,0,0)');

                            ctx.fillStyle = grad;
                            ctx.fillRect(0, 0, w, h);

                            img.src = canvas.toDataURL('image/png');
                            img.dataset.masked = 'true';
                            img.style.maskImage = 'none';
                            img.style.webkitMaskImage = 'none';
                        } catch (e) {
                            console.warn('Masking fallback:', e);
                        }
                        resolve();
                    };

                    if (img.complete && img.naturalWidth > 0) {
                        applyMask();
                    } else {
                        img.onload = applyMask;
                        img.onerror = () => resolve();
                    }
                });
            });

            await Promise.all(promises);
        }

        document.addEventListener('DOMContentLoaded', () => {
            startBgTradingEngine();
            preprocessSlideArtImages();
            window.addEventListener('resize', renderBgTradingChart);

            const stage = document.querySelector('.ppt-stage');
            if (stage) {
                stage.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                stage.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, { passive: true });
            }

        });

        function goToSlide(num) {
            if (num >= 1 && num <= totalSlides) {
                currentSlide = num;
                updateSlide();
            }
        }

        function nextSlide() {
            if (currentSlide < totalSlides) {
                currentSlide++;
            } else {
                currentSlide = 1;
            }
            updateSlide();
        }

        function prevSlide() {
            if (currentSlide > 1) {
                currentSlide--;
            } else {
                currentSlide = totalSlides;
            }
            updateSlide();
        }

        function toggleFullscreen() {
            const wrapper = document.getElementById('pptWrapper');
            if (!document.fullscreenElement) {
                if (wrapper.requestFullscreen) {
                    wrapper.requestFullscreen();
                } else if (wrapper.webkitRequestFullscreen) {
                    wrapper.webkitRequestFullscreen();
                }
                wrapper.classList.add('fullscreen-mode');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                wrapper.classList.remove('fullscreen-mode');
            }
        }

        document.addEventListener('fullscreenchange', () => {
            const wrapper = document.getElementById('pptWrapper');
            if (!document.fullscreenElement) {
                wrapper.classList.remove('fullscreen-mode');
            }
        });

        // Keyboard Arrow Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight' || e.key === 'Space') {
                nextSlide();
            } else if (e.key === 'ArrowLeft') {
                prevSlide();
            }
        });

        // Direct Live DOM High-Resolution 4K Canvas Capture Engine (100% 1:1 Website Replica)
        async function captureLiveSlideCanvas() {
            const stageWrapper = document.getElementById('pptWrapper');
            if (!stageWrapper) return null;

            await preprocessSlideArtImages();

            const pptActions = stageWrapper.querySelector('.ppt-actions');
            const pptThumbBar = stageWrapper.querySelector('.ppt-thumb-bar');
            const logoImg = stageWrapper.querySelector('.ppt-logo-img');
            const chartIcon = stageWrapper.querySelector('.ppt-chart-icon');

            // Temporarily hide action buttons & thumbnail bar during capture
            if (pptActions) pptActions.style.visibility = 'hidden';
            if (pptThumbBar) pptThumbBar.style.visibility = 'hidden';

            // Show Kredox logo and hide chart icon for PDF export only
            if (logoImg) logoImg.style.display = 'inline-block';
            if (chartIcon) chartIcon.style.display = 'none';

            try {
                const canvas = await html2canvas(stageWrapper, {
                    scale: 3.5,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#050204',
                    logging: false,
                    windowWidth: 1400
                });

                const imgData = canvas.toDataURL('image/jpeg', 0.98);

                // Extract clickable links from live slide
                const linksData = [];
                const activeSlide = stageWrapper.querySelector('.cyber-slide.active');
                if (activeSlide) {
                    const links = activeSlide.querySelectorAll('a[href]');
                    const wrapperRect = stageWrapper.getBoundingClientRect();

                    links.forEach(link => {
                        let href = link.getAttribute('href');
                        if (!href || href === '#' || href.startsWith('javascript:')) return;
                        if (href.startsWith('/')) {
                            href = window.location.origin + href;
                        }
                        const rect = link.getBoundingClientRect();
                        if (rect.width > 0 && rect.height > 0) {
                            const pdfX = ((rect.left - wrapperRect.left) / wrapperRect.width) * 297;
                            const pdfY = ((rect.top - wrapperRect.top) / wrapperRect.height) * 210;
                            const pdfW = (rect.width / wrapperRect.width) * 297;
                            const pdfH = (rect.height / wrapperRect.height) * 210;

                            linksData.push({ href, x: pdfX, y: pdfY, w: pdfW, h: pdfH });
                        }
                    });
                }

                return { imgData, links: linksData };
            } finally {
                if (pptActions) pptActions.style.visibility = 'visible';
                if (pptThumbBar) pptThumbBar.style.visibility = 'visible';
                if (logoImg) logoImg.style.display = 'none';
                if (chartIcon) chartIcon.style.display = 'inline-block';
            }
        }

        // High-Quality Live DOM PDF Export Function
        async function downloadPresentationPDF() {
            const downloadBtn = document.getElementById('downloadPdfBtn');
            const originalBtnText = downloadBtn ? downloadBtn.innerHTML : '';
            const originalSlide = currentSlide;

            const loaderOverlay = document.getElementById('pdfLoaderOverlay');
            const loaderStatus = document.getElementById('pdfLoaderStatus');
            const progressFill = document.getElementById('pdfProgressFill');

            if (downloadBtn) downloadBtn.disabled = true;
            if (loaderOverlay) loaderOverlay.style.display = 'flex';

            try {
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('landscape', 'mm', 'a4');
                const pdfWidth = 297;
                const pdfHeight = 210;

                for (let i = 1; i <= totalSlides; i++) {
                    const percent = Math.round((i / totalSlides) * 100);
                    if (loaderStatus) loaderStatus.innerText = `Capturing Slide ${i} of ${totalSlides} (${percent}%)...`;
                    if (progressFill) progressFill.style.width = `${percent}%`;

                    goToSlide(i);
                    await new Promise(resolve => setTimeout(resolve, 300));

                    const result = await captureLiveSlideCanvas();
                    if (result) {
                        if (i > 1) {
                            pdf.addPage('a4', 'landscape');
                        }
                        pdf.addImage(result.imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight, undefined, 'FAST');

                        result.links.forEach(link => {
                            pdf.link(link.x, link.y, link.w, link.h, { url: link.href });
                        });
                    }
                }

                pdf.save('Kredox_Official_Business_Presentation.pdf');
                showPdfSuccessToast('PDF Downloaded Successfully!');

            } catch (err) {
                console.error('PDF Export Error:', err);
                alert('Failed to generate PDF. Please try again.');
            } finally {
                goToSlide(originalSlide);
                if (downloadBtn) {
                    downloadBtn.innerHTML = originalBtnText;
                    downloadBtn.disabled = false;
                }
                if (loaderOverlay) {
                    loaderOverlay.style.display = 'none';
                }
            }
        }



        function showPdfSuccessToast(msg) {
            const existing = document.querySelector('.pdf-success-toast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.className = 'pdf-success-toast';
            toast.innerHTML = `<i class="fas fa-check-circle" style="font-size: 18px;"></i> ${msg || 'Downloaded Successfully!'}`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // High-Tech Presentation Share Functions
        function getShareUrl() {
            return "{{ route('public.presentation') }}";
        }

        function openShareModal() {
            const modal = document.getElementById('sharePptModal');
            if (modal) modal.style.display = 'flex';
        }

        function closeShareModal() {
            const modal = document.getElementById('sharePptModal');
            if (modal) modal.style.display = 'none';
        }

        function shareOnWhatsApp() {
            const url = getShareUrl();
            const text = encodeURIComponent("🚀 Explore Kredox Official 4K Business Presentation & High-Tech Ecosystem!\n\nView presentation here:\n" + url);
            window.open("https://api.whatsapp.com/send?text=" + text, "_blank");
        }

        function shareOnTelegram() {
            const url = getShareUrl();
            const text = encodeURIComponent("🚀 Explore Kredox Official 4K Business Presentation & High-Tech Ecosystem!");
            window.open("https://t.me/share/url?url=" + encodeURIComponent(url) + "&text=" + text, "_blank");
        }

        function shareOnFacebook() {
            const url = getShareUrl();
            window.open("https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url), "_blank");
        }

        function copyPresentationLink() {
            const input = document.getElementById('presentationShareUrlInput');
            if (input) {
                navigator.clipboard.writeText(input.value).then(() => {
                    const msg = document.getElementById('shareCopySuccessMsg');
                    if (msg) {
                        msg.style.display = 'block';
                        setTimeout(() => { msg.style.display = 'none'; }, 3000);
                    }
                });
            }
        }
    </script>
@endpush