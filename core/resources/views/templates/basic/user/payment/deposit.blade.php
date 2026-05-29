@extends($activeTemplate . 'layouts.master')
@section('content')
@php
    $gatewayCurrency = $gatewayCurrency ?? [];
@endphp


<div class="deposit-container">

<!-- Progress Bar Section -->
        <div class="progress-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Deposit Details</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Payment</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
            <!-- Main Content -->
    <div class="deposit-wrapper">
        <!-- STEP 1 -->
        <div id="step-1" class="deposit-step">
            <div class="deposit-grid">
                <!-- Deposit Form Card -->
            <div class="deposit-form-card">
                <div class="card-header">
                    <h3><i class="fas fa-credit-card"></i> Deposit Funds</h3>
                    <div class="balance-info">
                        <span>Current Balance:</span>
                        <strong>{{ showAmount(auth()->user()->balance) }} {{ $general->cur_text }}</strong>
                    </div>
                </div>
                
                <form action="{{ route('user.deposit.insert') }}" method="post" class="deposit-form">
                    @csrf
                    <input type="hidden" name="method_code">
                    <input type="hidden" name="currency">
                    
                    <!-- Amount Input -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-coins"></i> Deposit Amount
                        </label>
                        <div class="amount-input-group">
                            <span class="currency-symbol">{{ $general->cur_sym }}</span>
                            <input type="number" 
                                   step="any" 
                                   name="amount" 
                                   class="form-control amount-input" 
                                   value="{{ old('amount') }}" 
                                   placeholder="0.00"
                                   required
                                   min="0"
                                   inputmode="decimal"
                                   onkeypress="return (event.charCode != 45 && event.charCode != 43)"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            <div class="amount-presets">
                                <button type="button" class="preset-btn" data-amount="10">$10</button>
                                <button type="button" class="preset-btn" data-amount="50">$50</button>
                                <button type="button" class="preset-btn" data-amount="100">$100</button>
                                <button type="button" class="preset-btn" data-amount="500">$500</button>
                            </div>
                        </div>
                        <div class="input-hint">Enter amount between $10 - $5000</div>
                    </div>

                    <!-- Payment Method Select -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-wallet"></i> Payment Method
                        </label>
                        <div class="payment-methods">
                            @foreach($gatewayCurrency as $data)
                            <div class="method-card" data-gateway="{{ $data->method_code }}" data-info="{{ json_encode($data) }}">
                                <div class="method-icon">
                                    @if($data->method->crypto == 1)
                                    <i class="fas fa-bitcoin"></i>
                                    @else
                                    <i class="fas fa-credit-card"></i>
                                    @endif
                                </div>
                                <div class="method-info">
                                    <h4>{{ $data->name }}</h4>
                                    <p class="method-fee">
                                        Fee: {{ showAmount($data->fixed_charge) }} {{ $general->cur_text }} + {{ $data->percent_charge }}%
                                    </p>
                                    <p class="method-limits">
                                        Limits: {{ showAmount($data->min_amount) }} - {{ showAmount($data->max_amount) }} {{ $general->cur_text }}
                                    </p>
                                </div>
                                <div class="method-select">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            @endforeach
                            
                            @if(count($gatewayCurrency) == 0)
                            <div class="no-methods">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>No payment methods available at the moment</p>
                            </div>
                            @endif
                        </div>
                        <select class="form-select d-none" name="gateway" required>
                            <option value="">Select Payment Method</option>
                            @foreach($gatewayCurrency as $data)
                                <option value="{{ $data->method_code }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Details Preview -->
                    <div class="payment-preview d-none">
                        <div class="preview-header">
                            <h4><i class="fas fa-receipt"></i> Payment Summary</h4>
                        </div>
                        <div class="preview-details">
                            <div class="detail-row">
                                <span>Deposit Amount:</span>
                                <span class="detail-amount">{{ $general->cur_sym }}<span id="previewAmount">0.00</span></span>
                            </div>
                            <div class="detail-row">
                                <span>Processing Fee:</span>
                                <span class="detail-fee">{{ $general->cur_sym }}<span id="previewFee">0.00</span></span>
                            </div>
                            <div class="detail-row total">
                                <span>Total Payable:</span>
                                <span class="detail-total">{{ $general->cur_sym }}<span id="previewTotal">0.00</span></span>
                            </div>
                            <div class="crypto-info d-none">
                                <div class="detail-row">
                                    <span>Conversion Rate:</span>
                                    <span>1 {{ $general->cur_text }} = <span id="previewRate">0</span> <span id="previewCurrency"></span></span>
                                </div>
                                <div class="detail-row">
                                    <span>You Will Pay:</span>
                                    <span class="detail-crypto"><span id="previewFinal">0</span> <span id="previewCurrency2"></span></span>
                                </div>
                                <div class="crypto-note">
                                    <i class="fas fa-info-circle"></i>
                                    Conversion will be completed on next step
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn" id="submitBtn" disabled>
                        <span>Continue to Payment</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <!-- Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3><i class="fas fa-shield-alt"></i> Secure Deposit</h3>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="info-content">
                            <h4>Bank-Level Security</h4>
                            <p>All transactions are protected with 256-bit SSL encryption</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Instant Processing</h4>
                            <p>Most deposits are processed and credited instantly</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="info-content">
                            <h4>24/7 Support</h4>
                            <p>Our support team is always ready to help you</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="info-content">
                            <h4>Global Coverage</h4>
                            <p>Accepting payments from all over the world</p>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Section -->
                <div class="faq-section">
                    <h4><i class="fas fa-question-circle"></i> Frequently Asked Questions</h4>
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>How long do deposits take to process?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Most deposits are processed instantly. Cryptocurrency deposits may take 5-15 minutes depending on network confirmation times.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Are there any deposit limits?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Minimum deposit is $10 and maximum varies by payment method. You can check the limits for each method above.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>Is my money safe?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p>Yes, we use bank-level security and encryption to protect all transactions and personal information.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- END STEP 1 -->

        <!-- STEP 2: MANUAL PAYMENT DETAILS -->
        <div id="step-2" class="deposit-step" style="display:none;">
            <div class="deposit-grid">
                <!-- Payment Details Card (Left) -->
                <div class="deposit-form-card">
                    <div class="card-header">
                        <h3><i class="fas fa-receipt"></i> Payment Details</h3>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div class="payment-preview" style="display:block; margin:0;">
                            <div class="preview-details">
                                <div class="detail-row">
                                    <span>Requested Amount</span>
                                    <span class="detail-amount" id="step2-amount"></span>
                                </div>
                                <div class="detail-row total">
                                    <span>Payable Amount</span>
                                    <span class="detail-total" id="step2-payable"></span>
                                </div>
                                <div class="detail-row">
                                    <span>Exchange Rate</span>
                                    <span class="detail-amount" id="step2-rate"></span>
                                </div>
                                <div class="detail-row">
                                    <span>Processing Time</span>
                                    <span class="detail-amount">10-30 Minutes</span>
                                </div>
                            </div>
                        </div>

                        <div class="payment-preview mt-4" style="margin-top:20px; display:block;">
                            <div class="preview-header">
                                <h4><i class="fas fa-info-circle"></i> Instructions</h4>
                            </div>
                            <div class="preview-details" id="step2-instructions">
                                <!-- Dynamic Instructions go here -->
                            </div>
                        </div>

                        <div class="crypto-note d-none" id="crypto-info-container">
                            <i class="fas fa-wallet"></i> Please scan the QR code or copy the wallet address provided in the instructions to make your cryptocurrency payment.
                        </div>
                    </div>
                </div>

                <!-- Complete Payment Card (Right) -->
                <div class="info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-credit-card"></i> Complete Payment</h3>
                    </div>
                    <div class="card-body">
                        <form id="manualPaymentForm" action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Payment Method Info -->
                            <div class="method-card selected mb-4" style="cursor:default; margin-bottom: 20px;">
                                <div class="method-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="method-info">
                                    <h4 id="step2-gateway-name"></h4>
                                    <p class="method-fee">Manual Bank Transfer / Crypto Payment</p>
                                </div>
                            </div>

                            <!-- Dynamic Form Fields -->
                            <div id="dynamic-form-fields"></div>

                            <button type="submit" class="submit-btn mt-4">
                                <i class="fas fa-paper-plane"></i>
                                <span>Confirm & Submit Payment</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END STEP 2 -->

        <!-- STEP 3: SUCCESS -->
        <div id="step-3" class="deposit-step" style="display:none; text-align:center; padding: 40px 20px;">
            <div style="font-size: 80px; color: var(--success-green); margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 style="color: white; margin-bottom: 10px;">Deposit Request Submitted!</h2>
            <p style="color: var(--text-muted); font-size: 16px; margin-bottom: 30px;">Your deposit request has been successfully taken. Please wait while our team verifies your payment. This usually takes 10-30 minutes.</p>
            
            <a href="{{ route('user.deposit.history') }}" class="make-deposit-btn" style="text-decoration:none;">
                View Deposit History
            </a>
        </div>
        <!-- END STEP 3 -->

    </div>

    <!-- Hidden Gateway Form Templates for Step 2 -->
    <div id="gateway-form-templates" style="display:none;">
        @foreach($gatewayCurrency as $data)
            @if($data->method_code >= 1000)
                <div id="form-template-{{ $data->method->form_id }}">
                    <x-viser-form identifier="id" identifierValue="{{ $data->method->form_id }}" />
                </div>
            @endif
        @endforeach
    </div>
