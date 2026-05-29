@extends($activeTemplate . 'layouts.master')

@push('style')
    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --card-black: #111111;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --text-white: #ffffff;
            --text-muted: #999999;
            --border-red: rgba(255, 0, 0, 0.2);
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }

        .invest-container {
            margin-left: 280px;
            padding: 15px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            padding-bottom: 50px;
        }

        @media (max-width: 1024px) {
            .invest-container {
                margin-left: 0;
                padding: 10px;
                padding-top: 70px;
            }

            .invest-wrapper {
                max-width: 100%;
            }
        }

        footer {
            display: none !important;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }

        #myVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.2) sepia(0.5) hue-rotate(-10deg);
            opacity: 0.4;
        }

        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            z-index: -2;
        }

        /* Progress Bar */
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
            margin-top: 20px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
            min-width: 0;
        }

        .step::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 57%;
            right: -43%;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
        }

        .step:last-child::before {
            display: none;
        }

        .step.active::before,
        .step.completed::before {
            background: var(--gradient-red);
        }

        .step.active .step-number,
        .step.completed .step-number {
            background: var(--gradient-red);
            border-color: var(--light-red);
            color: white;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
        }

        .step.active .step-number {
            animation: pulse 2s infinite;
        }

        .step.completed .step-number::after {
            content: '✓';
            font-size: 16px;
            margin-left: 2px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 10px;
            transition: var(--transition);
            position: relative;
        }

        .step-label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .step.active .step-label,
        .step.completed .step-label {
            color: var(--text-white);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(255, 0, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
            }
        }

        /* Instruction Banner */
        .instruction-banner {
            background: linear-gradient(90deg, rgba(255, 0, 0, 0.1) 0%, rgba(255, 0, 0, 0.02) 100%);
            border: 1px solid rgba(255, 0, 0, 0.2);
            border-left: 4px solid var(--accent-red);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            animation: fadeInDown 0.8s ease-out;
        }

        .instruction-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 0, 0, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-red);
            font-size: 24px;
            flex-shrink: 0;
        }

        .instruction-content h5 {
            color: #fff;
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 700;
        }

        .instruction-content p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Modal Styling */
        .modal-content {
            background: #0f0f0f !important;
            border: 1px solid rgba(255, 0, 0, 0.2) !important;
            border-radius: 24px !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.9), 0 0 20px rgba(255, 0, 0, 0.1) !important;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 25px 30px !important;
            background: rgba(255, 0, 0, 0.02);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 20px 30px !important;
            background: rgba(0, 0, 0, 0.2);
        }

        .modal-title {
            color: #fff !important;
            font-weight: 800 !important;
            letter-spacing: 0.5px;
        }

        /* Custom Modal Table */
        .modal-detail-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 10px;
        }

        .modal-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .modal-detail-row:last-child {
            border-bottom: none;
        }

        .modal-detail-label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .modal-detail-value {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
        }

        .modal-detail-total {
            background: rgba(255, 0, 0, 0.05);
            border-radius: 10px;
            margin-top: 5px;
        }

        .modal-detail-total .modal-detail-value {
            color: var(--light-red);
            font-size: 18px;
        }

        .lock-glow {
            color: var(--accent-red);
            font-size: 55px;
            margin-bottom: 15px;
            text-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
            animation: iconPulse 2s infinite;
        }

        @keyframes iconPulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Layout Cards */
        .invest-wrapper {
            max-width: 1600px;
            margin: 0;
        }

        .invest-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 15px;
        }

        @media (max-width: 991px) {
            .invest-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .main-form-card {
                padding: 0;
            }

            .invest-form {
                padding: 11px;
            }

            .card-header {
                padding: 15px;
            }

            .progress-steps {
                margin-bottom: 25px;
            }

            .step-label {
                font-size: 11px;
            }

            .step-number {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }

            .step::before {
                top: 15px;
            }

            .amount-input {
                font-size: 18px !important;
                padding: 12px 12px 12px 40px !important;
            }

            .currency-symbol {
                top: 12px;
                font-size: 18px;
            }

            .detail-row {
                padding: 10px 0;
                align-items: flex-start;
            }

            .detail-info p {
                font-size: 10px !important;
                line-height: 1.3;
                max-width: 80%;
            }

            .detail-info span {
                font-size: 13px;
            }

            .detail-amount,
            .detail-total {
                font-size: 14px;
                white-space: nowrap;
            }
        }

        .main-form-card {
            background: rgba(17, 17, 17, 0.9);
            border: 1px solid var(--border-red);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-red);
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            color: white;
            margin: 0;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header h3 i {
            color: var(--accent-red);
        }

        .balance-info {
            color: var(--text-muted);
            font-size: 14px;
        }

        .balance-info strong {
            color: var(--light-red);
            margin-left: 5px;
            font-size: 16px;
        }

        .invest-form {
            padding: 11px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            color: var(--text-white);
            font-size: 15px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .form-label i {
            color: var(--accent-red);
        }

        /* Amount Input & Presets */
        .amount-input-group {
            position: relative;
        }

        .currency-symbol {
            position: absolute;
            left: 17px;
            top: 15px;
            color: var(--light-red);
            font-weight: 700;
            font-size: 22px;
            z-index: 1;
        }

        .amount-input {
            width: 100%;
            padding: 15px 15px 15px 45px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-red) !important;
            border-radius: 12px !important;
            color: var(--text-white) !important;
            font-size: 20px !important;
            font-weight: 700 !important;
            transition: var(--transition);
        }

        .amount-input:focus {
            border-color: var(--light-red) !important;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.2) !important;
            outline: none;
        }

        .amount-presets {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .preset-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .preset-btn:hover {
            border-color: var(--accent-red);
            color: white;
            background: rgba(255, 0, 0, 0.1);
        }

        /* Payment Preview */
        .payment-preview {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            border: 1px solid var(--border-red);
            overflow: hidden;
            margin: 25px 0;
        }

        .preview-header {
            padding: 12px 20px;
            background: rgba(255, 0, 0, 0.1);
            border-bottom: 1px solid var(--border-red);
        }

        .preview-header h4 {
            color: white;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }

        .preview-details {
            padding: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }

        .detail-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .detail-info span {
            color: #fff;
            font-weight: 600;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row span:first-child {
            color: var(--text-muted);
        }

        .detail-row.total {
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid var(--border-red);
        }

        .detail-amount {
            color: var(--text-white);
            font-weight: 600;
            font-size: 16px;
        }

        .detail-total {
            color: var(--light-red);
            font-size: 20px;
            font-weight: 700;
        }

        .submit-btn-modern {
            width: 100%;
            background: var(--gradient-red);
            border: none;
            padding: 18px;
            border-radius: 12px;
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: var(--transition);
            box-shadow: 0 10px 20px rgba(136, 0, 0, 0.3);
        }

        .submit-btn-modern:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(136, 0, 0, 0.5);
            filter: brightness(1.1);
        }

        .submit-btn-modern:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(1);
        }

        /* Sidebar Info */
        .info-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-card {
            background: rgba(17, 17, 17, 0.9);
            border: 1px solid var(--border-red);
            border-radius: 20px;
            padding: 25px;
        }

        .info-card h4 {
            color: #fff;
            font-size: 17px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 51, 51, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-red);
            flex-shrink: 0;
        }

        .info-text h5 {
            color: #fff;
            font-size: 14px;
            margin: 0 0 5px 0;
        }

        .info-text p {
            color: var(--text-muted);
            font-size: 12px;
            margin: 0;
            line-height: 1.5;
        }

        /* Summary Boxes */
        .summary-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-red);
            border-radius: 15px;
            padding: 18px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .summary-box::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient-red);
            opacity: 0.7;
        }

        .summary-box:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: var(--accent-red);
            transform: translateX(5px);
        }

        .summary-label {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .summary-value {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-value i {
            font-size: 16px;
            opacity: 0.6;
        }

        /* Success View Styles */
        .success-icon-container {
            position: relative;
            display: inline-block;
            margin-bottom: 25px;
        }

        .success-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            background: rgba(46, 204, 113, 0.2);
            border-radius: 50%;
            filter: blur(20px);
            animation: successPulse 2s infinite;
        }

        @keyframes successPulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.5;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.5;
            }
        }

        .bg-dark-2 {
            background: rgba(0, 0, 0, 0.4);
        }

        /* New Success Details Card */
        .success-details-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            margin: 0 20px;
            overflow: hidden;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .detail-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .detail-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .detail-item:hover .detail-icon {
            background: rgba(255, 0, 0, 0.1);
            color: var(--accent-red);
        }

        .detail-item span {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .detail-value {
            color: #fff;
            font-weight: 700;
            font-size: 15px;
        }

        #investAgainBtn:hover {
            color: var(--light-red) !important;
            background: rgba(255, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="invest-container">
        <div class="video-background">
            <video autoplay muted loop id="myVideo">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4"
                    type="video/mp4">
            </video>
        </div>
        <div class="video-overlay"></div>

        <div class="invest-wrapper">
            <!-- Instruction Banner -->
            <div class="instruction-banner">
                <div class="instruction-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="instruction-content">
                    <h5>Important Investment Notice</h5>
                    <p>Your new investment will be added to your current active principal. Daily returns on the total
                        updated amount will be calculated and credited to your wallet starting from the next business day.
                    </p>
                </div>
            </div>

            <div class="invest-grid">
                <div class="main-content-col">
                    <!-- STEP 1: Amount Entry -->
                    <div id="step-1-content" class="main-form-card">
                        <div class="card-header">
                            <h3><i class="fas fa-rocket"></i> Investment Details</h3>
                            <div class="balance-info">
                                <span>Available:</span>
                                <strong>{{ $general->cur_sym }}{{ showAmount(auth()->user()->balance) }}</strong>
                            </div>
                        </div>

                        <form id="investForm" action="{{ route('user.plan.order', $plan->id) }}" method="POST"
                            class="invest-form">
                            @csrf
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-coins"></i> Investment Amount</label>
                                <div class="amount-input-group">
                                    <span class="currency-symbol">{{ $general->cur_sym }}</span>
                                    <input type="number" step="any" name="amount" id="amountInput"
                                        class="form-control amount-input" placeholder="0.00" min="10" max="1000000" required
                                        onkeypress="return (event.charCode != 45 && event.charCode != 43)">
                                    <span id="balanceError"
                                        class="text-danger small mt-2 d-none animate__animated animate__headShake"
                                        style="font-size: 12px; display: block;">
                                        <i class="fas fa-exclamation-triangle"></i> Insufficient Balance! Max:
                                        {{ $general->cur_sym }}{{ showAmount(auth()->user()->balance) }}
                                    </span>
                                    <div class="amount-presets">
                                        <button type="button" class="preset-btn" data-amount="10">$10</button>
                                        <button type="button" class="preset-btn" data-amount="20">$20</button>
                                        <button type="button" class="preset-btn" data-amount="50">$50</button>
                                        <button type="button" class="preset-btn" data-amount="100">$100</button>
                                        <button type="button" class="preset-btn" data-amount="200">$200</button>
                                        <button type="button" class="preset-btn" data-amount="500">$500</button>
                                        <button type="button" class="preset-btn" data-amount="1000">$1000</button>
                                        <button type="button" class="preset-btn" data-amount="2000">$2000</button>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-preview">
                                <div class="preview-header">
                                    <h4><i class="fas fa-chart-pie"></i> ROI & Commission Details</h4>
                                </div>
                                <div class="preview-details">
                                    <div class="detail-row">
                                        <div class="detail-info">
                                            <span>Direct Income Bonus</span>
                                            <p class="mb-0 small text-muted">Instant reward for every direct member you
                                                invite to the platform.</p>
                                        </div>
                                        <span class="detail-amount">{{ getAmount($plan->referral_percentage) }}%</span>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-info">
                                            <span>Network Commission</span>
                                            <p class="mb-0 small text-muted">Passive earnings from your downline across
                                                multiple levels.</p>
                                        </div>
                                        <span class="detail-amount">{{ $plan->totalLevel($plan->id)->count() }}
                                            Levels</span>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-info">
                                            <span>Daily Returns (ROI)</span>
                                            <p class="mb-0 small text-muted">Dynamic daily profits based on current market
                                                performance.</p>
                                        </div>
                                        <span class="text--success font-weight-bold">Dynamic %</span>
                                    </div>
                                    <div class="detail-row total">
                                        <div class="detail-info">
                                            <span class="text-white">Total Investment Amount</span>
                                            <p class="mb-0 small text-muted">Final amount to be deducted from your wallet.
                                            </p>
                                        </div>
                                        <span class="detail-total">{{ $general->cur_sym }}<span
                                                id="displayAmount">0.00</span></span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="submit-btn-modern" id="nextBtn">
                                <span>Next Step</span> <i class="fas fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    <!-- SUCCESS VIEW (Hidden by default) -->
                    <div id="success-content" class="main-form-card d-none animate__animated animate__zoomIn">
                        <div class="invest-form text-center py-5">
                            <div class="success-icon-container mb-4">
                                <div class="success-glow"></div>
                                <i class="fas fa-check-circle"
                                    style="font-size: 80px; color: #2ecc71; position: relative; z-index: 1;"></i>
                            </div>

                            <h2 class="text-white mb-3 fw-bold">Investment Successful!</h2>
                            <p class="text-muted mb-4 px-4">Great choice! Your investment has been activated. Your portfolio
                                is now working for you.</p>

                            <div class="success-details-card mb-4 mt-2">
                                <div class="detail-item">
                                    <div class="detail-left">
                                        <div class="detail-icon"><i class="fas fa-fingerprint"></i></div>
                                        <span>Transaction ID</span>
                                    </div>
                                    <span class="detail-value text-white" id="successTrx">---</span>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-left">
                                        <div class="detail-icon text-success"><i class="fas fa-coins"></i></div>
                                        <span>Amount Invested</span>
                                    </div>
                                    <span class="detail-value text-success" id="successAmount">0.00</span>
                                </div>
                                <div class="detail-item border-0">
                                    <div class="detail-left">
                                        <div class="detail-icon text-info"><i class="fas fa-check-circle"></i></div>
                                        <span>Investment Status</span>
                                    </div>
                                    <span class="detail-value">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> Active
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-3 px-3">
                                <a href="{{ route('user.home') }}" class="submit-btn-modern">
                                    <span>Go to Dashboard</span> <i class="fas fa-home"></i>
                                </a>
                                <button type="button" class="btn text-muted fw-bold" id="investAgainBtn">
                                    <i class="fas fa-redo-alt me-2"></i> Invest More
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-sidebar-col">
                    <div class="info-sidebar">
                        <div class="info-card mb-4 animate__animated animate__fadeInRight">
                            <h4 class="mb-4"><i class="fas fa-wallet text-danger"></i> My Investment Summary</h4>

                            <div class="summary-box">
                                <span class="summary-label">Current Balance</span>
                                <h3 class="summary-value" style="color: #00d2ff;">
                                    <i class="fas fa-wallet"></i>
                                    <span
                                        id="summaryBalance">{{ $general->cur_sym }}{{ showAmount(auth()->user()->balance) }}</span>
                                </h3>
                            </div>

                            <div class="summary-box mt-3">
                                <span class="summary-label">Total Investment</span>
                                <h3 class="summary-value">
                                    <i class="fas fa-piggy-bank"></i>
                                    <span
                                        id="summaryTotalInvest">{{ $general->cur_sym }}{{ showAmount($totalInvest) }}</span>
                                </h3>
                            </div>

                            <div class="summary-box mt-3">
                                <span class="summary-label">Total Received</span>
                                <h3 class="summary-value text-success">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <span
                                        id="summaryTotalReceived">{{ $general->cur_sym }}{{ showAmount($totalReceived) }}</span>
                                </h3>
                            </div>

                            <div class="summary-box mt-3">
                                <span class="summary-label">Remaining to Receive</span>
                                <h3 class="summary-value text-warning">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span id="summaryRemaining">{{ $general->cur_sym }}{{ showAmount($remaining) }}</span>
                                </h3>
                            </div>

                            <div class="summary-box mt-3">
                                <span class="summary-label">Total Potential Earnings</span>
                                <h3 class="summary-value text-info">
                                    <i class="fas fa-chart-line"></i>
                                    <span
                                        id="summaryPotential">{{ $general->cur_sym }}{{ showAmount($totalPotential) }}</span>
                                </h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- CONFIRMATION MODAL -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shield-check text-danger"></i> Final Confirmation</h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="lock-glow">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="text-white mb-2">Secure Investment</h3>
                        <p class="text-muted">You are about to subscribe to <strong>{{ $plan->name }}</strong></p>
                    </div>

                    <div class="modal-detail-card">
                        <div class="modal-detail-row">
                            <span class="modal-detail-label">Plan Category</span>
                            <span class="modal-detail-value">Growth Multiplier</span>
                        </div>
                        <div class="modal-detail-row">
                            <span class="modal-detail-label">Investment Amount</span>
                            <span class="modal-detail-value">{{ $general->cur_sym }}<span
                                    class="confirmAmount">0.00</span></span>
                        </div>
                        <div class="modal-detail-row modal-detail-total">
                            <span class="modal-detail-label text-white">Remaining Balance</span>
                            <span class="modal-detail-value"><span class="confirmPostBalance">0.00</span></span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded" id="confirmDisclaimer" style="background: rgba(255, 193, 7, 0.05); border: 1px border(255, 193, 7, 0.2);">
                        <p class="mb-0 small text-warning"><i class="fas fa-exclamation-triangle mr-2"></i> Funds will be
                            deducted instantly from your available wallet balance.</p>
                    </div>

                    <!-- OTP SECTION (Hidden by default, only shown when OTP required) -->
                    @if($plan->require_otp)
                    <div id="otpSection" class="d-none mt-4 animate__animated animate__fadeIn">
                        <div class="form-group text-start">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><i class="fas fa-key text-danger"></i> Enter Verification Code</label>
                                <div id="otpStatus" class="d-none">
                                    <span class="badge bg-success animate__animated animate__bounceIn" style="padding: 5px 12px; font-size: 12px;"><i class="fas fa-check-circle mr-1"></i> Verified</span>
                                </div>
                            </div>
                            <div class="position-relative">
                                <input type="text" name="otp" id="otpInput" class="form-control" placeholder="******" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white; font-size: 24px; text-align: center; letter-spacing: 8px; height: 60px; font-weight: bold; transition: all 0.3s ease;">
                                <div id="otpLoading" class="d-none position-absolute" style="right: 20px; top: 50%; transform: translateY(-50%);">
                                    <i class="fas fa-spinner fa-spin text-muted"></i>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 small text-muted text-center" id="otpInstruction">
                                <i class="fas fa-envelope-open-text me-1"></i> A 6-digit OTP has been sent to your email.
                            </p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <div class="d-flex w-100 gap-3">
                        <button type="button" class="submit-btn-modern flex-fill" data-bs-dismiss="modal" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); text-transform: none; padding: 15px;">
                            <span>Cancel</span>
                        </button>
                        <button type="button" class="submit-btn-modern flex-fill" id="confirmBtn" style="text-transform: none; padding: 15px;">
                            @if($plan->require_otp)
                                <span id="confirmBtnText">Send OTP & Invest</span> <i class="fas fa-paper-plane ml-2"></i>
                            @else
                                <span id="confirmBtnText">Confirm Investment</span> <i class="fas fa-check-circle ml-2"></i>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ZERO BALANCE MODAL -->
    <div class="modal fade" id="zeroBalanceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content overflow-hidden">
                <div class="modal-body text-center p-5">
                    <div class="success-icon-container mb-4">
                        <div class="success-glow" style="background: rgba(255, 0, 0, 0.1);"></div>
                        <i class="fas fa-wallet"
                            style="font-size: 70px; color: var(--accent-red); position: relative; z-index: 1;"></i>
                    </div>

                    <h3 class="text-white mb-3 fw-bold">Empty Wallet!</h3>
                    <p class="text-muted mb-4 px-2">It looks like your current balance is zero. Please deposit funds into
                        your account to start investing and generating daily returns.</p>

                    <div class="d-flex flex-column gap-3">
                        <a href="{{ route('user.deposit.index') }}" class="submit-btn-modern w-100">
                            <span>Deposit Amount</span> <i class="fas fa-plus-circle"></i>
                        </a>
                        <button type="button" class="btn text-muted fw-bold" data-bs-dismiss="modal">
                            Not Now, I'll browse first
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            let currentBalance = {{ auth()->user()->balance }};
            let verifiedOtp = ''; // Stores OTP after successful verification
            let otpRequired = {{ $plan->require_otp ? 'true' : 'false' }}; // OTP toggle from admin

            // Append modals to body immediately to prevent CSS stacking context / z-index issues
            $('#zeroBalanceModal').appendTo('body');
            $('#confirmModal').appendTo('body');

            // Check for zero balance on load (with responsive 1000ms delay)
            if (currentBalance <= 0) {
                setTimeout(function () {
                    $('#zeroBalanceModal').modal('show');
                }, 1000);
            }
            let minInvest = {{ $plan->minimum_investment }};
            let maxInvest = {{ $plan->maximum_investment > 0 ? $plan->maximum_investment : 'Infinity' }};

            // Preset Amount Buttons (Same as Withdrawal)
            $('.preset-btn').on('click', function () {
                $('.preset-btn').removeClass('active');
                $(this).addClass('active');
                const amount = $(this).data('amount');
                $('.amount-input').val(amount).trigger('input');
            });

            // Amount input change
            $('.amount-input').on('input', function () {
                let val = $(this).val();

                // Prevent negative and enforce hard max limit
                if (val !== '') {
                    if (parseFloat(val) < 0) {
                        $(this).val(Math.abs(val));
                        val = Math.abs(val);
                    }

                    if (parseFloat(val) > 1000000) {
                        $(this).val(1000000);
                        val = 1000000;
                    }
                }

                let amt = parseFloat(val) || 0;

                // Show/Hide Balance Error Message
                if (amt > currentBalance) {
                    $('#balanceError').removeClass('d-none');
                } else {
                    $('#balanceError').addClass('d-none');
                }
                $('#displayAmount').text(amt.toFixed(2));

                // Hard limits: min 10, max 1,000,000, and must be <= current balance
                // Also respects plan specific limits if they are stricter
                let hardMin = 10;
                let hardMax = 1000000;

                let effectiveMin = Math.max(minInvest, hardMin);
                let effectiveMax = maxInvest === Infinity ? hardMax : Math.min(maxInvest, hardMax);

                if (amt >= effectiveMin && amt <= effectiveMax && amt <= currentBalance) {
                    $('#nextBtn').prop('disabled', false);
                } else {
                    $('#nextBtn').prop('disabled', true);
                }
            });

            // Initial check
            $('#nextBtn').prop('disabled', true);            // Navigation (Open Modal)
            $('#nextBtn').on('click', function () {
                let amt = parseFloat($('.amount-input').val());

                // Reset Modal State
                $('#otpSection').addClass('d-none');
                $('#confirmDisclaimer').removeClass('d-none');
                $('#otpInput').val('').prop('readonly', false).css('border-color', 'rgba(255,255,255,0.1)');
                $('#otpStatus').addClass('d-none');
                $('#otpInstruction').html('<i class="fas fa-envelope-open-text me-1"></i> A 6-digit OTP has been sent to your email.');
                verifiedOtp = ''; // Reset stored OTP

                // Restore correct button label based on OTP setting
                if (otpRequired) {
                    $('#confirmBtn').prop('disabled', false).html('<span id="confirmBtnText">Send OTP & Invest</span> <i class="fas fa-paper-plane ml-2"></i>');
                } else {
                    $('#confirmBtn').prop('disabled', false).html('<span id="confirmBtnText">Invest Now</span> <i class="fas fa-check-circle ml-2"></i>');
                }

                // Confirm details in modal
                $('.confirmAmount').text(amt.toFixed(2));
                $('.confirmPostBalance').text('{{ $general->cur_sym }}' + (currentBalance - amt).toFixed(2));

                // Open Modal
                $('#confirmModal').modal('show');
            });

            // Final Confirmation via AJAX (Using delegation for stability)
            $(document).on('click', '#confirmBtn', function (e) {
                e.preventDefault();
                let btn = $(this);
                let otpSection = $('#otpSection');
                let otpStatus = $('#otpStatus');
                
                let otpVisible = !otpSection.hasClass('d-none');
                let isVerified = !otpStatus.hasClass('d-none');

                // ─── No OTP Required: Direct Investment ───
                if (!otpRequired) {
                    btn.prop('disabled', true).html('<span><i class="fas fa-spinner fa-spin"></i> Processing...</span>');
                    try {
                        let form = $('#investForm');
                        let requestData = {};
                        form.serializeArray().forEach(function(x){ requestData[x.name] = x.value; });

                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: requestData,
                            timeout: 45000,
                            success: function(response) {
                                if (response.status == 'success') {
                                    $('#confirmModal').modal('hide');
                                    $('#step-1-content').addClass('d-none');
                                    $('#success-content').removeClass('d-none').addClass('animate__animated animate__zoomIn');
                                    try {
                                        let amtVal = parseFloat($('.amount-input').val()) || 0;
                                        $('#successAmount').text('{{ $general->cur_sym }}' + amtVal.toFixed(2));
                                    } catch(e){}
                                    if (response.summary) {
                                        try {
                                            if(response.summary.balance) $('#summaryBalance').text('{{ $general->cur_sym }}' + response.summary.balance);
                                            if(response.summary.totalInvest) $('#summaryTotalInvest').text('{{ $general->cur_sym }}' + response.summary.totalInvest);
                                            if(response.summary.totalReceived) $('#summaryTotalReceived').text('{{ $general->cur_sym }}' + response.summary.totalReceived);
                                            if(response.summary.remaining) $('#summaryRemaining').text('{{ $general->cur_sym }}' + response.summary.remaining);
                                            if(response.summary.totalPotential) $('#summaryPotential').text('{{ $general->cur_sym }}' + response.summary.totalPotential);
                                            if(response.summary.balance) currentBalance = parseFloat(response.summary.balance.toString().replace(/,/g,''));
                                        } catch(e){}
                                    }
                                } else {
                                    notify('error', response.message);
                                    btn.prop('disabled', false).html('<span>Confirm & Invest Now <i class="fas fa-check-circle ml-2"></i></span>');
                                }
                            },
                            error: function(xhr, status) {
                                let msg = status === 'timeout' ? 'Request timed out.' : (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Something went wrong');
                                notify('error', msg);
                                btn.prop('disabled', false).html('<span>Confirm & Invest Now <i class="fas fa-check-circle ml-2"></i></span>');
                            }
                        });
                    } catch(err) {
                        notify('error', 'Error: ' + err.message);
                        btn.prop('disabled', false).html('<span>Confirm & Invest Now <i class="fas fa-check-circle ml-2"></i></span>');
                    }
                    return; // Stop here — don't run OTP flow
                }

                if (!otpVisible) {
                    // Step 1: Send OTP
                    btn.prop('disabled', true).html('<span><i class="fas fa-spinner fa-spin"></i> Sending OTP...</span>');

                    $.ajax({
                        url: "{{ route('user.plan.send_otp') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            amount: $('.amount-input').val()
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                notify('success', response.message);
                                otpSection.removeClass('d-none');
                                $('#confirmDisclaimer').addClass('d-none');
                                $('#confirmBtnText').text('Enter OTP to Continue');
                                btn.prop('disabled', true).html('<span><i class="fas fa-clock"></i> Waiting for OTP...</span>');
                                $('#otpInput').focus();
                            } else {
                                notify('error', response.message);
                                btn.prop('disabled', false).html('<span>Get OTP & Invest <i class="fas fa-rocket ml-2"></i></span>');
                            }
                        },
                        error: function (xhr) {
                            let msg = 'Failed to send OTP';
                            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                            notify('error', msg);
                            btn.prop('disabled', false).html('<span>Get OTP & Invest <i class="fas fa-rocket ml-2"></i></span>');
                        }
                    });
                } else if (isVerified) {
                    // Step 2: Already Verified, Process Investment
                    btn.prop('disabled', true).html('<span><i class="fas fa-spinner fa-spin"></i> Activating...</span>');
                    
                    try {
                        // Read OTP from verified store (most reliable)
                        let otpVal = verifiedOtp;
                        
                        if (!otpVal || otpVal.length !== 6) {
                            notify('error', 'Verification code is missing. Please re-enter and verify the OTP.');
                            btn.prop('disabled', false).html('<span>Confirm & Activate <i class="fas fa-check-circle ml-2"></i></span>');
                            return;
                        }
                        
                        let form = $('#investForm');
                        let url = form.attr('action');
                        
                        // Show immediate processing feedback
                        $('#otpInstruction').html('<span class="text-warning animate__animated animate__pulse animate__infinite"><i class="fas fa-sync fa-spin"></i> Finalizing Investment...</span>');

                        // Build request data as an object for better reliability
                        let requestData = {};
                        form.serializeArray().forEach(function(x){ requestData[x.name] = x.value; });
                        requestData['otp'] = otpVal;

                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: requestData,
                            timeout: 45000, // Increased timeout to 45s
                            success: function (response) {
                                if (response.status == 'success') {
                                    $('#confirmModal').modal('hide');
                                    $('#step-1-content').addClass('d-none');
                                    $('#success-content').removeClass('d-none').addClass('animate__animated animate__zoomIn');
                                    
                                    try {
                                        let amtVal = parseFloat($('.amount-input').val()) || 0;
                                        $('#successAmount').text('{{ $general->cur_sym }}' + amtVal.toFixed(2));
                                    } catch (e) { }
                                    
                                    if (response.summary) {
                                        try {
                                            if(response.summary.balance) $('#summaryBalance').text('{{ $general->cur_sym }}' + response.summary.balance);
                                            if(response.summary.totalInvest) $('#summaryTotalInvest').text('{{ $general->cur_sym }}' + response.summary.totalInvest);
                                            if(response.summary.totalReceived) $('#summaryTotalReceived').text('{{ $general->cur_sym }}' + response.summary.totalReceived);
                                            if(response.summary.remaining) $('#summaryRemaining').text('{{ $general->cur_sym }}' + response.summary.remaining);
                                            if(response.summary.totalPotential) $('#summaryPotential').text('{{ $general->cur_sym }}' + response.summary.totalPotential);
                                            
                                            if(response.summary.balance) {
                                                currentBalance = parseFloat(response.summary.balance.toString().replace(/,/g, ''));
                                            }
                                        } catch (e) { }
                                    }
                                } else {
                                    notify('error', response.message);
                                    btn.prop('disabled', false).html('<span>Confirm & Activate <i class="fas fa-check-circle ml-2"></i></span>');
                                    $('#otpInstruction').html('<span class="text-danger"><i class="fas fa-exclamation-circle"></i> ' + response.message + '</span>');
                                }
                            },
                            error: function (xhr, status) {
                                let msg = 'Something went wrong';
                                if (status === 'timeout') msg = 'Request timed out. Please check your transaction history.';
                                else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                                
                                notify('error', msg);
                                btn.prop('disabled', false).html('<span>Confirm & Activate <i class="fas fa-check-circle ml-2"></i></span>');
                                $('#otpInstruction').html('<span class="text-danger"><i class="fas fa-times-circle"></i> Action failed. Please try again.</span>');
                            }
                        });
                    } catch (err) {
                        notify('error', 'JS Error: ' + err.message);
                        btn.prop('disabled', false).html('<span>Confirm & Activate <i class="fas fa-check-circle ml-2"></i></span>');
                    }
                }
            });

            // Auto-Verify OTP Logic
            $('#otpInput').on('input', function() {
                let otp = $(this).val();
                let inputField = $(this);

                if (otp.length === 6) {
                    $('#otpLoading').removeClass('d-none');
                    inputField.css('border-color', 'rgba(255,255,255,0.1)');
                    
                    $.ajax({
                        url: "{{ route('user.plan.verify_otp') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            otp: otp
                        },
                        success: function(response) {
                            $('#otpLoading').addClass('d-none');
                            if (response.status == 'success') {
                                inputField.css('border-color', '#28c76f');
                                $('#otpStatus').removeClass('d-none');
                                $('#otpInstruction').html('<span class="text-success fw-bold"><i class="fas fa-check-double"></i> Verification Complete!</span>');
                                $('#confirmBtn').prop('disabled', false).html('<span>Confirm & Activate <i class="fas fa-check-circle ml-2"></i></span>');
                                verifiedOtp = otp; // Store verified OTP for submission
                                inputField.prop('readonly', true);
                            } else {
                                inputField.css('border-color', '#ea5455');
                                $('#otpStatus').addClass('d-none');
                                notify('error', 'Invalid code. Please check your email.');
                                inputField.addClass('animate__animated animate__shakeX');
                                setTimeout(() => inputField.removeClass('animate__animated animate__shakeX'), 500);
                            }
                        },
                        error: function() {
                            $('#otpLoading').addClass('d-none');
                            notify('error', 'Verification failed.');
                        }
                    });
                } else {
                    $('#otpStatus').addClass('d-none');
                    inputField.css('border-color', 'rgba(255,255,255,0.1)');
                }
            });

            // Invest Again Logic (Page Reload)
            $('#investAgainBtn').on('click', function () {
                location.reload();
            });

        })(jQuery);
    </script>
@endpush