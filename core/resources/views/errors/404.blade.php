<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '404 | Access Denied') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --trx-dark: #000000;
            --trx-red: #E60000;
            --trx-red-glow: rgba(230, 0, 0, 0.6);
            --trx-white: #ffffff;
            --font-main: 'Outfit', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            background-color: var(--trx-dark);
            color: var(--trx-white);
            font-family: var(--font-main);
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: relative;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Subtle Background Glow */
        body::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(230, 0, 0, 0.15) 0%, transparent 70%);
            z-index: 0;
            pointer-events: none;
        }

        .error-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20px;
            width: 100%;
            max-width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-evenly;
        }

        .content-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        /* Animated 404 Styles - ENLARGED */
        .animated-404-container {
            position: relative;
            width: clamp(250px, 50vh, 450px);
            height: clamp(250px, 50vh, 450px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glitch-wrapper {
            position: relative;
            z-index: 5;
        }

        .glitch-text {
            font-size: clamp(100px, 25vh, 250px);
            font-weight: 900;
            color: #fff;
            position: relative;
            text-shadow: 0.05em 0 0 rgba(255, 0, 0, 0.75),
                        -0.025em -0.05em 0 rgba(0, 255, 255, 0.75),
                        0.025em 0.05em 0 rgba(255, 255, 0, 0.75);
            animation: glitch 500ms infinite;
            margin: 0;
            letter-spacing: -10px;
        }

        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.8;
        }

        .glitch-text::before {
            animation: glitch-anim 650ms infinite;
            clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
            transform: translate(-0.025em, -0.0125em);
            color: #ff0000;
        }

        .glitch-text::after {
            animation: glitch-anim2 375ms infinite;
            clip-path: polygon(0 80%, 100% 20%, 100% 100%, 0 100%);
            transform: translate(0.0125em, 0.025em);
            color: #00ffff;
        }

        @keyframes glitch-anim {
            0% { clip-path: polygon(0 20%, 100% 20%, 100% 21%, 0 21%); }
            20% { clip-path: polygon(0 33%, 100% 33%, 100% 34%, 0 34%); }
            40% { clip-path: polygon(0 57%, 100% 57%, 100% 58%, 0 58%); }
            60% { clip-path: polygon(0 82%, 100% 82%, 100% 83%, 0 83%); }
            80% { clip-path: polygon(0 15%, 100% 15%, 100% 16%, 0 16%); }
            100% { clip-path: polygon(0 49%, 100% 49%, 100% 50%, 0 50%); }
        }

        @keyframes glitch-anim2 {
            0% { clip-path: polygon(0 10%, 100% 10%, 100% 11%, 0 11%); }
            25% { clip-path: polygon(0 45%, 100% 45%, 100% 46%, 0 46%); }
            50% { clip-path: polygon(0 85%, 100% 85%, 100% 86%, 0 86%); }
            75% { clip-path: polygon(0 25%, 100% 25%, 100% 26%, 0 26%); }
            100% { clip-path: polygon(0 65%, 100% 65%, 100% 66%, 0 66%); }
        }

        .glitch-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150%;
            height: 150%;
            background: radial-gradient(circle, rgba(230, 0, 0, 0.3) 0%, transparent 70%);
            filter: blur(40px);
            z-index: 1;
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 1; transform: translate(-50%, -50%) scale(1.1); }
        }

        /* Tech HUD Elements */
        .tech-hud {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .hud-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            border-radius: 50%;
            border: 1px dashed rgba(230, 0, 0, 0.3);
            transform: translate(-50%, -50%);
        }

        .hud-1 {
            width: clamp(230px, 45vh, 400px);
            height: clamp(230px, 45vh, 400px);
            border-style: solid;
            border-width: 2px;
            border-color: rgba(230, 0, 0, 0.1) transparent transparent transparent;
        }

        .hud-2 {
            width: clamp(200px, 40vh, 350px);
            height: clamp(200px, 40vh, 350px);
            border-style: dotted;
            border-color: rgba(230, 0, 0, 0.2);
        }

        .hud-line {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(230, 0, 0, 0.6), transparent);
            box-shadow: 0 0 15px rgba(230, 0, 0, 0.6);
            z-index: 3;
            animation: moveLine 4s infinite linear;
        }

        @keyframes moveLine {
            0% { top: 0%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        .error-title {
            font-size: clamp(22px, 5vh, 42px);
            font-weight: 900;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 6px;
            color: #fff;
            text-shadow: 0 0 30px rgba(230, 0, 0, 1);
        }

        .error-desc {
            font-size: clamp(14px, 2.2vh, 18px);
            color: rgba(255, 255, 255, 0.7);
            max-width: 700px;
            margin: 0 auto 20px;
            line-height: 1.6;
            padding: 0 20px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .trx-btn-container {
            margin-top: 20px;
            position: relative;
            z-index: 1000;
        }

        .trx-home-btn {
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%) !important;
            color: #ffffff !important;
            padding: 14px 40px !important;
            border-radius: 50px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 2px !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 12px !important;
            transition: all 0.3s ease !important;
            border: none !important;
            box-shadow: 0 10px 25px rgba(230, 0, 0, 0.5) !important;
            font-size: 15px !important;
            cursor: pointer !important;
        }

        .trx-home-btn:hover {
            transform: translateY(-5px) scale(1.05) !important;
            box-shadow: 0 15px 40px rgba(255, 0, 0, 0.7) !important;
            color: #ffffff !important;
            text-decoration: none !important;
        }

        /* Mobile Optimization */
        @media (max-width: 575px) {
            .animated-404-container {
                width: 280px;
                height: 280px;
                margin-bottom: 0px;
            }

            .glitch-text {
                font-size: 110px;
                letter-spacing: -5px;
            }

            .hud-1 {
                width: 260px;
                height: 260px;
            }

            .hud-2 {
                width: 220px;
                height: 220px;
            }

            .error-title {
                font-size: 20px;
                letter-spacing: 2px;
                margin-bottom: 5px;
            }

            .error-desc {
                font-size: 13px;
                max-width: 340px;
                line-height: 1.4;
                margin-bottom: 10px;
            }

            .trx-btn-container {
                margin-top: 10px;
            }

            .trx-home-btn {
                padding: 12px 35px !important;
                font-size: 14px !important;
            }
        }

        /* Glitch Effect Overlay */
        .scanline {
            width: 100%;
            height: 100px;
            z-index: 5;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0) 0%, rgba(255, 0, 0, 0.05) 50%, rgba(0, 0, 0, 0) 100%);
            opacity: 0.1;
            position: absolute;
            bottom: 100%;
            animation: scanline 10s linear infinite;
        }

        @keyframes scanline {
            0% { bottom: 100%; }
            100% { bottom: -100%; }
        }

        /* Grid Background */
        .bg-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(230, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(230, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 1;
            opacity: 0.3;
        }
    </style>
</head>

<body>
    <div class="bg-grid"></div>
    <div class="scanline"></div>

    <div class="error-wrapper">
        <div class="content-box">
            <!-- Custom Animated 404 -->
            <div class="animated-404-container">
                <div class="glitch-wrapper">
                    <h1 class="glitch-text" data-text="404">404</h1>
                    <div class="glitch-glow"></div>
                </div>
                <div class="tech-hud">
                    <div class="hud-circle hud-1"></div>
                    <div class="hud-circle hud-2"></div>
                    <div class="hud-line"></div>
                </div>
            </div>
            
            <h2 class="error-title">PROTOCOL BREACH DETECTED</h2>
            <p class="error-desc">
                ACCESS DENIED. The encrypted resource you are attempting to retrieve has been declassified, relocated, or purged from our secure network layers. Unauthorized access attempts are being logged and monitored by the TRX-Security Protocol.
            </p>
        </div>

        <!-- Isolated Button -->
        <div class="trx-btn-container">
            <a href="{{ route('home') }}" class="trx-home-btn">
                <i class="fas fa-home mr-2"></i> GO TO HOME PAGE
            </a>
        </div>
    </div>

    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tl = gsap.timeline();

            tl.from('.glitch-text', {
                duration: 1.5,
                scale: 2,
                opacity: 0,
                ease: "power4.out"
            })
            .from('.error-title', {
                duration: 1,
                y: 20,
                opacity: 0,
                ease: "power3.out"
            }, "-=0.8")
            .from('.error-desc', {
                duration: 1,
                y: 20,
                opacity: 0,
                ease: "power3.out"
            }, "-=0.8");

            // Technical HUD rotation
            gsap.to('.hud-1', { rotation: 360, duration: 10, repeat: -1, ease: "none" });
            gsap.to('.hud-2', { rotation: -360, duration: 15, repeat: -1, ease: "none" });
            
            // Random Glitch Jitter
            setInterval(() => {
                if(Math.random() > 0.95) {
                    gsap.to('.glitch-text', {
                        x: () => (Math.random() - 0.5) * 10,
                        y: () => (Math.random() - 0.5) * 10,
                        duration: 0.1,
                        repeat: 3,
                        yoyo: true,
                        onComplete: () => gsap.set('.glitch-text', { x: 0, y: 0 })
                    });
                }
            }, 500);
        });
    </script>
</body>

</html>