</div>



<style>
/* ========== Dark Black & Red Theme Variables ========== */
:root {
    --primary-black: #0a0a0a;
    --dark-black: #000000;
    --sidebar-black: #0d0d0d;
    --card-black: #111111;
    --hover-black: #1a1a1a;
    --accent-red: #ff0000;
    --deep-red: #8b0000;
    --light-red: #ff3333;
    --hover-red: #ff1a1a;
    --border-red: rgba(255, 0, 0, 0.2);
    --text-white: #ffffff;
    --text-light: #e6e6e6;
    --text-muted: #999999;
    --success-green: #00ff00;
    --danger-red: #ff3333;
    --warning-orange: #ff9900;
    --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
    --gradient-black: linear-gradient(135deg, var(--dark-black) 0%, var(--card-black) 100%);
    --gradient-card: linear-gradient(145deg, #111111 0%, #1a1a1a 100%);
    --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
    --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.5);
    --transition: all 0.3s ease;
}

/* ========== Progress Bar ========== */
.progress-section {
    margin-bottom: 30px;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.progress-bar-container {
    background: var(--gradient-card);
    border-radius: 15px;
    border: 1px solid var(--border-red);
    padding: 25px;
    box-shadow: var(--shadow-card);
    position: relative;
    overflow: hidden;
}

.progress-bar-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--deep-red) 0%, var(--accent-red) 100%);
    opacity: 0.3;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
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
    top: 16px;
    left: 57%;
    right: -43%;
    height: 2px;
    background: rgba(255, 255, 255, 0.1);
    z-index: -1;
}

