@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $content = getContent('contact_us.content', true);
    @endphp

    <style>
        /* Elite Full-Screen Support Portal */
        :root {
            --primary-red: #ff0000;
            --deep-red: #8b0000;
            --black-pure: #000000;
            --glass-bg: rgba(255, 255, 255, 0.02);
            --border-glow: rgba(255, 0, 0, 0.2);
        }

        body {
            background-color: var(--black-pure);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
        }

        #liveTradingBg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.20;
        }

        .elite-support-wrapper {
            min-height: 100vh;
            display: flex;
            background: radial-gradient(circle at bottom right, rgba(255, 0, 0, 0.08) 0%, var(--black-pure) 60%);
            position: relative;
        }

        /* Left Side - Info Hub */
        .info-hub {
            flex: 1;
            padding: 8px 8% 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        .massive-badge {
            display: inline-block;
            background: rgba(255, 0, 0, 0.1);
            color: var(--primary-red);
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 900;
            letter-spacing: 3px;
            font-size: 12px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .elite-title {
            font-size: clamp(40px, 6vw, 90px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -3px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .elite-lead {
            font-size: 18px;
            color: #999;
            max-width: 500px;
            line-height: 1.6;
            margin-bottom: 60px;
        }

        .contact-pill-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 45px;
        }

        .contact-pill {
            display: flex;
            align-items: center;
            gap: 25px;
            text-decoration: none !important;
            transition: all 0.3s ease;
        }

        .pill-icon {
            width: 65px;
            height: 65px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #ffffff !important;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }

        .contact-pill:hover .pill-icon {
            border-color: var(--primary-red);
            color: var(--primary-red);
            box-shadow: 0 0 30px rgba(255, 0, 0, 0.3);
            transform: scale(1.1) rotate(-5deg);
        }

        .pill-content h5 {
            color: #bbb;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 2px;
        }

        .pill-content p {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 0;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        /* Right Side - Fortress Form */
        .form-hub {
            flex: 1;
            background: rgba(255, 255, 255, 0.01);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 8%;
            position: relative;
        }

        .form-fortress {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 29px;
            border-radius: 60px;
            position: relative;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.6);
            animation: fortressPulse 8s ease-in-out infinite;
        }

        @keyframes fortressPulse {
            0%, 100% { box-shadow: 0 50px 100px rgba(0, 0, 0, 0.6); border-color: rgba(255, 255, 255, 0.05); }
            50% { box-shadow: 0 50px 120px rgba(255, 0, 0, 0.1); border-color: rgba(255, 0, 0, 0.15); }
        }

        .form-fortress::before {
            position: absolute;
            top: 0; left: 0; width: 80px; height: 80px;
            border-top: 3px solid var(--primary-red);
            border-left: 3px solid var(--primary-red);
            border-radius: 60px 0 0 0;
            filter: drop-shadow(0 0 10px var(--primary-red));
        }

        .elite-input-group {
            margin-bottom: 35px;
        }

        .elite-input-group label {
            display: block;
            color: #eee;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .elite-input-group input, 
        .elite-input-group textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 20px 25px;
            color: white;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .elite-input-group input:focus, 
        .elite-input-group textarea:focus {
            border-color: var(--primary-red);
            background: rgba(255, 0, 0, 0.06);
            box-shadow: 0 0 40px rgba(255, 0, 0, 0.15);
            transform: scale(1.01);
        }

        .btn-elite-transmit {
            background: linear-gradient(135deg, var(--deep-red) 0%, var(--primary-red) 100%);
            color: white !important;
            width: 100%;
            padding: 25px;
            border: none;
            border-radius: 20px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 20px 40px rgba(255, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .btn-elite-transmit:hover {
            transform: translateY(-8px);
            box-shadow: 0 35px 70px rgba(255, 0, 0, 0.6);
            filter: brightness(1.2);
        }

        /* Decorative Elements */
        .orbital-visual {
            position: absolute;
            top: 50%;
            left: 0;
            width: 800px;
            height: 800px;
            border: 1px solid rgba(255, 255, 255, 0.02);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 1;
        }

        .alert-elite {
            background: rgba(0, 255, 0, 0.05);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #00ff00;
            padding: 25px;
            border-radius: 25px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
        }

        .tech-particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--primary-red);
            border-radius: 50%;
            top: -10px;
            animation: particleFall 15s linear infinite;
            opacity: 0.3;
            z-index: 1;
            pointer-events: none;
        }

        @keyframes particleFall {
            0% { transform: translateY(-10px) translateX(0); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(100vh) translateX(20px); opacity: 0; }
        }

        @media (max-width: 1199px) {
            .elite-support-wrapper { flex-direction: column; height: auto; }
            .info-hub { padding: 120px 5% 50px; text-align: center; align-items: center; min-height: auto; }
            .form-hub { border-left: none; border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 50px 5% 100px; }
            .contact-pill { justify-content: flex-start; text-align: left; width: 100%; max-width: 450px; margin: 0 auto; }
            .form-fortress { padding: 40px 25px; border-radius: 40px; }
            .elite-title { font-size: 55px; margin-top: 20px; }
            .elite-lead { margin-bottom: 40px; font-size: 16px; margin-left: auto; margin-right: auto; }
            .orbital-visual { display: none; }
        }

        @media (max-width: 767px) {
            .info-hub { padding-top: 80px; padding-bottom: 40px; }
            .elite-title { font-size: 40px; letter-spacing: -1px; }
            .elite-lead { font-size: 15px; line-height: 1.5; margin-bottom: 40px; }
            
            .contact-pill-grid { gap: 20px; }
            
            .contact-pill { 
                gap: 15px; 
                align-items: center; 
                background: rgba(255, 255, 255, 0.03);
                padding: 18px;
                border-radius: 25px;
                border: 1px solid rgba(255, 255, 255, 0.06);
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }
            
            .pill-icon { 
                width: 50px; 
                height: 50px; 
                font-size: 18px; 
                color: #ffffff !important; 
                background: rgba(255,255,255,0.08); 
                flex-shrink: 0; 
                border-radius: 15px;
            }
            
            .pill-content h5 { font-size: 12px; margin-bottom: 8px; color: #888; }
            .pill-content p { font-size: 16px; word-break: break-word; }
            
            .form-hub { padding: 40px 5% 80px; }
            .form-fortress { padding: 30px 20px; border-radius: 35px; }
            .form-fortress::before { width: 60px; height: 60px; border-radius: 35px 0 0 0; }
            
            .massive-badge { font-size: 9px; padding: 6px 15px; margin-bottom: 15px; letter-spacing: 2px; }
            
            .elite-input-group { margin-bottom: 25px; }
            .elite-input-group label { font-size: 10px; margin-bottom: 8px; }
            .elite-input-group input, .elite-input-group textarea { padding: 15px 20px; font-size: 15px; }
            
            .btn-elite-transmit { padding: 20px; font-size: 14px; letter-spacing: 2px; }
        }
    </style>

    <div class="elite-support-wrapper">
        <canvas id="liveTradingBg"></canvas>
        <div class="orbital-visual"></div>
        
        <!-- Tech Particles -->
        <div class="tech-particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="tech-particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="tech-particle" style="left: 50%; animation-delay: 4s;"></div>
        <div class="tech-particle" style="left: 70%; animation-delay: 1s;"></div>
        <div class="tech-particle" style="left: 90%; animation-delay: 3s;"></div>
        
        <!-- Left Section - Institutional Info -->
        <div class="info-hub">
            <span class="massive-badge">Elite Support Infrastructure</span>
            <h1 class="elite-title">GET IN <br> <span class="text-danger">TOUCH</span></h1>
            <p class="elite-lead">Access the world's most responsive institutional support network. Our concierge account managers are standing by to execute your global requirements 24/7.</p>
            
            <div class="contact-pill-grid">
                <a href="tel:{{ @$content->data_values->contact_number }}" class="contact-pill">
                    <div class="pill-icon"><i class="fas fa-phone"></i></div>
                    <div class="pill-content">
                        <h5>Institutional Direct Line</h5>
                        <p>{{ __(@$content->data_values->contact_number) }}</p>
                    </div>
                </a>

                <a href="mailto:{{ __(@$content->data_values->email_address) }}" class="contact-pill">
                    <div class="pill-icon"><i class="fas fa-envelope"></i></div>
                    <div class="pill-content">
                        <h5>Encrypted Support Channel</h5>
                        <p>{{ __(@$content->data_values->email_address) }}</p>
                    </div>
                </a>

                <div class="contact-pill">
                    <div class="pill-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="pill-content">
                        <h5>Global Command Center</h5>
                        <p>{{ __(@$content->data_values->contact_address) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section - The Fortress Module -->
        <div class="form-hub">
            <div class="form-fortress">
                <form id="contact-form-elite" action="{{ route('contact') }}" method="POST">
                    @csrf
                    <div class="elite-input-group">
                        <label>IDENTITY CLEARANCE (Name)</label>
                        <input type="text" placeholder="Your institutional name" 
                               value="@if (auth()->user()){{ auth()->user()->fullname }}@else{{ old('name') }}@endif"
                               @if (auth()->user()) readonly @endif required name="name">
                    </div>

                    <div class="elite-input-group">
                        <label>SECURE RESPONSE CHANNEL (Email)</label>
                        <input type="email" placeholder="Verification email address" 
                               value="@if (auth()->user()) {{ auth()->user()->email }} @else {{ old('email') }} @endif"
                               @if (auth()->user()) readonly @endif required name="email">
                    </div>

                    <div class="elite-input-group">
                        <label>INQUIRY CLASSIFICATION (Subject)</label>
                        <input type="text" placeholder="Nature of your priority request" 
                               value="{{ old('subject') }}" required name="subject">
                    </div>

                    <div class="elite-input-group">
                        <label>DETAILED BRIEFING (Message)</label>
                        <textarea name="message" rows="5" placeholder="Detailed requirements for our elite support team..." required>{{ old('message') }}</textarea>
                    </div>

                    <div class="mb-5">
                        <x-captcha />
                    </div>

                    <button type="submit" class="btn-elite-transmit" id="submit-btn">
                        <span class="btn-text">SUBMIT MESSAGE</span>
                        <span class="btn-loader d-none"><i class="fas fa-circle-notch fa-spin"></i> SUBMITTING...</span>
                    </button>
                    
                    <div class="d-none" id="status-container">
                        <div class="alert-elite" id="status-message"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        (function($){
            "use strict";
            $(document).on('submit', '#contact-form-elite', function(e){
                e.preventDefault();
                e.stopPropagation();
                
                let form = $(this);
                let btn = $('#submit-btn');
                let btnText = btn.find('.btn-text');
                let btnLoader = btn.find('.btn-loader');
                let statusContainer = $('#status-container');
                let statusMessage = $('#status-message');

                statusContainer.addClass('d-none');
                btn.prop('disabled', true);
                btnText.addClass('d-none');
                btnLoader.removeClass('d-none');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        statusContainer.removeClass('d-none');
                        if(response.success) {
                            statusMessage.html('<i class="fas fa-check-circle"></i> ' + response.message);
                            form[0].reset();
                            
                            $('html, body').animate({
                                scrollTop: statusContainer.offset().top - 300
                            }, 500);
                        } else {
                            statusMessage.css('color', '#ff0000').css('border-color', '#ff0000').html('<i class="fas fa-exclamation-triangle"></i> ERROR: ' + (response.error || 'Protocol Mismatch.'));
                        }
                        btn.prop('disabled', false);
                        btnText.removeClass('d-none');
                        btnLoader.addClass('d-none');
                    },
                    error: function() {
                        statusContainer.removeClass('d-none');
                        statusMessage.css('color', '#ff0000').css('border-color', '#ff0000').html('<i class="fas fa-exclamation-triangle"></i> TRANSMISSION TIMEOUT: SECURE CHANNEL FAILED.');
                        btn.prop('disabled', false);
                        btnText.removeClass('d-none');
                        btnLoader.addClass('d-none');
                    }
                });
                return false;
            });
    </script>

    <!-- Real-Time Trading Background Animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('liveTradingBg');
            const ctx = canvas.getContext('2d');
            
            let width = canvas.parentElement.offsetWidth;
            let height = canvas.parentElement.offsetHeight;
            
            canvas.width = width;
            canvas.height = height;
            
            window.addEventListener('resize', () => {
                width = canvas.parentElement.offsetWidth;
                height = canvas.parentElement.offsetHeight;
                canvas.width = width;
                canvas.height = height;
                initLineChart();
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
                    opacity: Math.random() * 0.5 + 0.3
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
                    opacity: Math.random() * 0.4 + 0.2
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

                ctx.strokeStyle = 'rgba(255, 0, 0, 0.08)';
                ctx.lineWidth = 1;
                ctx.beginPath();
                for(let i = 0; i < width; i += 60) {
                    ctx.moveTo(i, 0); ctx.lineTo(i, height);
                }
                for(let i = 0; i < height; i += 60) {
                    ctx.moveTo(0, i); ctx.lineTo(width, i);
                }
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(0, linePoints[0].y);
                for(let i=1; i<linePoints.length; i++) {
                    let waveY = linePoints[i].basePoint + Math.sin(time*0.015 + i*0.2) * 15;
                    ctx.lineTo(linePoints[i].x, waveY);
                }
                ctx.strokeStyle = 'rgba(255, 0, 0, 0.6)';
                ctx.lineWidth = 2.5;
                ctx.stroke();
                
                ctx.lineTo(width, height);
                ctx.lineTo(0, height);
                let grad = ctx.createLinearGradient(0, height * 0.4, 0, height);
                grad.addColorStop(0, 'rgba(255, 0, 0, 0.2)');
                grad.addColorStop(1, 'rgba(0, 0, 0, 0)');
                ctx.fillStyle = grad;
                ctx.fill();

                candles.forEach((c, index) => {
                    c.x -= c.speed;
                    if(c.x < -20) {
                        candles[index] = createCandle(width + 20);
                    }
                    
                    ctx.fillStyle = c.isGreen ? `rgba(0, 255, 100, ${c.opacity})` : `rgba(255, 0, 50, ${c.opacity})`;
                    
                    ctx.fillRect(c.x + 3, c.y - c.wickHeight/2, 1, c.wickHeight);
                    ctx.fillRect(c.x, c.y - c.bodyHeight/2, 7, c.bodyHeight);
                });

                ctx.font = '12px "Courier New", monospace';
                numbers.forEach(n => {
                    n.y += n.speedY;
                    if(n.y < 0) n.y = height;
                    if(n.y > height) n.y = 0;
                    
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
    @endpush

    <style>
        footer { display: none !important; }
    </style>
@endsection