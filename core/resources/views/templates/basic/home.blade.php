@extends($activeTemplate . 'layouts.frontend')
@section('content')

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        html, body {
        overflow-x: hidden !important;
        width: 100%;
        position: relative;
    }

    :root {
            --primary-red: #ff0000;
            --deep-red: #8b0000;
            --black-pure: #000000;
            --black-card: #080808;
            --black-soft: #121212;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 0, 0, 0.2);
            --text-main: #ffffff;
            --text-dim: #b0b0b0;
            --glow-red: 0 0 30px rgba(255, 0, 0, 0.5);
        }

        body {
            background: var(--black-pure);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        /* Moving Background Mesh */
        .mesh-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 0, 0, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(139, 0, 0, 0.05) 0%, transparent 40%);
            z-index: -1;
            pointer-events: none;
        }

        #liveTradingBg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            pointer-events: none;
            opacity: 0.20; /* Reduced opacity for a darker, more subtle feel */
        }

        /* Hero Section Elite */
        .hero-elite {
            padding: 140px 0 60px 0;
            position: relative;
            display: flex;
            align-items: center;
        }

        .hero-content-v3 {
            position: relative;
            z-index: 10;
        }

        .hero-label {
            background: linear-gradient(90deg, rgba(255, 0, 0, 0.2), transparent);
            border-left: 3px solid var(--primary-red);
            padding: 10px 20px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 14px;
            margin-bottom: 30px;
            display: inline-block;
            animation: slideInLeft 0.8s ease;
        }

        .hero-elite h1 {
            font-size: clamp(50px, 10vw, 110px);
            font-weight: 900;
            line-height: 0.85;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: -4px;
        }

        .hero-elite h1 span {
            display: block;
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.3);
        }

        .hero-elite h1 .filled {
            color: var(--primary-red);
            -webkit-text-stroke: 0;
            text-shadow: var(--glow-red);
        }

        .hero-p {
            font-size: 22px;
            color: var(--text-dim);
            max-width: 650px;
            line-height: 1.5;
            margin-bottom: 50px;
            border-left: 2px solid rgba(255, 255, 255, 0.1);
            padding-left: 30px;
        }

        /* Live Chart Integration */
        .chart-container {
            background: var(--black-card);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 20px;
            box-shadow: var(--glow-red);
            position: relative;
            height: 600px;
            transition: all 0.3s ease;
        }

        /* Stats Floating */
        .floating-stats {
            position: absolute;
            bottom: -15px;
            right: -15px;
            background: linear-gradient(135deg, var(--primary-red), #b30000);
            padding: 25px 35px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(255, 0, 0, 0.4);
            z-index: 20;
            transform: rotate(-3deg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .floating-stats h4 {
            font-size: 14px;
            letter-spacing: 2px;
            opacity: 0.9;
            font-weight: 700;
        }

        .floating-stats h2 {
            font-size: 42px;
            line-height: 1;
            margin-top: 5px;
        }

        /* Enhanced Comparison Section */
        .comparison-section {
            padding: 60px 0;
            background: var(--black-pure);
            position: relative;
        }

        .comparison-wrapper {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 40px;
            padding: 100px 60px;
            position: relative;
            box-shadow: 0 0 40px rgba(255, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .comparison-wrapper:hover {
            border-color: var(--primary-red);
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.2);
        }

        .comp-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .comp-header {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr;
            padding: 20px 40px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
            color: var(--text-dim);
        }

        .feature-row {
            background: var(--black-card);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px 40px;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1.2fr;
            align-items: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
        }

        .feature-row.active {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-row:hover {
            border-color: var(--primary-red);
            background: #0c0c0c;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.1);
        }

        .feature-row::after {
            display: none;
        }

        .feature-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .feature-info i {
            width: 50px;
            height: 50px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 22px;
            transition: 0.3s;
        }

        .feature-row:hover .feature-info i {
            background: rgba(255, 0, 0, 0.2);
            color: var(--primary-red);
        }

        .feature-title h5 {
            margin: 0;
            font-weight: 800;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .feature-title p {
            margin: 2px 0 0 0;
            font-size: 13px;
            color: var(--text-dim);
            font-weight: 500;
        }

        .other-val {
            color: #777;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
        }

        .elite-val {
            background: rgba(255, 0, 0, 0.03);
            padding: 12px 25px;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.1);
            text-align: center;
            font-weight: 800;
            color: white;
            transition: all 0.3s ease;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .elite-val i {
            width: 0;
            overflow: hidden;
            transition: 0.3s;
            color: var(--primary-red);
            font-size: 18px;
        }

        .feature-row:hover .elite-val {
            background: rgba(255, 0, 0, 0.08);
            border-color: var(--primary-red);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .feature-row:hover .elite-val i {
            width: 20px;
            margin-right: 5px;
        }

        @media (max-width: 991px) {
            .comp-header {
                display: none;
            }
            .feature-row {
                grid-template-columns: 1fr;
                gap: 20px;
                text-align: center;
                padding: 30px;
            }
            .feature-info {
                flex-direction: column;
            }
            .other-val {
                justify-content: center;
            }
        }

        /* Global Network Map */
        .map-section {
            padding: 47px 0;
            background: radial-gradient(circle at center, rgba(255, 0, 0, 0.05) 0%, transparent 70%);
        }

        .map-container {
            position: relative;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 40px;
            padding: 100px 40px;
            border: 1px solid rgba(255, 0, 0, 0.3);
            box-shadow: 0 0 40px rgba(255, 0, 0, 0.1);
            overflow: hidden;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .map-container:hover {
            border-color: var(--primary-red);
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.2);
        }

        .map-svg {
            width: 100%;
            opacity: 0.15;
            filter: invert(1) brightness(1.5);
        }

        .hotspot {
            position: absolute;
            width: 12px;
            height: 12px;
            background: var(--primary-red);
            border-radius: 50%;
            z-index: 10;
        }

        .hotspot::before,
        .hotspot::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: var(--primary-red);
            opacity: 0.5;
            animation: pulse-red 2s infinite;
        }

        .hotspot::after {
            animation-delay: 1s;
        }

        @keyframes pulse-red {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            100% { transform: translate(-50%, -50%) scale(4); opacity: 0; }
        }

        .hotspot-label {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(10, 10, 10, 0.9);
            backdrop-filter: blur(10px);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-left: 4px solid var(--primary-red);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            pointer-events: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hotspot-label::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--primary-red);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--primary-red);
        }

        /* Elite Testimonials */
        /* Network Preview Split Layout */
        .network-preview-wrapper {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 40px;
            padding: 80px 60px;
            position: relative;
            box-shadow: 0 0 40px rgba(255, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }

        .network-flex-container {
            display: flex;
            align-items: center;
            gap: 60px;
            flex-wrap: wrap;
        }

        .network-visual-side {
            flex: 1.2;
            min-width: 400px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 30px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .network-content-side {
            flex: 0.8;
            text-align: left;
        }

        .network-content-side h3 {
            font-size: 45px;
            font-weight: 900;
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .network-content-side p {
            font-size: 18px;
            color: var(--text-dim);
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .network-feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .network-feature-list li {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 16px;
            color: white;
        }

        .network-feature-list i {
            width: 35px;
            height: 35px;
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 14px;
        }

        .tree-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .tree-node {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .tree-avatar-wrapper {
            position: relative;
            width: 85px;
            height: 85px;
            margin-bottom: 12px;
        }

        .tree-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid var(--primary-red);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.4);
            background: #000;
            padding: 3px;
        }

        .status-dot {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            background: #00ff00;
            border-radius: 50%;
            border: 2px solid #000;
            box-shadow: 0 0 10px #00ff00;
        }

        .tree-label {
            background: rgba(10, 10, 10, 0.9);
            border: 1px solid rgba(255, 0, 0, 0.3);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 900;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .tree-branches {
            display: flex;
            gap: 120px;
            margin-top: 50px;
            position: relative;
        }

        /* High-Fidelity Tree Node Cards */
        .tree-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 0;
            width: 100%;
        }

        .tree-node-card {
            background: #0f0f0f;
            border: 1px solid #222;
            border-radius: 15px;
            width: 220px;
            position: relative;
            z-index: 5;
            overflow: visible;
            transition: 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .tree-node-card:hover {
            border-color: var(--primary-red);
            transform: translateY(-5px);
        }

        .tree-card-top {
            padding: 20px 15px;
            text-align: center;
        }

        .tree-avatar-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 12px;
            position: relative;
        }

        .tree-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--primary-red);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
            object-fit: cover;
        }

        .tree-name {
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .tree-username {
            color: #666;
            font-size: 11px;
            display: block;
            margin-bottom: 8px;
        }

        .tree-level-badge {
            background: rgba(255, 0, 0, 0.1);
            color: var(--primary-red);
            font-size: 9px;
            font-weight: 900;
            padding: 2px 10px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .tree-card-bottom {
            display: flex;
            border-top: 1px solid #1a1a1a;
            background: #0a0a0a;
            border-radius: 0 0 15px 15px;
        }

        .tree-stat {
            flex: 1;
            padding: 10px 5px;
            text-align: center;
            border-right: 1px solid #1a1a1a;
        }

        .tree-stat:last-child { border-right: none; }

        .tree-stat small {
            display: block;
            color: #444;
            font-size: 8px;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .tree-stat span {
            color: #fff;
            font-size: 12px;
            font-weight: 700;
        }

        .tree-stat i {
            color: var(--primary-red);
            font-size: 10px;
            margin-right: 3px;
        }

        .tree-expand-btn {
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 30px;
            background: #000;
            border: 2px solid #222;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
        }

        .tree-node-card:hover .tree-expand-btn {
            border-color: var(--primary-red);
            color: var(--primary-red);
            box-shadow: 0 0 10px var(--primary-red);
        }

        .tree-branches {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            position: relative;
        }

        /* Clean Connecting Lines */
        .tree-node.root::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 50%;
            width: 2px;
            height: 30px;
            background: var(--primary-red);
            z-index: 1;
        }

        .tree-horizontal-line {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 220px);
            height: 2px;
            background: var(--primary-red);
            z-index: 1;
        }

        /* ==========================================================================
           Mobile Perfection Suite (Ek Number View)
           ========================================================================== */
        @media (max-width: 991px) {
            .hero-title {
                font-size: clamp(40px, 12vw, 60px) !important;
                line-height: 1 !important;
            }

            .section-padding { padding: 0px 0; }
            
            .comparison-wrapper, .network-preview-wrapper, .testimonial-wrapper, .cta-wrapper {
                width: 100% !important;
                margin: 0 !important;
                padding: 40px 15px;
                border-radius: 25px;
                overflow: hidden; /* Prevent child overflow */
            }

            .network-flex-container {
                flex-direction: column;
                text-align: center;
                gap: 40px;
                width: 100%;
            }

            .network-visual-side {
                width: 100%;
                min-width: unset;
                padding: 20px 10px;
            }

            /* Tree Scaling for Mobile */
            .tree-preview {
                transform: scale(0.7);
                transform-origin: center top;
                margin-bottom: -100px;
                width: 100%;
            }

            .tree-branches {
                gap: 40px;
            }

            .tree-horizontal-line {
                width: calc(100% - 120px);
            }

            .tree-node-card {
                width: 180px;
            }

            .cta-title { font-size: 36px; }
            .cta-subtitle { font-size: 15px; }
            
            /* Map Perfection on Mobile */
            .map-container {
                padding: 40px 0;
                border-radius: 20px;
                overflow-x: auto; /* Allow panning on small screens */
                -webkit-overflow-scrolling: touch;
            }

            .map-svg {
                min-width: 600px; /* Ensure map is readable on mobile */
                height: auto;
            }
            
            .hotspot-label {
                font-size: 9px;
                padding: 3px 8px;
                left: 15px;
            }

            .testimonial-card h5, .testimonial-card h6 {
                color: #ffffff !important;
            }
        }

        @media (max-width: 575px) {
            .tree-preview {
                transform: scale(0.65);
                margin-bottom: -120px;
            }
            
            .tree-branches {
                gap: 20px;
            }

            .comparison-wrapper h2, .section-header-elite h2 {
                font-size: 28px;
            }

            .btn-vip, .btn-glass {
                width: 100%;
                padding: 16px 20px !important;
                font-size: 13px !important;
                text-align: center;
                display: block;
            }

            .cta-group {
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                gap: 10px !important;
                justify-content: center;
            }

            .cta-group .btn-vip, .cta-group .btn-glass {
                width: auto !important;
                flex: 1;
                padding: 14px 5px !important;
                font-size: 11px !important;
                white-space: nowrap;
            }

            .trust-badge {
                width: 100%;
                justify-content: center;
                margin-top: 10px;
            }
        }

        /* Final CTA Elite */
        .cta-section {
            padding: 25px 0;
            background: radial-gradient(circle at center, rgba(255, 0, 0, 0.05) 0%, var(--black-pure) 70%);
            position: relative;
            text-align: center;
        }

        .cta-wrapper {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 40px;
            padding: 80px 40px;
            position: relative;
            box-shadow: 0 0 40px rgba(255, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .cta-wrapper:hover {
            border-color: var(--primary-red);
            box-shadow: 0 0 50px rgba(255, 0, 0, 0.2);
        }

        .cta-title {
            font-size: clamp(45px, 8vw, 90px);
            font-weight: 900;
            line-height: 0.9;
            margin-bottom: 30px;
            letter-spacing: -2px;
        }

        .cta-title span {
            display: block;
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.3);
        }

        .cta-subtitle {
            font-size: 20px;
            color: var(--text-dim);
            max-width: 800px;
            margin: 0 auto 50px;
            font-weight: 500;
            line-height: 1.6;
        }

        .cta-features {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .cta-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cta-feature-item i {
            color: var(--primary-red);
        }

        .quote-icon {
            position: absolute;
            top: 30px;
            right: 40px;
            font-size: 50px;
            color: rgba(255, 0, 0, 0.05);
            transition: 0.3s;
        }

        .testimonial-card:hover .quote-icon {
            color: rgba(255, 0, 0, 0.15);
            transform: rotate(-10deg);
        }

        .stars {
            color: #ffc107;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .user-info img {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            border: 2px solid var(--primary-red);
            object-fit: cover;
        }

        /* Buttons Elite */
        .btn-vip {
            background: var(--primary-red);
            color: white;
            padding: 18px 45px;
            border-radius: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
            text-decoration: none;
            display: inline-block;
        }

        .btn-vip:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 0, 0, 0.5);
            color: white;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            padding: 18px 45px;
            border-radius: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-decoration: none;
            display: inline-block;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
            color: white;
        }

        /* Map Badge */
        .stat-badge {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid var(--primary-red);
            padding: 12px 25px;
            border-radius: 100px;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(10px);
            z-index: 10;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #00ff00;
            border-radius: 50%;
            box-shadow: 0 0 10px #00ff00;
            animation: blink-dot 1.5s infinite;
        }

        @keyframes blink-dot {
            0% { opacity: 0.3; }
            50% { opacity: 1; }
            100% { opacity: 0.3; }
        }

        /* Section Headers */
        .section-header-elite {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header-elite h2 {
            font-size: clamp(35px, 5vw, 65px);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -2px;
        }

        .red-line {
            width: 100px;
            height: 4px;
            background: var(--primary-red);
            margin: 20px auto;
            border-radius: 2px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--black-pure);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-red);
            border-radius: 10px;
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 991px) {
            .hero-elite {
                padding-top: 100px;
                padding-bottom: 40px;
                text-align: center;
            }

            .hero-p {
                padding-left: 0;
                border-left: none;
                margin-left: auto;
                margin-right: auto;
            }

            .chart-container {
                height: 450px;
                margin-top: 50px;
            }

            .floating-stats {
                display: none;
            }
        }
    </style>

    <!-- Global Background Elements -->
    <canvas id="liveTradingBg"></canvas>
    <div class="mesh-gradient"></div>

    <section class="hero-elite">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content-v3">
                        <span class="hero-label">The Gold Standard of 4X</span>
                        <h1>
                            <span>ELEVATE</span>
                            <span class="filled">YOUR PROFIT</span>
                            <span>TO THE MAX</span>
                        </h1>
                        <p class="hero-p">Stop guessing. Start winning. Join the elite network of 4X traders using
                            institutional-grade tools to dominate the global markets.</p>
                        <div class="cta-group d-flex gap-3 flex-wrap">
                            <a href="{{ route('user.register') }}" class="btn-vip">Join Elite Now</a>
                            <a href="#chart-section" class="btn-glass">Live Market Data</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="chart-container reveal">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container" style="height:100%;width:100%">
                            <div id="tradingview_12345" style="height:100%;width:100%"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                            <script type="text/javascript">
                                new TradingView.widget({
                                    "autosize": true,
                                    "symbol": "FX:EURUSD",
                                    "interval": "D",
                                    "timezone": "Etc/UTC",
                                    "theme": "dark",
                                    "style": "1",
                                    "locale": "en",
                                    "toolbar_bg": "#f1f3f6",
                                    "enable_publishing": false,
                                    "allow_symbol_change": true,
                                    "container_id": "tradingview_12345"
                                });
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                        <div class="floating-stats">
                            <h4 class="mb-0">LIVE ACCURACY</h4>
                            <h2 class="fw-bold mb-0">98.4%</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Elite Section -->
    <section class="about-elite-section" id="about-section">
        <div class="container">
            <div class="about-fortress-wrapper reveal">
                <div class="row align-items-center g-5">
                    <!-- Content Side -->
                    <div class="col-xl-6">
                        <div class="about-content-premium">
                            <span class="badge-elite">INSTITUTIONAL GRADE</span>
                            <h2 class="massive-title mt-3">DRIVING THE FUTURE OF <span class="text-danger">4X STRATEGY</span></h2>
                            <p class="about-lead">Since our inception, we have been committed to engineering the world's most powerful trading ecosystem for elite investors and visionaries.</p>
                            
                            <!-- Bento Grid Stats -->
                            <div class="about-bento-grid mt-5">
                                <div class="bento-item">
                                    <div class="bento-icon"><i class="fas fa-microchip"></i></div>
                                    <h4>10ms</h4>
                                    <p>Execution Speed</p>
                                </div>
                                <div class="bento-item">
                                    <div class="bento-icon"><i class="fas fa-globe-americas"></i></div>
                                    <h4>150+</h4>
                                    <p>Countries Served</p>
                                </div>
                                <div class="bento-item featured">
                                    <div class="bento-icon"><i class="fas fa-vault"></i></div>
                                    <h4>$500M+</h4>
                                    <p>Locked Liquidity</p>
                                </div>
                                <div class="bento-item">
                                    <div class="bento-icon"><i class="fas fa-users-viewfinder"></i></div>
                                    <h4>1M+</h4>
                                    <p>Active Nodes</p>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-4 flex-wrap">
                                <a href="{{ route('user.register') }}" class="btn-vip">Join The Elite</a>
                                <div class="trust-badge">
                                    <i class="fas fa-certificate text-danger"></i>
                                    <span>Certified Institutional Provider</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Side -->
                    <div class="col-xl-6" style="transition-delay: 0.2s">
                        <div class="about-visual-container">
                            <div class="volumetric-core">
                                <div class="core-ring"></div>
                                <div class="core-ring"></div>
                                <div class="core-ring"></div>
                                <i class="fas fa-cube core-icon"></i>
                            </div>
                            
                            <!-- Floating Tech Nodes -->
                            <div class="floating-node node-1"><i class="fas fa-chart-pie"></i></div>
                            <div class="floating-node node-2"><i class="fas fa-link"></i></div>
                            <div class="floating-node node-3"><i class="fas fa-fingerprint"></i></div>
                            
                            <!-- Secondary Elite Icon -->
                            <div class="elite-achievement-icon">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Elite Section -->
    <section class="how-it-works-elite" id="how-it-works">
        <div class="container">
            <div class="section-header-elite reveal text-center mb-5">
                <span class="badge-elite">3-STEP BLUEPRINT</span>
                <h2 class="massive-title mt-3">INSTITUTIONAL <span class="text-danger">WORKFLOW</span></h2>
                <div class="red-line mx-auto mt-3"></div>
                <p class="mt-4 about-lead mx-auto">Follow our precision-engineered onboarding process to activate your elite status.</p>
            </div>

            <div class="flow-container mt-5">
                <div class="row g-0 justify-content-center">
                    <!-- Step 1 -->
                    <div class="col-lg-4 reveal">
                        <div class="flow-card">
                            <div class="flow-step-num">01</div>
                            <div class="flow-icon"><i class="fas fa-id-card-clip"></i></div>
                            <h3>SECURE ACCESS</h3>
                            <p>Initialize your identity within our high-tier encrypted database. Seconds to join, a lifetime of elite access.</p>
                            <div class="flow-connector d-none d-lg-block"></div>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="col-lg-4 reveal" style="transition-delay: 0.1s">
                        <div class="flow-card">
                            <div class="flow-step-num">02</div>
                            <div class="flow-icon"><i class="fas fa-money-bill-transfer"></i></div>
                            <h3>CAPITAL DEPLOYMENT</h3>
                            <p>Allocate your trading capital through our multi-signature secure vault. Instant verification, zero-gap liquidity.</p>
                            <div class="flow-connector d-none d-lg-block"></div>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="col-lg-4 reveal" style="transition-delay: 0.2s">
                        <div class="flow-card">
                            <div class="flow-step-num">03</div>
                            <div class="flow-icon"><i class="fas fa-chart-line"></i></div>
                            <h3>STRATEGY ACTIVATION</h3>
                            <p>Execute elite trading algorithms and monitor real-time network growth with institutional precision.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .about-elite-section {
            padding: 60px 0;
            background: radial-gradient(circle at 10% 20%, rgba(255, 0, 0, 0.03) 0%, transparent 50%);
            overflow: hidden;
            position: relative;
        }

        .badge-elite {
            background: rgba(255, 0, 0, 0.1);
            color: var(--primary-red);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 2px;
            border: 1px solid rgba(255, 0, 0, 0.2);
        }

        .massive-title {
            font-size: clamp(35px, 5vw, 65px);
            font-weight: 900;
            line-height: 1.1;
            color: white;
        }

        .about-lead {
            font-size: 18px;
            color: var(--text-dim);
            margin-top: 25px;
            max-width: 600px;
        }

        .about-bento-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }

        .bento-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 30px 20px;
            border-radius: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .bento-item:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 0, 0, 0.3);
            transform: translateY(-5px);
        }

        .bento-item.featured {
            background: linear-gradient(135deg, rgba(255, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0) 100%);
            border-color: rgba(255, 0, 0, 0.3);
            grid-column: span 1;
        }

        .bento-icon {
            font-size: 24px;
            color: var(--primary-red);
            margin-bottom: 15px;
        }

        .bento-item h4 {
            color: white;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .bento-item p {
            color: var(--text-dim);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        /* Volumetric Visual */
        .about-visual-container {
            position: relative;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .volumetric-core {
            position: relative;
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .core-icon {
            font-size: 80px;
            color: var(--primary-red);
            z-index: 5;
            text-shadow: 0 0 50px var(--primary-red);
            animation: float-core 4s ease-in-out infinite;
        }

        .core-ring {
            position: absolute;
            border: 2px solid rgba(255, 0, 0, 0.2);
            border-radius: 50%;
            animation: spin-ring 10s linear infinite;
        }

        .core-ring:nth-child(1) { width: 100%; height: 100%; border-style: dashed; }
        .core-ring:nth-child(2) { width: 140%; height: 140%; animation-direction: reverse; border-style: dotted; }
        .core-ring:nth-child(3) { width: 180%; height: 180%; opacity: 0.1; }

        .floating-node {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            animation: float-node 6s ease-in-out infinite;
        }

        .node-1 { top: 10%; right: 10%; animation-delay: 0s; }
        .node-2 { bottom: 15%; right: 20%; animation-delay: 1s; }
        .node-3 { top: 20%; left: 10%; animation-delay: 2s; }

        @keyframes float-core {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes spin-ring {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes float-node {
            0%, 100% { transform: translate(0, 0); }
            33% { transform: translate(10px, -15px); }
            66% { transform: translate(-10px, 10px); }
        }

        @media (max-width: 991px) {
            .about-visual-container { height: 400px; margin-top: 40px; }
            .massive-title { font-size: 35px; }
            .bento-item { padding: 20px 10px; }
        }

        .how-it-works-elite {
            padding: 60px 0;
            background: radial-gradient(circle at 90% 10%, rgba(255, 0, 0, 0.05) 0%, transparent 40%);
            position: relative;
        }

        .flow-container {
            position: relative;
            padding: 40px 0;
        }

        .flow-card {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            backdrop-filter: blur(10px);
        }

        .flow-card:hover {
            background: rgba(255, 0, 0, 0.03);
            border-color: var(--primary-red);
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(255, 0, 0, 0.1);
            z-index: 5;
        }

        .flow-step-num {
            font-size: 120px;
            font-weight: 900;
            line-height: 0.8;
            color: rgba(255, 0, 0, 0.05);
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
            transition: all 0.3s ease;
        }

        .flow-card:hover .flow-step-num {
            color: rgba(255, 0, 0, 0.1);
            transform: translateX(-50%) scale(1.1);
        }

        .flow-icon {
            font-size: 45px;
            color: var(--primary-red);
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
            text-shadow: 0 0 20px rgba(255, 0, 0, 0.4);
        }

        .flow-card h3 {
            color: white;
            font-weight: 900;
            font-size: 20px;
            letter-spacing: 2px;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .flow-card p {
            color: var(--text-dim);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
            position: relative;
            z-index: 2;
        }

        .flow-connector {
            position: absolute;
            top: 50%;
            right: -30px;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-red), transparent);
            z-index: 10;
            box-shadow: 0 0 15px var(--primary-red);
        }

        .flow-connector::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background: var(--primary-red);
            border-radius: 50%;
            box-shadow: 0 0 15px var(--primary-red);
        }

        @media (max-width: 991px) {
            .flow-card {
                padding: 50px 30px;
                border-bottom: 1px solid rgba(255, 0, 0, 0.2);
            }
            .flow-step-num { font-size: 80px; }
        }
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: var(--primary-red);
            margin: 0 auto 25px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
        }
        .step-card h4 {
            color: white;
            font-weight: 800;
            margin-bottom: 15px;
        }
        .step-card p {
            color: var(--text-dim);
            font-size: 15px;
            margin-bottom: 0;
        }
    </style>

    <!-- Elite Comparison Section -->
    <section class="comparison-section-elite" id="chart-section">
        <div class="container">
            <div class="comparison-fortress reveal">
                <div class="section-header-elite text-center">
                    <span class="badge-elite">COMPETITIVE EDGE</span>
                    <h2 class="massive-title mt-3">THE ELITE <span class="text-danger">ADVANTAGE</span></h2>
                    <div class="red-line mx-auto"></div>
                </div>

                <div class="elite-comp-table mt-5">
                    <div class="comp-row head-row">
                        <div class="feature-col">Architectural Features</div>
                        <div class="legacy-col">Legacy Platforms</div>
                        <div class="elite-col">4X Strategy Elite</div>
                    </div>

                    <!-- Row 1 -->
                    <div class="comp-row reveal">
                        <div class="feature-col">
                            <i class="fas fa-bolt text-danger"></i>
                            <span>Execution Liquidity</span>
                        </div>
                        <div class="legacy-col">Delayed / Retail</div>
                        <div class="elite-col">
                            <span class="glow-text">Institutional Instant</span>
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="comp-row reveal" style="transition-delay: 0.1s">
                        <div class="feature-col">
                            <i class="fas fa-vault text-danger"></i>
                            <span>Fund Security</span>
                        </div>
                        <div class="legacy-col">Hot Wallets / Basic</div>
                        <div class="elite-col">
                            <span class="glow-text">Multi-Sig Cold Storage</span>
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="comp-row reveal" style="transition-delay: 0.2s">
                        <div class="feature-col">
                            <i class="fas fa-brain text-danger"></i>
                            <span>AI Neural Engine</span>
                        </div>
                        <div class="legacy-col">Manual / Basic Indicators</div>
                        <div class="elite-col">
                            <span class="glow-text">98.4% Accuracy AI</span>
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>

                    <!-- Row 4 -->
                    <div class="comp-row reveal" style="transition-delay: 0.3s">
                        <div class="feature-col">
                            <i class="fas fa-headset text-danger"></i>
                            <span>Support Tier</span>
                        </div>
                        <div class="legacy-col">Ticket Based</div>
                        <div class="elite-col">
                            <span class="glow-text">24/7 Concierge</span>
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .comparison-section-elite {
            padding: 60px 0;
            background: linear-gradient(180deg, var(--black-pure) 0%, rgba(255, 0, 0, 0.02) 100%);
        }

        .comparison-fortress {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 0, 0, 0.1);
            border-radius: 40px;
            padding: 80px 40px;
            position: relative;
            overflow: hidden;
        }

        .elite-comp-table {
            width: 100%;
        }

        .comp-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            align-items: center;
            transition: all 0.3s ease;
        }

        .comp-row:not(.head-row):hover {
            background: rgba(255, 255, 255, 0.02);
            border-bottom-color: rgba(255, 0, 0, 0.3);
        }

        .head-row {
            border-bottom: 2px solid rgba(255, 0, 0, 0.3);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
            color: var(--text-dim);
        }

        .feature-col {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            font-weight: 700;
        }

        .feature-col i {
            font-size: 18px;
            width: 30px;
        }

        .legacy-col {
            color: var(--text-dim);
            font-weight: 500;
        }

        .elite-col {
            color: white;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .elite-col i {
            color: var(--primary-red);
            font-size: 18px;
            text-shadow: 0 0 10px var(--primary-red);
        }

        .glow-text {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 991px) {
            .comparison-fortress {
                padding: 20px 10px;
                border: none;
                background: transparent;
                box-shadow: none;
            }
            .elite-comp-table {
                display: flex;
                flex-direction: column;
                gap: 25px;
            }
            .comp-row {
                display: flex;
                flex-direction: column;
                background: #080808;
                border: 1px solid rgba(255,0,0,0.15);
                border-radius: 20px;
                padding: 30px 20px;
                gap: 15px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0,0,0,0.8);
            }
            .feature-col {
                justify-content: center;
                font-size: 20px;
                padding-bottom: 20px;
                border-bottom: 1px dashed rgba(255,255,255,0.1);
                margin-bottom: 5px;
            }
            .feature-col i {
                font-size: 24px;
            }
            .legacy-col {
                color: #888;
                font-size: 15px;
                background: rgba(255,255,255,0.02);
                padding: 15px;
                border-radius: 12px;
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
            .legacy-col::before { 
                content: 'TRADITIONAL PLATFORMS'; 
                font-size: 10px; 
                color: #666; 
                font-weight: 800;
                letter-spacing: 1px;
            }
            .elite-col {
                background: linear-gradient(135deg, rgba(255,0,0,0.1) 0%, rgba(139,0,0,0.05) 100%);
                padding: 20px;
                border-radius: 12px;
                border: 1px solid rgba(255,0,0,0.3);
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }
            .elite-col::before { 
                content: '4X ELITE ADVANTAGE'; 
                font-size: 11px; 
                color: var(--primary-red); 
                font-weight: 900;
                letter-spacing: 1px;
            }
            .elite-col .glow-text {
                font-size: 17px;
            }
            .elite-col i {
                font-size: 22px;
                margin-top: 5px;
            }
            .head-row { display: none !important; }
        }
    </style>

    <section class="map-section">
        <div class="container">
            <div class="section-header-elite reveal">
                <h2>GLOBAL <span class="text-danger">PRESENCE</span></h2>
                <div class="red-line"></div>
                <p>Our network spans across 150+ countries, creating a global wealth ecosystem.</p>
            </div>

            <div class="map-container reveal">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg"
                    class="map-svg">
                <!-- Hotspots -->
                <div class="hotspot" style="top: 35%; left: 15%;">
                    <span class="hotspot-label">USA Hub</span>
                </div>
                <div class="hotspot" style="top: 28%; left: 48%;">
                    <span class="hotspot-label">London Hub</span>
                </div>
                <div class="hotspot" style="top: 35%; left: 52%;">
                    <span class="hotspot-label">Europe HQ</span>
                </div>
                <div class="hotspot" style="top: 50%; left: 62%;">
                    <span class="hotspot-label">Dubai Center</span>
                </div>
                <div class="hotspot" style="top: 55%; left: 72%;">
                    <span class="hotspot-label">India Operations</span>
                </div>
                <div class="hotspot" style="top: 45%; left: 85%;">
                    <span class="hotspot-label">Asia Hub</span>
                </div>
                
                <div class="map-overlay-stats d-none d-lg-block">
                    <div class="stat-badge">
                        <span class="pulse-dot"></span>
                        150+ Countries Active
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trader Voices Elite Section -->
    <section class="trader-voices-elite">
        <div class="container">
            <div class="section-header-elite reveal text-center mb-5">
                <span class="badge-elite">SOCIAL PROOF</span>
                <h2 class="massive-title mt-3">TRADER <span class="text-danger">VOICES</span></h2>
                <div class="red-line mx-auto"></div>
            </div>

            <div class="row g-4">
                <!-- Testimonial 1 -->
                <div class="col-lg-4 reveal">
                    <div class="voice-card">
                        <div class="voice-header">
                            <div class="voice-avatar">
                                <img src="https://i.pravatar.cc/150?u=a" alt="user">
                                <div class="verified-badge"><i class="fas fa-check"></i></div>
                            </div>
                            <div class="voice-meta">
                                <h4>Alex Thompson</h4>
                                <span class="voice-status">VIP TRADER • UAE</span>
                            </div>
                        </div>
                        <div class="voice-body">
                            <div class="voice-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>"The execution speed is unlike anything in the retail market. I'm trading institutional liquidity with zero slippage. This is the future."</p>
                        </div>
                        <i class="fas fa-quote-right card-quote"></i>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="col-lg-4 reveal" style="transition-delay: 0.1s">
                    <div class="voice-card featured">
                        <div class="voice-header">
                            <div class="voice-avatar border-danger">
                                <img src="https://i.pravatar.cc/150?u=b" alt="user">
                                <div class="verified-badge bg-danger"><i class="fas fa-check"></i></div>
                            </div>
                            <div class="voice-meta">
                                <h4>Maria Garcia</h4>
                                <span class="voice-status">ELITE INVESTOR • UK</span>
                            </div>
                        </div>
                        <div class="voice-body">
                            <div class="voice-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>"The AI neural engine setup is incredibly accurate. It has completely transformed my risk management and consistent profitability."</p>
                        </div>
                        <i class="fas fa-quote-right card-quote text-danger"></i>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="col-lg-4 reveal" style="transition-delay: 0.2s">
                    <div class="voice-card">
                        <div class="voice-header">
                            <div class="voice-avatar">
                                <img src="https://i.pravatar.cc/150?u=c" alt="user">
                                <div class="verified-badge"><i class="fas fa-check"></i></div>
                            </div>
                            <div class="voice-meta">
                                <h4>David Chen</h4>
                                <span class="voice-status">PRO PARTNER • SG</span>
                            </div>
                        </div>
                        <div class="voice-body">
                            <div class="voice-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p>"A multi-layered ecosystem that actually delivers. Instant payouts and a concierge manager who knows their business. Highly recommended."</p>
                        </div>
                        <i class="fas fa-quote-right card-quote"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .trader-voices-elite {
            padding: 60px 0;
            background: linear-gradient(0deg, var(--black-pure) 0%, rgba(255, 0, 0, 0.03) 100%);
        }

        .voice-card {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 30px;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .voice-card:hover {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 0, 0, 0.2);
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .voice-card.featured {
            border-color: rgba(255, 0, 0, 0.2);
            background: radial-gradient(circle at top right, rgba(255, 0, 0, 0.05) 0%, transparent 70%);
        }

        .voice-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .voice-avatar {
            position: relative;
            width: 65px;
            height: 65px;
        }

        .voice-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .verified-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 20px;
            height: 20px;
            background: #00ff00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: black;
            border: 2px solid var(--black-pure);
        }

        .voice-meta h4 {
            color: white;
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 3px;
        }

        .voice-status {
            color: var(--primary-red);
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .voice-stars {
            color: #ffcc00;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .voice-body p {
            color: var(--text-dim);
            font-size: 15px;
            line-height: 1.7;
            font-style: italic;
        }

        .card-quote {
            position: absolute;
            bottom: 30px;
            right: 30px;
            font-size: 40px;
            opacity: 0.05;
            color: white;
        }

        @media (max-width: 991px) {
            .voice-card { padding: 30px; }
        }
    </style>

    <section class="section-padding bg-black mt-5">
        <div class="container">
            <div class="network-preview-wrapper reveal">
                <div class="network-flex-container">
                    <!-- Tree Side -->
                    <div class="network-visual-side">
                        <div class="tree-preview">
                            <!-- Root Node -->
                            <div class="tree-node root">
                                <div class="tree-node-card">
                                    <div class="tree-card-top">
                                        <div class="tree-avatar-wrapper">
                                            <img src="https://i.pravatar.cc/150?u=root" class="tree-avatar">
                                        </div>
                                        <h6 class="tree-name">Saurabh Sharma</h6>
                                        <span class="tree-username">@saurabh</span>
                                        <span class="tree-level-badge">Level 1</span>
                                    </div>
                                    <div class="tree-card-bottom">
                                        <div class="tree-stat">
                                            <small>TEAM</small>
                                            <span><i class="fas fa-users"></i> 17</span>
                                        </div>
                                        <div class="tree-stat">
                                            <small>INVESTMENT</small>
                                            <span>$2000.00</span>
                                        </div>
                                    </div>
                                    <div class="tree-expand-btn"><i class="fas fa-minus-circle"></i></div>
                                </div>
                            </div>

                            <!-- Branches -->
                            <div class="tree-branches">
                                <div class="tree-horizontal-line"></div>
                                <div class="tree-node child">
                                    <div class="tree-node-card">
                                        <div class="tree-card-top">
                                            <div class="tree-avatar-wrapper">
                                                <img src="https://i.pravatar.cc/150?u=child1" class="tree-avatar">
                                            </div>
                                            <h6 class="tree-name">Devesh Sharma</h6>
                                            <span class="tree-username">@deveshsharma</span>
                                            <span class="tree-level-badge">Level 2</span>
                                        </div>
                                        <div class="tree-card-bottom">
                                            <div class="tree-stat">
                                                <small>TEAM</small>
                                                <span><i class="fas fa-users"></i> 2</span>
                                            </div>
                                            <div class="tree-stat">
                                                <small>INVESTMENT</small>
                                                <span>$100.00</span>
                                            </div>
                                        </div>
                                        <div class="tree-expand-btn"><i class="fas fa-plus-circle"></i></div>
                                    </div>
                                </div>
                                <div class="tree-node child">
                                    <div class="tree-node-card">
                                        <div class="tree-card-top">
                                            <div class="tree-avatar-wrapper">
                                                <img src="https://i.pravatar.cc/150?u=child2" class="tree-avatar">
                                            </div>
                                            <h6 class="tree-name">Manish Sain</h6>
                                            <span class="tree-username">@manishsain</span>
                                            <span class="tree-level-badge">Level 2</span>
                                        </div>
                                        <div class="tree-card-bottom">
                                            <div class="tree-stat">
                                                <small>TEAM</small>
                                                <span><i class="fas fa-users"></i> 1</span>
                                            </div>
                                            <div class="tree-stat">
                                                <small>INVESTMENT</small>
                                                <span>$2000.00</span>
                                            </div>
                                        </div>
                                        <div class="tree-expand-btn"><i class="fas fa-plus-circle"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Side -->
                    <div class="network-content-side">
                        <h3 class="text-white">4X <span class="text-danger">ELITE</span> NETWORK</h3>
                        <p>Manage your ecosystem with industry-leading precision. Our advanced genealogy engine provides real-time tracking of every node and transaction in your network.</p>
                        
                        <ul class="network-feature-list">
                            <li><i class="fas fa-network-wired"></i> Live Genealogy Tree Tracking</li>
                            <li><i class="fas fa-bolt"></i> Real-Time Node Performance</li>
                            <li><i class="fas fa-shield-alt"></i> Automated Tier Auditing</li>
                            <li><i class="fas fa-chart-line"></i> Deep-Tier Growth Analytics</li>
                        </ul>

                        <div class="mt-5">
                            <a href="{{ route('user.register') }}" class="btn-vip">Explore Network</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section reveal">
        <div class="container">
            <div class="cta-wrapper">
                <h2 class="cta-title">
                    TIME TO CHOOSE <br>
                    <span class="text-white">EXCELLENCE</span>
                </h2>
                
                <p class="cta-subtitle">
                    Don't settle for standard market performance. Step into a world of institutional precision and neural-network backed intelligence. Your journey to elite trading starts today.
                </p>

                <div class="cta-features">
                    <div class="cta-feature-item">
                        <i class="fas fa-check-circle"></i> AI Signals
                    </div>
                    <div class="cta-feature-item">
                        <i class="fas fa-check-circle"></i> Instant Payouts
                    </div>
                    <div class="cta-feature-item">
                        <i class="fas fa-check-circle"></i> 24/7 Concierge
                    </div>
                    <div class="cta-feature-item">
                        <i class="fas fa-check-circle"></i> No Spreads
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-4 flex-wrap">
                    <a href="{{ route('user.register') }}" class="btn-vip" style="padding: 22px 60px; font-size: 18px;">
                        Get Started Now
                    </a>
                    <a href="{{ route('user.login') }}" class="btn-glass" style="padding: 22px 60px; font-size: 18px; border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; color: white; text-decoration: none; font-weight: 700; transition: 0.3s;">
                        Account Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Advanced Scroll Reveal
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

    <!-- Real-Time Trading Background Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('liveTradingBg');
            const ctx = canvas.getContext('2d');
            
            let width = window.innerWidth;
            let height = window.innerHeight;
            
            canvas.width = width;
            canvas.height = height;
            
            window.addEventListener('resize', () => {
                width = window.innerWidth;
                height = window.innerHeight;
                canvas.width = width;
                canvas.height = height;
                initLineChart(); // Re-init line chart points to cover new width
            });

            // Candlesticks
            let candles = [];
            for(let i = 0; i < 40; i++) {
                candles.push(createCandle(Math.random() * width));
            }

            function createCandle(xPos) {
                return {
                    x: xPos,
                    y: Math.random() * height * 0.7 + height * 0.15,
                    bodyHeight: Math.random() * 30 + 10,
                    wickHeight: Math.random() * 60 + 20,
                    speed: Math.random() * 0.4 + 0.1,
                    isGreen: Math.random() > 0.5,
                    opacity: Math.random() * 0.5 + 0.3 /* Increased opacity */
                };
            }

            // Floating Numbers (Tickers)
            let numbers = [];
            for(let i=0; i<25; i++) {
                numbers.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    val: (Math.random() * 5000 + 1000).toFixed(2),
                    speedY: (Math.random() - 0.5) * 0.3,
                    opacity: Math.random() * 0.4 + 0.2 /* Increased opacity */
                });
            }

            // Line Chart Pulse
            let linePoints = [];
            function initLineChart() {
                linePoints = [];
                let currentY = height * 0.6;
                let segments = 120;
                let stepX = width / segments;
                for(let i=0; i<=segments; i++) {
                    linePoints.push({x: i * stepX, y: currentY, basePoint: currentY});
                    currentY += (Math.random() - 0.5) * 40;
                    if(currentY > height * 0.9) currentY -= 30;
                    if(currentY < height * 0.3) currentY += 30;
                }
            }
            initLineChart();

            let time = 0;

            function draw() {
                ctx.clearRect(0, 0, width, height);
                time++;

                // 1. Draw Institutional Grid
                ctx.strokeStyle = 'rgba(255, 0, 0, 0.08)'; /* More visible grid */
                ctx.lineWidth = 1;
                ctx.beginPath();
                for(let i = 0; i < width; i += 60) {
                    ctx.moveTo(i, 0); ctx.lineTo(i, height);
                }
                for(let i = 0; i < height; i += 60) {
                    ctx.moveTo(0, i); ctx.lineTo(width, i);
                }
                ctx.stroke();

                // 2. Draw Moving Line Chart
                ctx.beginPath();
                ctx.moveTo(0, linePoints[0].y);
                for(let i=1; i<linePoints.length; i++) {
                    // Make it wave like live data
                    let waveY = linePoints[i].basePoint + Math.sin(time*0.015 + i*0.2) * 15;
                    ctx.lineTo(linePoints[i].x, waveY);
                }
                ctx.strokeStyle = 'rgba(255, 0, 0, 0.6)'; /* Stronger line */
                ctx.lineWidth = 2.5; /* Thicker line */
                ctx.stroke();
                
                // Add Gradient under line
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                let grad = ctx.createLinearGradient(0, height * 0.4, 0, height);
                grad.addColorStop(0, 'rgba(255, 0, 0, 0.2)'); /* Stronger gradient */
                grad.addColorStop(1, 'rgba(0, 0, 0, 0)');
                ctx.fillStyle = grad;
                ctx.fill();

                // 3. Draw Candlesticks (Scrolling Right to Left)
                candles.forEach((c, index) => {
                    c.x -= c.speed;
                    if(c.x < -20) {
                        candles[index] = createCandle(width + 20); // Reset at right
                    }
                    
                    ctx.fillStyle = c.isGreen ? `rgba(0, 255, 100, ${c.opacity})` : `rgba(255, 0, 50, ${c.opacity})`;
                    
                    // Draw Wick
                    ctx.fillRect(c.x + 3, c.y - c.wickHeight/2, 1, c.wickHeight);
                    // Draw Body
                    ctx.fillRect(c.x, c.y - c.bodyHeight/2, 7, c.bodyHeight);
                });

                // 4. Draw Floating Ticker Numbers
                ctx.font = '12px "Courier New", monospace';
                numbers.forEach(n => {
                    n.y += n.speedY;
                    if(n.y < 0) n.y = height;
                    if(n.y > height) n.y = 0;
                    
                    // Simulate live price updates
                    if(Math.random() < 0.03) {
                        let change = (Math.random() - 0.5) * 10;
                        n.val = (parseFloat(n.val) + change).toFixed(2);
                    }

                    ctx.fillStyle = `rgba(255, 255, 255, ${n.opacity})`;
                    ctx.fillText(n.val, n.x, n.y);
                });

                requestAnimationFrame(draw);
            }
            
            draw();
        });
    </script>

@endsection