.step:last-child::before {
    display: none;
}

.step.active::before {
    background: var(--gradient-red);
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
    font-size: 16px;
    margin-bottom: 10px;
    transition: var(--transition);
    position: relative;
    z-index: 2;
}

.step.active .step-number {
    background: var(--gradient-red);
    border-color: var(--light-red);
    color: white;
    box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5); }
    70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
}

.step.completed .step-number {
    background: var(--gradient-red);
    border-color: var(--light-red);
    color: white;
}

.step.completed .step-number::after {
    content: '✓';
    font-size: 18px;
}

.step-label {
    color: var(--text-muted);
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    transition: var(--transition);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.step.active .step-label {
    color: var(--text-white);
    text-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

.progress-track {
    height: 6px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 15px;
}

.progress-fill {
    height: 100%;
    background: var(--gradient-red);
    border-radius: 3px;
    transition: width 0.5s ease;
    position: relative;
    overflow: hidden;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.2), 
        transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-text {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.current-step {
    color: var(--light-red);
    font-weight: 600;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.current-step::before {
    content: '';
    width: 10px;
    height: 10px;
    background: var(--gradient-red);
    border-radius: 50%;
    display: inline-block;
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.step-title {
    color: var(--text-light);
    font-size: 15px;
    font-weight: 500;
}

/* Responsive Design for Progress Bar */
@media screen and (max-width: 768px) {
    .progress-bar-container {
        padding: 20px 15px;
    }
    
    .step-number {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .step-label {
        font-size: 12px;
    }
    
    .progress-text {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
    
    .step::before {
        top: 14px;
    }
}

@media screen and (max-width: 480px) {
    .progress-steps {
        margin-bottom: 15px;
    }
    
    .step-number {
        width: 32px;
        height: 32px;
        margin-bottom: 8px;
    }
    
    .step-label {
        font-size: 11px;
    }
    
    .progress-bar-container {
        padding: 15px 12px;
    }
    
    .step::before {
        top: 12px;
        right: -38%;
        left: 63%;
    }
}

/* ========== Video Background ========== */
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
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.9) 0%, rgba(139,0,0,0.1) 100%);
}

/* ========== Deposit Container ========== */
.deposit-container {
    margin-left: 280px;
    padding: 30px;
    min-height: 100vh;
    animation: fadeIn 0.5s ease;
    position: relative;
    z-index: 1;
    padding-bottom: 100px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ========== Deposit Header ========== */
.deposit-header {
    background: var(--gradient-black);
    border-radius: 15px;
    border: 1px solid var(--border-red);
    padding: 25px 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow-card);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
}

.header-icon {
    width: 70px;
    height: 70px;
    background: var(--gradient-red);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    color: white;
    box-shadow: var(--shadow-red);
}

.header-text h1 {
    color: var(--text-white);
    font-size: 28px;
    margin: 0 0 5px 0;
    text-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

.header-text p {
    color: var(--text-muted);
    margin: 0;
    font-size: 16px;
}

.back-btn {
    background: rgba(255, 0, 0, 0.1);
    border: 1px solid var(--border-red);
    color: var(--light-red);
    padding: 12px 25px;
    border-radius: 10px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    transition: var(--transition);
    white-space: nowrap;
    cursor: pointer;
}

.back-btn:hover {
    background: var(--gradient-red);
    color: white;
    transform: translateX(-5px);
}

/* ========== Deposit Wrapper ========== */
.deposit-wrapper {
    max-width: 1400px;
    margin: 0 auto;
}

.deposit-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 25px;
    margin-bottom: 30px;
}

/* ========== Card Styles ========== */
.deposit-form-card,
.info-card,
.recent-deposits {
    background: var(--gradient-card);
    border-radius: 15px;
    border: 1px solid var(--border-red);
    overflow: hidden;
    box-shadow: var(--shadow-card);
    margin-bottom: 25px;
    transition: var(--transition);
}

.deposit-form-card:hover,
.info-card:hover,
.recent-deposits:hover {
    border-color: var(--light-red);
    box-shadow: var(--shadow-red);
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
    color: var(--text-white);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
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

.view-all {
    color: var(--light-red);
    text-decoration: none;
    font-size: 14px;
    transition: var(--transition);
}

.view-all:hover {
    text-decoration: underline;
}

/* ========== Form Styles ========== */
.deposit-form {
    padding: 25px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    color: var(--text-light);
    font-size: 15px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
}

/* Amount Input */
.amount-input-group {
    position: relative;
}

.currency-symbol {
    position: absolute;
    left: 17px;
    top: 22%;
    transform: translateY(-50%);
    color: var(--light-red);
    font-weight: 600;
    font-size: 22px;
    z-index: 1;
}

.amount-input {
    width: 100%;
    padding: 15px 15px 15px 40px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-red);
    border-radius: 10px;
    color: var(--text-white);
    font-size: 18px;
    font-weight: 600;
    transition: var(--transition);
    -webkit-appearance: none;
    -moz-appearance: textfield;
}

/* Remove spinners for number input */
.amount-input::-webkit-inner-spin-button,
.amount-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.amount-input:focus {
    outline: none;
    border-color: var(--light-red);
    box-shadow: 0 0 0 3px  rgba(255, 255, 255, 0.05);
}

.input-hint {
    color: var(--text-muted);
    font-size: 12px;
    margin-top: 8px;
    display: block;
}

.amount-presets {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.preset-btn {
    padding: 8px 15px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-red);
    color: var(--text-muted);
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    font-size: 14px;
    font-weight: 500;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}

.preset-btn:hover,
.preset-btn.active {
    background: rgba(255, 0, 0, 0.2);
    color: var(--text-white);
    border-color: var(--light-red);
}

/* Payment Methods */
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px;
    -webkit-overflow-scrolling: touch;
}

.payment-methods::-webkit-scrollbar {
    width: 5px;
}

.payment-methods::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

.payment-methods::-webkit-scrollbar-thumb {
    background: var(--light-red);
    border-radius: 10px;
}

.method-card {
    background: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-red);
    border-radius: 12px;
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}

.method-card:hover,
.method-card:active {
    background: rgba(255, 0, 0, 0.05);
    transform: translateX(5px);
}

.method-card.selected {
    background: rgba(255, 0, 0, 0.1);
    border-color: var(--light-red);
}

.method-icon {
    width: 50px;
    height: 50px;
    background: var(--gradient-red);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: white;
    flex-shrink: 0;
}

.method-info {
    flex: 1;
    min-width: 0;
}

.method-info h4 {
    color: var(--text-white);
    margin: 0 0 5px 0;
    font-size: 16px;
}

.method-fee,
.method-limits {
    color: var(--text-muted);
    font-size: 13px;
    margin: 2px 0;
}

.method-select {
    opacity: 0;
    color: var(--light-red);
    font-size: 22px;
    transition: var(--transition);
}

.method-card.selected .method-select {
    opacity: 1;
}

.no-methods {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
}

.no-methods i {
    font-size: 40px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.no-methods p {
    margin: 0;
    font-size: 16px;
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
    padding: 15px 20px;
    background: rgba(255, 0, 0, 0.1);
    border-bottom: 1px solid var(--border-red);
}

.preview-header h4 {
    color: var(--text-white);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}

.preview-details {
    padding: 20px;
}

/* Fix for dynamically loaded instructions (Mobile specific layout) */
#step2-instructions {
    overflow-wrap: break-word;
    word-wrap: break-word;
    word-break: break-word;
    text-align: center;
}

#step2-instructions img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 15px auto;
    border-radius: 8px;
}

#step2-instructions p, #step2-instructions span, #step2-instructions div {
    white-space: normal;
    word-break: break-word;
    margin-bottom: 10px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row span:first-child {
    color: var(--text-light);
    font-size: 15px;
}

.detail-amount,
.detail-fee {
    color: var(--text-white);
    font-weight: 600;
    font-size: 16px;
}

.detail-row.total {
    padding-top: 15px;
    margin-top: 10px;
    border-top: 2px solid var(--border-red);
}

.detail-total {
    color: var(--light-red);
    font-size: 20px;
    font-weight: 700;
}

.detail-crypto {
    color: var(--success-green);
    font-weight: 600;
    font-size: 16px;
}

.crypto-note {
    background: rgba(0, 255, 0, 0.1);
    border: 1px solid rgba(0, 255, 0, 0.3);
    border-radius: 8px;
    padding: 12px 15px;
    margin-top: 15px;
    color: var(--success-green);
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Submit Button */
.submit-btn {
    width: 100%;
    padding: 18px;
    background: var(--gradient-red);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    position: relative;
    overflow: hidden;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
}

.submit-btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: var(--shadow-red);
}

.submit-btn:active:not(:disabled) {
    transform: translateY(-1px);
}

.submit-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: var(--gradient-black);
}

/* ========== Info Card ========== */
.info-card .card-body {
    padding: 20px;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 0, 0, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--light-red);
    flex-shrink: 0;
}

.info-content h4 {
    color: var(--text-white);
    margin: 0 0 8px 0;
    font-size: 16px;
}

.info-content p {
    color: var(--text-muted);
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
}

/* FAQ Section */
.faq-section {
    padding: 20px;
    border-top: 1px solid var(--border-red);
    background: rgba(0, 0, 0, 0.2);
}

.faq-section h4 {
    color: var(--text-white);
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 16px;
}

.faq-item {
    margin-bottom: 15px;
    border: 1px solid var(--border-red);
    border-radius: 10px;
    overflow: hidden;
}

.faq-question {
    padding: 15px;
    background: rgb(23 22 22);
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: var(--transition);
    -webkit-tap-highlight-color: transparent;
}

.faq-question:hover {
        background: rgb(58, 7, 7) !important;
}

.faq-question span {
    color: var(--text-light);
    font-weight: 500;
    font-size: 15px;
}

.faq-question i {
    color: var(--light-red);
    transition: var(--transition);
}

.faq-item.active .faq-question i {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    background: rgb(23 22 22);
}

.faq-item.active .faq-answer {
    padding: 15px;
    max-height: 200px;
}

.faq-answer p {
    color: var(--text-muted);
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
}

/* ========== Recent Deposits ========== */
.deposits-list {
    padding: 20px;
    max-height: 400px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

.deposit-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.deposit-item:last-child {
    border-bottom: none;
}

.deposit-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.deposit-icon.success {
    background: rgba(0, 255, 0, 0.1);
    color: var(--success-green);
}

.deposit-icon.pending {
    background: rgba(255, 153, 0, 0.1);
    color: var(--warning-orange);
}

.deposit-info {
    flex: 1;
    min-width: 0;
}

.deposit-info h4 {
    color: var(--text-light);
    margin: 0 0 5px 0;
    font-size: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.deposit-info p {
    color: var(--text-muted);
    margin: 0;
    font-size: 13px;
}

.deposit-amount {
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
}

.text-success {
    color: var(--success-green) !important;
}

.text-warning {
    color: var(--warning-orange) !important;
}

.deposit-status {
    flex-shrink: 0;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.success {
    background: rgba(0, 255, 0, 0.1);
    color: var(--success-green);
}

.status-badge.pending {
    background: rgba(255, 153, 0, 0.1);
    color: var(--warning-orange);
}

.status-badge.cancelled {
    background: rgba(255, 0, 0, 0.1);
    color: var(--danger-red);
}

.empty-deposits {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-muted);
}

.empty-deposits i {
    font-size: 40px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.empty-deposits p {
    margin: 0 0 20px 0;
    font-size: 16px;
}

.make-deposit-btn {
    display: inline-block;
    background: var(--gradient-red);
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    -webkit-tap-highlight-color: transparent;
}

.make-deposit-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-red);
}

/* ========== Mobile Navigation ========== */


/* ========== Responsive Design ========== */
@media screen and (max-width: 1200px) {
    .deposit-grid {
        grid-template-columns: 1fr;
    }
    
    .deposit-container {
        margin-left: 280px;
    }
}

@media screen and (max-width: 1024px) {
    .deposit-container {
        margin-left: 0;
        padding: 20px 15px;
        padding-bottom: 80px;
    }
    

    
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .deposit-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
        padding: 20px;
    }
    
    .back-btn {
        width: 100%;
        justify-content: center;
    }
}

@media screen and (max-width: 768px) {
    .deposit-container {
        padding: 15px 12px;
        padding-bottom: 80px;
    }
    
    .deposit-header {
        padding: 15px;
        border-radius: 12px;
    }
    
    .header-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .header-text h1 {
        font-size: 24px;
    }
    
    .header-text p {
        font-size: 14px;
    }
    
    .deposit-form {
        padding: 20px;
    }
    
    .card-header {
        padding: 15px 20px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .card-header h3 {
        font-size: 16px;
    }
    
    .method-card {
        padding: 12px;
        gap: 12px;
    }
    
    .method-icon {
        width: 45px;
        height: 45px;
        font-size: 20px;
    }
    
    .method-info h4 {
        font-size: 15px;
    }
    
    .method-fee,
    .method-limits {
        font-size: 12px;
    }
    
    .amount-input {
        padding: 12px 12px 12px 35px;
        font-size: 16px;
        height: 50px;
    }
    .currency-symbol {
        font-size: 19px;
        left: 16px;
        top: 24px;
    }
    .preset-btn {
        padding: 10px 15px;
        font-size: 14px;
        min-width: 70px;
        text-align: center;
    }
    
    .amount-presets {
        justify-content: center;
    }
    
    .info-item {
        padding: 15px 0;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .info-content h4 {
        font-size: 15px;
    }
    
    .info-content p {
        font-size: 13px;
    }
    
    .deposit-item {
        padding: 12px 0;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .deposit-info,
    .deposit-amount,
    .deposit-status {
        flex: 1;
        min-width: auto;
    }
    
    .submit-btn {
        padding: 16px;
        font-size: 16px;
        height: 55px;
    }
    
    /* Mobile touch improvements */
    .method-card,
    .preset-btn,
    .submit-btn,
    .faq-question,
    .back-btn {
        min-height: 44px; /* Apple's recommended minimum touch target size */
    }
    
    .amount-input {
        min-height: 44px;
    }
}

@media screen and (max-width: 480px) {
    .deposit-container {
        padding: 12px 10px;
        padding-bottom: 70px;
    }
    
    .header-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .header-text h1 {
        font-size: 20px;
    }
    
    .deposit-form {
        padding: 15px;
    }
    
    .amount-presets {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .preset-btn {
        width: 100%;
        padding: 12px;
    }
    
    .method-card {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .method-info {
        text-align: center;
    }
    
    .faq-question {
        padding: 12px;
        font-size: 14px;
    }
    
    .mobile-nav .nav-link {
        padding: 10px 3px;
        font-size: 10px;
        min-height: 50px;
    }
    
    .mobile-nav .nav-link i {
        font-size: 16px;
    }
    
    .deposit-grid {
        gap: 15px;
    }
}
</style>

@push('script')
<script>
(function($) {
    "use strict";
    
    // Check if mobile device
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    // Initialize touch events for mobile
    function initMobileTouch() {
        if (!isMobileDevice()) return;
        
        // Add touch feedback for all interactive elements
        $('.preset-btn, .method-card, .submit-btn, .back-btn, .faq-question, .view-all, .make-deposit-btn').on('touchstart', function() {
            $(this).addClass('touch-active');
        }).on('touchend touchcancel', function() {
            $(this).removeClass('touch-active');
        });
    }
    
    // Preset amount buttons - Fixed for mobile
    $('.preset-btn').on('click touchstart', function(e) {
        if (e.type === 'touchstart') {
            e.preventDefault();
            $(this).trigger('click');
            return;
        }
        
        const amount = $(this).data('amount');
        $('.amount-input').val(amount).trigger('input').focus();
        
        // Add active state to clicked button
        $('.preset-btn').removeClass('active');
        $(this).addClass('active');
        
        // Hide mobile keyboard if open
        if (isMobileDevice()) {
            $('.amount-input').blur();
        }
    });
    
    // Payment method selection - Fixed for mobile
    $('.method-card').on('click touchstart', function(e) {
        if (e.type === 'touchstart') {
            e.preventDefault();
            $(this).trigger('click');
            return;
        }
        
        const gateway = $(this).data('gateway');
        const info = $(this).data('info');
        
        // Update UI
        $('.method-card').removeClass('selected');
        $(this).addClass('selected');
        $('select[name=gateway]').val(gateway).trigger('change');
        $('input[name=method_code]').val(gateway);
        $('input[name=currency]').val(info.currency);
        
        // Update preview with method info
        updatePaymentPreview(info);
        
        // Focus amount input on mobile
        if (isMobileDevice()) {
            $('.amount-input').focus();
        }
    });
    
    // Amount input handler with debounce
    let inputTimeout;
    $('.amount-input').on('input', function() {
        clearTimeout(inputTimeout);
        
        // Strict Limit Enforcement
        const selectedMethod = $('.method-card.selected');
        if (selectedMethod.length > 0) {
            const info = selectedMethod.data('info');
            const max_amount = parseFloat(info.max_amount);
            const min_amount = parseFloat(info.min_amount);
            let val = parseFloat($(this).val());
            
            if (val > max_amount) {
                $(this).val(max_amount);
                showAlert(`Oops! Maximum deposit limit is ${max_amount} {{ $general->cur_text }}`, 'error');
            }
        }

        inputTimeout = setTimeout(() => {
            const amount = parseFloat($(this).val()) || 0;
            const selectedMethod = $('.method-card.selected');
            
            if (selectedMethod.length > 0) {
                const info = selectedMethod.data('info');
                updatePaymentPreview(info);
                const min_fmt = parseFloat(info.min_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                const max_fmt = parseFloat(info.max_amount).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $('.input-hint').html(`<i class="fas fa-info-circle"></i> Range: ${min_fmt} - ${max_fmt} ${info.currency}`);
            }
            if (amount > 0 && selectedMethod.length > 0) {
                const info = selectedMethod.data('info');
                if (amount >= parseFloat(info.min_amount) && amount <= parseFloat(info.max_amount)) {
                    $('#submitBtn').prop('disabled', false);
                } else {
                    $('#submitBtn').prop('disabled', true);
                }
            } else {
                $('#submitBtn').prop('disabled', true);
            }
        }, 300);
    });
    
    // Add focus styling for mobile
    $('.amount-input').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
    
    // Update payment preview
    function updatePaymentPreview(info) {
        const amount = parseFloat($('.amount-input').val()) || 0;
        
        if (!info || amount <= 0) {
            $('.payment-preview').addClass('d-none');
            return;
        }
        
        // Calculate charges
        const fixedCharge = parseFloat(info.fixed_charge) || 0;
        const percentCharge = parseFloat(info.percent_charge) || 0;
        const rate = parseFloat(info.rate) || 1;
        
        const charge = fixedCharge + (amount * percentCharge / 100);
        const total = amount + charge;
        const finalAmount = total * rate;
        
        // Update preview
        $('#previewAmount').text(amount.toFixed(2));
        $('#previewFee').text(charge.toFixed(2));
        $('#previewTotal').text(total.toFixed(2));
        
        if (info.method.crypto == 1) {
            $('.crypto-info').removeClass('d-none');
            $('#previewRate').text(rate.toFixed(8));
            $('#previewCurrency').text(info.currency);
            $('#previewCurrency2').text(info.currency);
            $('#previewFinal').text(finalAmount.toFixed(8));
        } else {
            $('.crypto-info').addClass('d-none');
        }
        
        $('.payment-preview').removeClass('d-none');
        
        // Check amount limits
        const minAmount = parseFloat(info.min_amount);
        const maxAmount = parseFloat(info.max_amount);
        
        if (amount < minAmount || amount > maxAmount) {
            $('#submitBtn').prop('disabled', true);
            showAlert('Amount must be between ' + minAmount + ' and ' + maxAmount + ' ' + info.currency, 'error');
        } else {
            $('#submitBtn').prop('disabled', false);
        }
    }
    
    // FAQ functionality with touch support
    $('.faq-question').on('click touchstart', function(e) {
        if (e.type === 'touchstart') {
            e.preventDefault();
            $(this).trigger('click');
            return;
        }
        
        $(this).parent().toggleClass('active');
    });
    
    // Form submission with validation
    $('.deposit-form').submit(function(e) {
        const amount = parseFloat($('.amount-input').val()) || 0;
        const selectedMethod = $('.method-card.selected');
        
        if (amount <= 0) {
            e.preventDefault();
            showAlert('Please enter a valid amount', 'error');
            return false;
        }
        
        if (selectedMethod.length === 0) {
            e.preventDefault();
            showAlert('Please select a payment method', 'error');
            return false;
        }
        
        // Validate amount limits
        const info = selectedMethod.data('info');
        const minAmount = parseFloat(info.min_amount);
        const maxAmount = parseFloat(info.max_amount);
        
        if (amount < minAmount || amount > maxAmount) {
            e.preventDefault();
            showAlert('Amount must be between ' + minAmount + ' and ' + maxAmount + ' ' + info.currency, 'error');
            return false;
        }
        
        // Add loading state
        const btn = $('#submitBtn');
        const originalBtnHtml = btn.html();
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    // Populate Step 2 data
                    const deposit = response.deposit;
                    $('#step2-payable').text(parseFloat(deposit.final_amo).toFixed(2) + ' ' + deposit.method_currency);
                    $('#step2-amount').text(parseFloat(deposit.amount).toFixed(2) + ' {{ $general->cur_text }}');
                    $('#step2-rate').text('1 {{ $general->cur_text }} = ' + parseFloat(deposit.rate).toFixed(8) + ' ' + deposit.method_currency);
                    
                    $('#step2-gateway-name').text(response.method_name);
                    $('#step2-instructions').html(response.gateway_description);

                    if (response.gateway_crypto == 1) {
                        $('#crypto-info-container').removeClass('d-none');
                    } else {
                        $('#crypto-info-container').addClass('d-none');
                    }

                    // Populate correct form
                    const formHtml = $('#form-template-' + response.form_id).html();
                    $('#dynamic-form-fields').html(formHtml);

                    // Switch steps
                    $('#step-1').hide();
                    $('#step-2').fadeIn();
                    
                    $('.step[data-step="1"]').addClass('completed').removeClass('active');
                    $('.step[data-step="2"]').addClass('active');
                    
                    // Reset button
                    btn.prop('disabled', false).html(originalBtnHtml);
                } else {
                    showAlert(response.message || 'Error processing request', 'error');
                    btn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function() {
                showAlert('Network error, please try again.', 'error');
                btn.prop('disabled', false).html(originalBtnHtml);
            }
        });
        
    });

    $(document).on('submit', '#manualPaymentForm', function(e) {
        e.preventDefault();
        const form = $(this);
        const btn = form.find('.submit-btn');
        const originalBtnHtml = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    $('#step-2').hide();
                    $('#step-3').fadeIn();
                    
                    $('.step[data-step="2"]').addClass('completed').removeClass('active');
                    $('.step[data-step="3"]').addClass('active').addClass('completed');
                } else {
                    showAlert(response.message || 'Error submitting payment', 'error');
                    btn.prop('disabled', false).html(originalBtnHtml);
                }
            },
            error: function() {
                showAlert('Error submitting payment', 'error');
                btn.prop('disabled', false).html(originalBtnHtml);
            }
        });
    });
    
    // Alert function
    function showAlert(message, type) {
        const alertClass = type === 'error' ? 'danger-red' : 'success-green';
        const icon = type === 'error' ? 'fas fa-exclamation-circle' : 'fas fa-check-circle';
        
        // Remove existing alerts
        $('.alert-message').remove();
        
        const alertDiv = $('<div class="alert-message">')
            .html(`<i class="${icon}"></i> ${message}`)
            .css({
                position: 'fixed',
                top: '20px',
                right: isMobileDevice() ? '10px' : '20px',
                left: isMobileDevice() ? '10px' : 'auto',
                padding: '15px 20px',
                background: 'var(--card-black)',
                border: '1px solid var(--border-red)',
                borderRadius: '8px',
                color: 'var(--text-white)',
                zIndex: '10000',
                display: 'flex',
                alignItems: 'center',
                gap: '10px',
                boxShadow: 'var(--shadow-red)',
                borderLeft: `4px solid var(--${alertClass})`,
                maxWidth: isMobileDevice() ? 'calc(100% - 20px)' : '400px',
                animation: 'slideInRight 0.3s ease'
            });
        
        $('body').append(alertDiv);
        
        // Add keyframe animation
        if (!$('#alert-animation').length) {
            $('<style id="alert-animation">')
                .text('@keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }')
                .appendTo('head');
        }
        
        setTimeout(() => {
            alertDiv.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Initialize form
    $(document).ready(function() {
        // Initialize mobile touch
        initMobileTouch();
        
        // Auto-select first payment method if available
        if ($('.method-card').length > 0) {
            $('.method-card:first').trigger('click');
        }
        
        // Set default amount to minimum if method is selected
        $('select[name=gateway]').change(function() {
            if ($(this).val()) {
                const selectedMethod = $('.method-card.selected');
                if (selectedMethod.length > 0) {
                    const info = selectedMethod.data('info');
                    $('.amount-input').val(info.min_amount).trigger('input');
                    
                    // On mobile, scroll to amount input
                    if (isMobileDevice()) {
                        $('html, body').animate({
                            scrollTop: $('.amount-input').offset().top - 100
                        }, 300);
                    }
                }
            }
        });
        
        // Handle mobile keyboard events
        if (isMobileDevice()) {
            // Prevent zoom on input focus
            $('input, select, textarea').on('focus', function() {
                $('meta[name=viewport]').attr('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
            }).on('blur', function() {
                $('meta[name=viewport]').attr('content', 'width=device-width, initial-scale=1.0');
            });
            
            // Better tap handling
            $('a, button, .method-card, .preset-btn').on('touchstart', function() {
                $(this).addClass('tap-active');
            }).on('touchend', function() {
                $(this).removeClass('tap-active');
            });
        }
    });
    
    // Handle window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Recalculate any layout-dependent elements
            $('.amount-input').trigger('input');
        }, 250);
    });
    
})(jQuery);
</script>
<style>
footer {
  display: none !important;
}
</style>
@endpush
@endsection