@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="withdraw-container">
        <!-- Background Overlay -->
        <div class="video-overlay"></div>

        <!-- Progress Bar Section -->
        <div class="progress-steps mb-4">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Withdrawal Details</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Verification</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="withdraw-wrapper">

            <!-- STEP 1: Method & Amount -->
            <div id="step-1" class="withdraw-step-content">
                <div class="withdraw-grid">
                    <!-- Withdrawal Form Card -->
                    <div class="withdraw-form-card main-form-card">
                        <div class="card-header">
                            <h3><i class="fas fa-wallet"></i> Withdraw Funds</h3>
                            <div class="balance-info">
                                <span>Current Balance:</span>
                                <strong>{{ showAmount(auth()->user()->balance) }} {{ $general->cur_text }}</strong>
                            </div>
                        </div>

                        <form action="{{route('user.withdraw.money')}}" method="post" class="withdraw-form"
                            id="withdrawMethodForm">
                            @csrf
                            <input type="hidden" name="method_code">

                            <!-- Withdrawal Type Selection -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-hand-holding-usd"></i> Select Wallet Type <span class="text-danger">*</span>
                                </label>
                                <div class="withdrawal-type-list">
                                    <div class="type-card selected" data-type="1">
                                        <div class="type-icon">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div class="type-details">
                                            <h4>Current Balance</h4>
                                            <p>Available: <span class="text--success">{{ $general->cur_sym }}{{ showAmount(auth()->user()->balance) }}</span></p>
                                        </div>
                                        <div class="type-select">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                    <div class="type-card" data-type="2">
                                        <div class="type-icon">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="type-details">
                                            <h4>Investment Amount</h4>
                                            <p>Invested: <span class="text--primary">{{ $general->cur_sym }}{{ showAmount($totalInvestment) }}</span></p>
                                        </div>
                                        <div class="type-select">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="withdrawal_type" value="1">
                                
                                <div id="investment-warning" class="alert alert-warning d-none mt-3" 
                                     style="background: rgba(255, 165, 0, 0.1); border: 1px solid #ffa500; color: #ffa500; border-radius: 10px; padding: 12px 15px; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span><strong>Note:</strong> A 20% deduction will be applied if you withdraw from your investment amount.</span>
                                </div>
                            </div>

                            <!-- Amount Input (Moved to Top) -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-coins"></i> Withdraw Amount
                                </label>
                                <div class="amount-input-group">
                                    <span class="currency-symbol">{{ $general->cur_sym }}</span>
                                    <input type="number" step="any" name="amount" class="form-control amount-input"
                                        value="{{ old('amount') }}" placeholder="0.00" required min="0"
                                        onkeypress="return (event.charCode != 45 && event.charCode != 43)"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    <div class="amount-presets">
                                        <button type="button" class="preset-btn" data-amount="10">$10</button>
                                        <button type="button" class="preset-btn" data-amount="50">$50</button>
                                        <button type="button" class="preset-btn" data-amount="100">$100</button>
                                        <button type="button" class="preset-btn" data-amount="500">$500</button>
                                    </div>
                                </div>
                                <div class="input-hint">Enter amount between
                                    {{ showAmount($withdrawMethod->min('min_limit')) }} -
                                    {{ showAmount($withdrawMethod->max('max_limit')) }}
                                </div>
                                <span id="withdrawBalanceError" class="text-danger small mt-2 d-none animate__animated animate__headShake" style="font-size: 12px; display: block;">
                                    <i class="fas fa-exclamation-triangle"></i> Insufficient Balance! Your Max Available: {{ $general->cur_sym }}<span id="maxAvailableBalanceDisplay">0.00</span>
                                </span>
                            </div>

                            <!-- Method Selection (Moved to Bottom) -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-credit-card"></i> Payment Method <span class="text-danger">*</span>
                                </label>
                                <div class="method-list">
                                    @foreach($withdrawMethod as $data)
                                        <div class="method-card-horizontal" data-method="{{ $data->id }}"
                                            data-resource="{{$data}}">
                                            <div class="m-icon">
                                                <i class="fas fa-credit-card"></i>
                                            </div>
                                            <div class="m-details">
                                                <h4>{{ __($data->name) }}</h4>
                                                <p class="m-fee">Fee: {{ showAmount($data->fixed_charge) }}
                                                    {{ $general->cur_text }} + {{ $data->percent_charge }}%
                                                </p>
                                                <p class="m-limits">Limits: {{ showAmount($data->min_limit) }} -
                                                    {{ showAmount($data->max_limit) }} {{ $general->cur_text }}
                                                </p>
                                            </div>
                                            <div class="m-select">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Live Summary Preview (Simplified to match style) -->
                            <div class="payment-preview d-none">
                                <div class="preview-header">
                                    <h4><i class="fas fa-receipt"></i> Payment Summary</h4>
                                </div>
                                <div class="preview-details">
                                    <div class="detail-row">
                                        <span>Withdraw Amount:</span>
                                        <span class="detail-amount">{{ $general->cur_sym }}<span
                                                class="req_amount">0.00</span></span>
                                    </div>
                                    <div class="detail-row">
                                        <span>Processing Fee:</span>
                                        <span class="detail-fee">{{ $general->cur_sym }}<span
                                                class="charge_val">0.00</span></span>
                                    </div>
                                    <div class="detail-row total">
                                        <span>Total Receivable:</span>
                                        <span class="detail-total">{{ $general->cur_sym }}<span
                                                class="receivable_val">0.00</span></span>
                                    </div>
                                    <div class="conversion-info d-none">
                                        <div class="detail-row">
                                            <span>Conversion Rate:</span>
                                            <span>1 {{ $general->cur_text }} = <span class="rate_val">0</span> <span
                                                    class="method_cur"></span></span>
                                        </div>
                                        <div class="detail-row">
                                            <span>You Will Get:</span>
                                            <span class="detail-crypto"><span class="final_val">0.00</span> <span
                                                    class="method_cur"></span></span>
                                        </div>
                                        <div class="crypto-note">
                                            <i class="fas fa-info-circle"></i>
                                            Conversion will be completed on next step
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="step1-error" class="alert alert-danger d-none mt-3"
                                style="background: rgba(255, 0, 0, 0.1); border: 1px solid var(--accent-red); color: white; border-radius: 10px; padding: 12px 15px; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-exclamation-circle"></i>
                                <span class="error-msg"></span>
                            </div>

                            <div class="btn-tooltip-wrapper">
                                <div class="tooltip-text">Please enter a valid amount within the range.</div>
                                <button type="submit" class="submit-btn-modern" id="submitBtnStep1" disabled>
                                    <span>Confirm & Continue</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Information Column -->
                    <div class="info-sidebar">
                        <div class="info-card">
                            <div class="card-header">
                                <h3><i class="fas fa-shield-alt"></i> Secure Withdrawals</h3>
                            </div>
                            <div class="card-body">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div class="info-content">
                                        <h4>Safe & Encrypted</h4>
                                        <p>Your withdrawal requests are protected by industry-standard encryption.</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="info-content">
                                        <h4>Verification Time</h4>
                                        <p>All payouts are manually verified by our team within 24 business hours.</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <div class="info-content">
                                        <h4>Fraud Protection</h4>
                                        <p>Our system monitors all activity to ensure funds reach the correct recipient.</p>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="info-content">
                                        <h4>Balance Check</h4>
                                        <p>Ensure you have sufficient balance after charges to complete the request.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Section (Exact as Deposit) -->
                            <div class="faq-section">
                                <h4><i class="fas fa-question-circle"></i> Withdrawal FAQ</h4>

                                <div class="faq-item">
                                    <div class="faq-question">
                                        <span>How long does it take?</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="faq-answer">
                                        <p>Most requests are verified within 24 hours. Processing time depends on your
                                            provider.</p>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <div class="faq-question">
                                        <span>Are there any fees?</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="faq-answer">
                                        <p>All fees are clearly shown in the summary. We have no hidden or surprise charges.
                                        </p>
                                    </div>
                                </div>

                                <div class="faq-item">
                                    <div class="faq-question">
                                        <span>Can I cancel a request?</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                    <div class="faq-answer">
                                        <p>Yes, you can cancel your request from the logs as long as it is in 'Pending'
                                            status.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 2: Verification Form -->
            <div id="step-2" class="withdraw-step-content" style="display:none;">
                <div class="withdraw-grid">
                    <div class="withdraw-form-card main-form-card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-check"></i> Verification Details</h3>
                            <div class="method-badge-selected">
                                <span id="selected-method-name"></span>
                            </div>
                        </div>

                        <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data"
                            id="withdrawVerificationForm" class="deposit-form">
                            @csrf
                            <div class="instruction-box-modern mt-3 mb-3 mx-3">
                                <div class="i-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="i-content">
                                    <h4>Important Instructions</h4>
                                    <p>Please enter your <strong>Wallet Address</strong> or <strong>Bank Details</strong>
                                        with extreme care. Double-check every character to ensure accuracy. We are not
                                        responsible for funds sent to an incorrect address provided by you.</p>
                                </div>
                            </div>

                            <div class="method-desc-box mb-2">
                                <div class="description-box">
                                    <div id="method-description-text"></div>
                                </div>
                            </div>

                            <div class="px-3">
                                <div id="dynamic-form-fields"></div>

                                @if(auth()->user()->ts)
                                    <div class="form-group mt-4">
                                        <label class="form-label">
                                            <i class="fas fa-key"></i> Google Authenticator Code
                                        </label>
                                        <div class="auth-input-wrapper">
                                            <input type="text" name="authenticator_code" class="form-control auth-input"
                                                placeholder="000000" required>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="btn-group-withdraw mt-4 px-3">
                                <button type="submit" class="submit-btn-modern" id="submitBtnStep2">
                                    <span>Submit Withdrawal</span>
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="info-sidebar">
                        <div class="info-card summary-highlight">
                            <div class="card-header">
                                <h3><i class="fas fa-file-invoice"></i> Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="summary-list-small">
                                    <div class="s-item">
                                        <span>Requested Amount:</span>
                                        <strong id="s-requested"></strong>
                                    </div>
                                    <div class="s-item">
                                        <span>Withdrawal Fee:</span>
                                        <strong class="text-danger" id="s-charge"></strong>
                                    </div>
                                    <div class="s-item s-conversion d-none">
                                        <span>Exchange Rate:</span>
                                        <strong id="s-rate"></strong>
                                    </div>
                                    <div class="s-item total">
                                        <span>Final Receivable:</span>
                                        <strong class="text-success" id="s-receivable"></strong>
                                    </div>
                                </div>

                                <div class="transaction-policy-box mt-4">
                                    <h4 class="policy-title"><i class="fas fa-list-check"></i> Transaction Policy</h4>
                                    <ul class="policy-list">
                                        <li><i class="fas fa-check-circle"></i> Manual Review (1-24h)</li>
                                        <li><i class="fas fa-check-circle"></i> No Third-Party Payouts</li>
                                        <li><i class="fas fa-check-circle"></i> Secure Node Processing</li>
                                    </ul>
                                </div>

                                <div class="security-badge-small mt-4">
                                    <div class="b-item">
                                        <i class="fas fa-shield-check"></i>
                                        <span>Verified Secure</span>
                                    </div>
                                    <div class="b-item">
                                        <i class="fas fa-headset"></i>
                                        <span>24/7 Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Success Confirmation -->
            <div id="step-3" class="withdraw-step-content" style="display:none; text-align:center; padding: 40px 20px;">
                <div
                    style="font-size: 60px; color: #2ecc71; margin-bottom: 20px; filter: drop-shadow(0 0 15px rgba(46, 204, 113, 0.4));">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 style="color: white; margin-bottom: 12px; font-size: 26px; font-weight: 700;">Withdrawal Request
                    Submitted!</h2>
                <p
                    style="color: var(--text-muted); font-size: 15px; margin: 0 auto 30px; max-width: 500px; line-height: 1.5;">
                    Your withdrawal request has been successfully received and is now in our verification queue. Our team
                    will review and process your payout within 24 business hours.</p>

                <div class="success-actions" style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('user.withdraw.history') }}" class="submit-btn-modern"
                        style="text-decoration:none; width: auto; min-width: 160px; font-size: 14px;">
                        View Withdrawal Logs
                    </a>
                    <a href="{{ route('user.home') }}" class="back-btn-modern"
                        style="text-decoration:none; width: auto; min-width: 160px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                        Dashboard
                    </a>
                </div>
            </div>

        </div>



        <!-- Hidden Form Templates -->
        <div id="withdraw-form-templates" style="display:none;">
            @foreach($withdrawMethod as $data)
                <div id="form-template-{{ $data->form_id }}">
                    <x-viser-form identifier="id" identifierValue="{{ $data->form_id }}" />
                </div>
            @endforeach
        </div>

    </div>

    <!-- Manage Wallets Modal (Moved outside withdraw-container to avoid z-index/backdrop issue) -->
    <div id="walletsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999 !important;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-white" style="background: #111111; border: 1px solid rgba(255, 0, 0, 0.2); border-radius: 20px; box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);">
                <div class="modal-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding: 20px 25px;">
                    <h5 class="modal-title" style="font-size: 18px; font-weight: 700; color: #fff;"><i class="fas fa-wallet text-danger" style="margin-right: 8px;"></i> Manage Saved Wallets</h5>
                    <button type="button" class="btn-close-custom" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <!-- Add New Wallet Form -->
                    <form id="addWalletForm" class="mb-4">
                        @csrf
                        <div class="max-wallets-limit-warning d-none alert alert-warning p-2 mb-3" style="background: rgba(243, 186, 47, 0.1); border: 1px solid rgba(243, 186, 47, 0.2); border-radius: 10px; color: #f3ba2f; font-size: 12px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>You have reached the maximum limit of 2 saved wallet addresses. Delete an address to save a new one.</span>
                        </div>
                        <h6 class="mb-3 text-danger" style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="fas fa-plus-circle mr-1"></i> Add New Wallet Address
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div style="position: relative; display: flex; align-items: center;">
                                    <i class="fas fa-tag" style="position: absolute; left: 12px; color: var(--light-red); font-size: 14px; pointer-events: none; z-index: 10;"></i>
                                    <input type="text" name="label" class="form-control text-white" placeholder="Label (e.g. Metamask)" required style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,0,0,0.2); border-radius: 10px; padding: 12px 12px 12px 35px; font-size: 14px; outline: none; width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="position: relative; display: flex; align-items: center;">
                                    <i class="fas fa-wallet" style="position: absolute; left: 12px; color: var(--light-red); font-size: 14px; pointer-events: none; z-index: 10;"></i>
                                    <input type="text" name="address" class="form-control text-white" placeholder="Wallet Address (BEP-20)" required style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,0,0,0.2); border-radius: 10px; padding: 12px 12px 12px 35px; font-size: 14px; outline: none; width: 100%;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="submit-btn-modern w-100" style="border-radius: 10px; background: var(--gradient-red); border: none; height: 100%; display: flex; align-items: center; justify-content: center; min-height: 45px; box-shadow: var(--shadow-red); font-weight: 700; color: #fff;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="d-flex align-items-center justify-content-between mb-3" style="margin-top: 25px;">
                        <h6 class="text-danger mb-0" style="font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="fas fa-history mr-1"></i> Your Saved Wallets
                        </h6>
                        <span class="badge-bep20">
                            <i class="fas fa-coins"></i> BEP-20 Network
                        </span>
                    </div>
                    <div class="wallets-list-container" style="max-height: 280px; overflow-y: auto; padding-right: 5px;">
                        <!-- List will load via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom AJAX Confirmation Modal -->
    <div id="deleteConfirmModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 9999999 !important;">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content delete-modal-content text-white">
                <div class="modal-body text-center p-4">
                    <div class="confirm-icon-wrapper mb-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 class="mb-2 text-white delete-modal-title">Are you sure?</h5>
                    <p class="text-muted mb-4 delete-modal-desc">Do you really want to delete this saved wallet address? This action cannot be undone.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-confirm-cancel px-4" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btnConfirmDeleteWallet" class="btn btn-confirm-delete px-4">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Wallet Confirmation Modal -->
    <div id="saveWalletConfirmModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 9999999 !important;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content delete-modal-content text-white">
                <div class="modal-body text-center p-4">
                    <div class="confirm-icon-wrapper mb-3" style="background: rgba(40, 167, 69, 0.1); border: 2px solid rgba(40, 167, 69, 0.25); color: #28a745; box-shadow: 0 0 15px rgba(40, 167, 69, 0.2); animation: none;">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h5 class="mb-2 text-white delete-modal-title">Save Wallet Address?</h5>
                    <p class="text-muted mb-3 delete-modal-desc" style="font-size: 13px; line-height: 1.5;">
                        Would you like to save this wallet address to your address book? Saving it means you won't have to enter this address manually for future withdrawals.
                    </p>
                    
                    <form id="quickSaveWalletForm" class="mb-3 text-start px-2">
                        @csrf
                        <div class="form-group mb-0">
                            <label class="form-label" style="font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Wallet Label / Name</label>
                            <div style="position: relative; display: flex; align-items: center;">
                                <i class="fas fa-tag" style="position: absolute; left: 12px; color: #ff3333; font-size: 14px; pointer-events: none; z-index: 10;"></i>
                                <input type="text" name="label" id="modalSaveLabel" class="form-control text-white" placeholder="e.g. My Metamask Wallet" value="My Wallet" required style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,0,0,0.2); border-radius: 10px; padding: 10px 10px 10px 35px; font-size: 13px; outline: none; width: 100%;">
                            </div>
                        </div>
                        <input type="hidden" name="address" id="modalSaveAddressValue">
                    </form>

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" id="btnSubmitWithoutSaving" class="btn btn-confirm-cancel px-3 py-2" style="font-size: 12px; font-weight: 600;">No, Just Submit</button>
                        <button type="button" id="btnSaveAndSubmit" class="btn btn-confirm-delete px-3 py-2" style="background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.35) !important; font-size: 12px; font-weight: 600;">Yes, Save & Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

        /* Saved Wallet Selection Cards (Step 2) */
        .wallet-option-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 8px;
        }

        .wallet-option-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .wallet-option-card:hover {
            border-color: rgba(243, 186, 47, 0.3) !important;
            background: rgba(243, 186, 47, 0.03) !important;
        }

        .wallet-option-card.selected {
            border-color: #f3ba2f !important;
            background: rgba(243, 186, 47, 0.08) !important;
            box-shadow: 0 0 15px rgba(243, 186, 47, 0.15) !important;
        }

        .wallet-option-card .wallet-option-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f3ba2f;
            font-size: 18px;
            transition: var(--transition);
            border: 1px solid rgba(243, 186, 47, 0.15);
        }

        .wallet-option-card.selected .wallet-option-icon {
            background: linear-gradient(135deg, rgba(243, 186, 47, 0.2) 0%, rgba(243, 186, 47, 0.05) 100%) !important;
            border-color: #f3ba2f !important;
        }

        .wallet-option-card .wallet-option-details {
            flex: 1;
            min-width: 0;
            text-align: left;
        }

        .wallet-option-card .wallet-option-details h4 {
            font-size: 14px;
            color: white;
            margin: 0 0 4px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wallet-option-card .wallet-option-details p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
            font-family: monospace;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .wallet-option-card .wallet-option-select {
            color: #f3ba2f;
            font-size: 18px;
            opacity: 0;
            transform: scale(0.5);
            transition: var(--transition);
        }

        .wallet-option-card.selected .wallet-option-select {
            opacity: 1;
            transform: scale(1);
        }

        .no-wallet-option-card {
            border: 1px dashed rgba(255, 255, 255, 0.15) !important;
            background: rgba(255, 255, 255, 0.01) !important;
            justify-content: center !important;
            padding: 20px !important;
        }
        
        .no-wallet-option-card:hover {
            border-color: var(--accent-red) !important;
            background: rgba(255, 0, 0, 0.02) !important;
        }

        /* Custom Delete Confirmation Modal Styles */
        #deleteConfirmModal {
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        #deleteConfirmModal.modal.fade .modal-dialog {
            transform: scale(0.85) translateY(10px) !important;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        #deleteConfirmModal.modal.show .modal-dialog {
            transform: scale(1) translateY(0) !important;
            opacity: 1;
        }

        .delete-modal-content {
            background: #0f0f0f !important;
            border: 1px solid rgba(255, 0, 0, 0.25) !important;
            border-radius: 20px !important;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.2), 0 0 100px rgba(255, 0, 0, 0.05) !important;
            overflow: hidden;
        }

        .confirm-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(234, 84, 85, 0.1);
            border: 2px solid rgba(234, 84, 85, 0.25);
            font-size: 30px;
            color: #ea5455;
            box-shadow: 0 0 15px rgba(234, 84, 85, 0.2);
            animation: warning-pulse 2s infinite ease-in-out;
        }

        @keyframes warning-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(234, 84, 85, 0.4);
            }
            70% {
                box-shadow: 0 0 0 12px rgba(234, 84, 85, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(234, 84, 85, 0);
            }
        }

        .delete-modal-title {
            font-weight: 700 !important;
            font-size: 18px !important;
            letter-spacing: 0.5px !important;
            margin-top: 10px !important;
        }

        .delete-modal-desc {
            font-size: 13px !important;
            line-height: 1.6 !important;
            font-weight: 400 !important;
            padding: 0 10px !important;
            color: #999999 !important;
        }

        .btn-confirm-cancel {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #e0e0e0 !important;
            padding: 9px 22px !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer;
        }

        .btn-confirm-cancel:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }

        .btn-confirm-delete {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.35) !important;
            color: #fff !important;
            padding: 9px 22px !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer;
        }

        .btn-confirm-delete:hover {
            background: linear-gradient(135deg, #a30000 0%, #ff1a1a 100%) !important;
            box-shadow: 0 6px 20px rgba(255, 0, 0, 0.5) !important;
            color: #fff !important;
            transform: translateY(-1px);
        }

        body {
            background-color: var(--dark-black);
            color: var(--text-white);
        }

        /* Custom Modal and Saved Wallet Cards */
        .btn-close-custom {
            background: rgba(234, 84, 85, 0.1) !important;
            border: 1px solid rgba(234, 84, 85, 0.2) !important;
            color: #ea5455 !important;
            font-size: 16px !important;
            cursor: pointer !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
        }

        .btn-close-custom:hover {
            background: #ea5455 !important;
            color: #ffffff !important;
            box-shadow: 0 0 12px rgba(234, 84, 85, 0.5) !important;
            transform: rotate(90deg) !important;
        }

        .saved-wallet-card {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 12px !important;
            padding: 12px 15px !important;
            margin-bottom: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 15px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .saved-wallet-card:hover {
            background: rgba(255, 255, 255, 0.04) !important;
            border-color: rgba(243, 186, 47, 0.2) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
            transform: translateY(-2px) !important;
        }

        .active-wallet-card {
            background: rgba(40, 167, 69, 0.04) !important;
            border-color: rgba(40, 167, 69, 0.3) !important;
        }

        .active-wallet-card:hover {
            background: rgba(40, 167, 69, 0.07) !important;
            border-color: rgba(40, 167, 69, 0.5) !important;
        }

        .active-avatar {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(40, 167, 69, 0.05) 100%) !important;
            border-color: rgba(40, 167, 69, 0.4) !important;
            color: #28a745 !important;
        }

        .active-avatar i {
            filter: drop-shadow(0 0 3px rgba(40, 167, 69, 0.4)) !important;
        }

        .badge-selected {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.05) 100%) !important;
            border: 1px solid rgba(40, 167, 69, 0.3) !important;
            color: #28a745 !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            padding: 2px 8px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.1) !important;
        }

        .badge-selected i {
            font-size: 9px !important;
        }

        .wallet-card-left {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            min-width: 0 !important;
            flex: 1 !important;
        }

        .wallet-icon-avatar {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, rgba(243, 186, 47, 0.2) 0%, rgba(243, 186, 47, 0.05) 100%) !important;
            border: 1px solid rgba(243, 186, 47, 0.3) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #f3ba2f !important;
            flex-shrink: 0 !important;
        }

        .wallet-icon-avatar i {
            font-size: 16px !important;
            filter: drop-shadow(0 0 3px rgba(243, 186, 47, 0.4)) !important;
        }

        .wallet-info-content {
            min-width: 0 !important;
            flex: 1 !important;
        }

        .wallet-title-row {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin-bottom: 2px !important;
        }

        .wallet-label-text {
            font-weight: 700 !important;
            color: #fff !important;
            font-size: 14px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .badge-bep20 {
            background: linear-gradient(135deg, rgba(243, 186, 47, 0.15) 0%, rgba(243, 186, 47, 0.05) 100%) !important;
            border: 1px solid rgba(243, 186, 47, 0.3) !important;
            color: #f3ba2f !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            padding: 2px 8px !important;
            border-radius: 20px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 0 10px rgba(243, 186, 47, 0.1) !important;
        }

        .badge-bep20 i {
            font-size: 9px !important;
        }

        .wallet-address-display {
            font-size: 12px !important;
            color: var(--text-muted) !important;
            font-family: monospace !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            max-width: 100% !important;
            background: rgba(255, 255, 255, 0.02) !important;
            padding: 5px 12px !important;
            border-radius: 8px !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        .wallet-address-display:hover {
            color: #f3ba2f !important;
            border-color: rgba(243, 186, 47, 0.2) !important;
            background: rgba(243, 186, 47, 0.03) !important;
        }

        .wallet-address-display .address-text {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .wallet-address-display .copy-icon {
            font-size: 11px !important;
            opacity: 0.5 !important;
            transition: all 0.2s ease !important;
        }

        .wallet-address-display:hover .copy-icon {
            opacity: 1 !important;
            transform: scale(1.1) !important;
        }

        .wallet-card-actions {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            flex-shrink: 0 !important;
        }

        .btn-copy-address {
            height: 36px !important;
            padding: 0 16px !important;
            border-radius: 10px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            color: var(--text-muted) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
        }

        .btn-copy-address:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-delete-wallet {
            height: 36px !important;
            padding: 0 16px !important;
            border-radius: 10px !important;
            border: 1px solid rgba(234, 84, 85, 0.2) !important;
            background: rgba(234, 84, 85, 0.05) !important;
            color: #ea5455 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
        }

        .btn-delete-wallet:hover {
            background: #ea5455 !important;
            color: #fff !important;
            border-color: #ea5455 !important;
            box-shadow: 0 0 10px rgba(234, 84, 85, 0.4) !important;
        }

        @media (max-width: 768px) {
            .saved-wallet-card {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 15px !important;
                padding: 15px !important;
            }
            .wallet-card-left {
                width: 100% !important;
            }
            .wallet-title-row {
                flex-wrap: wrap !important;
                gap: 8px !important;
            }
            .wallet-address-display {
                width: 100% !important;
                justify-content: space-between !important;
            }
            .wallet-address-display .address-text {
                max-width: calc(100vw - 165px) !important;
            }
            .wallet-card-actions {
                width: 100% !important;
                display: flex !important;
                gap: 10px !important;
                border-top: 1px dashed rgba(255, 255, 255, 0.08) !important;
                padding-top: 12px !important;
            }
            .btn-copy-address, .btn-delete-wallet {
                flex: 1 !important;
                justify-content: center !important;
            }
        }

        #addWalletForm input {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 0, 0, 0.2) !important;
            border-radius: 10px !important;
            color: #fff !important;
            padding: 12px 12px 12px 35px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        #addWalletForm input:focus {
            border-color: rgba(243, 186, 47, 0.5) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 0 10px rgba(243, 186, 47, 0.15) !important;
        }

        #addWalletForm button[type="submit"] {
            border-radius: 10px !important;
            background: var(--gradient-red) !important;
            border: none !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 45px !important;
            box-shadow: var(--shadow-red) !important;
            font-weight: 700 !important;
            color: #fff !important;
            transition: all 0.3s ease !important;
        }

        #addWalletForm button[type="submit"]:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.5) !important;
        }

        /* Withdrawal Type List */
        .withdrawal-type-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 5px;
        }

        .type-card {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .type-card:hover {
            border-color: var(--border-red);
            background: rgba(255, 0, 0, 0.05);
        }

        .type-card.selected {
            border-color: var(--accent-red);
            background: rgba(255, 0, 0, 0.1);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
        }

        .type-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-red);
            font-size: 18px;
            transition: var(--transition);
        }

        .type-card.selected .type-icon {
            background: var(--gradient-red);
            color: white;
        }

        .type-details {
            flex: 1;
        }

        .type-details h4 {
            font-size: 14px;
            color: white;
            margin: 0 0 2px;
            font-weight: 700;
        }

        .type-details p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 2px;
        }

        .type-details p span {
            font-weight: 700;
        }

        .type-select {
            color: var(--accent-red);
            font-size: 18px;
            opacity: 0;
            transform: scale(0.5);
            transition: var(--transition);
        }

        .type-card.selected .type-select {
            opacity: 1;
            transform: scale(1);
        }

        .withdraw-container {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            padding-bottom: 50px;
        }

        /* Background */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            z-index: -2;
        }

        /* Progress Bar (Exact as Deposit) */
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

        /* Layout Cards */
        .withdraw-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
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

        .withdraw-form {
            padding: 25px;
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

        .amount-input.is-invalid-modern {
            border-color: var(--accent-red) !important;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.3) !important;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Tooltip for disabled button */
        .btn-tooltip-wrapper {
            position: relative;
            width: 100%;
        }

        .btn-tooltip-wrapper .tooltip-text {
            visibility: hidden;
            width: 260px;
            background: #1a1a1a;
            color: #ff3333;
            text-align: center;
            border-radius: 8px;
            padding: 10px 15px;
            position: absolute;
            z-index: 100;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: all 0.3s ease;
            font-size: 13px;
            pointer-events: none;
            border: 1px solid var(--border-red);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            font-weight: 500;
            line-height: 1.4;
        }

        .btn-tooltip-wrapper .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #1a1a1a transparent transparent transparent;
        }

        .btn-tooltip-wrapper:hover .tooltip-text.show {
            visibility: visible;
            opacity: 1;
            bottom: 130%;
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

        .preset-btn:hover,
        .preset-btn.active {
            border-color: var(--accent-red);
            color: white;
            background: rgba(255, 0, 0, 0.1);
        }

        .input-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        /* Horizontal Method List (Exactly as Deposit) */
        .method-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .method-card-horizontal {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 18px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
        }

        .method-card-horizontal:hover {
            border-color: var(--border-red);
            background: rgba(255, 0, 0, 0.05);
        }

        .method-card-horizontal.selected {
            border-color: var(--accent-red);
            background: rgba(255, 0, 0, 0.1);
        }

        .m-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-red);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .m-details {
            flex: 1;
        }

        .m-details h4 {
            font-size: 15px;
            color: white;
            margin: 0 0 4px;
            font-weight: 700;
        }

        .m-details p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 1px 0;
        }

        .m-select {
            color: var(--accent-red);
            font-size: 22px;
            opacity: 0;
            transform: scale(0.5);
            transition: var(--transition);
        }

        .method-card-horizontal.selected .m-select {
            opacity: 1;
            transform: scale(1);
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
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 15px;
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

        .detail-amount,
        .detail-fee {
            color: var(--text-white);
            font-weight: 600;
            font-size: 16px;
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

        /* Modern Buttons */
        .submit-btn-modern {
            width: 100%;
            background: var(--gradient-red);
            border: none;
            border-radius: 12px;
            padding: 18px;
            color: white;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.4);
        }

        .submit-btn-modern:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 0, 0, 0.6);
        }

        .submit-btn-modern:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .back-btn-modern {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            transition: var(--transition);
        }

        .back-btn-modern:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Instruction Box Step 2 */
        .instruction-box-modern {
            background: rgba(255, 193, 7, 0.05);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffc107;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .i-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #ffc107;
            flex-shrink: 0;
        }

        .i-content h4 {
            color: #ffc107;
            font-size: 16px;
            margin: 0 0 5px;
            font-weight: 700;
        }

        .i-content p {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0;
            line-height: 1.5;
        }

        .i-content strong {
            color: var(--text-white);
        }

        .security-badge-small {
            background: rgba(17, 17, 17, 0.5);
            border: 1px solid var(--border-red);
            padding: 12px;
            border-radius: 12px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .security-badge-small .b-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            color: var(--text-white);
            font-size: 11px;
            font-weight: 600;
        }

        .security-badge-small .b-item i {
            font-size: 18px;
            color: var(--light-red);
        }

        .transaction-policy-box {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 15px;
            border: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .policy-title {
            color: var(--light-red);
            font-size: 14px;
            margin: 0 0 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .policy-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .policy-list li {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .policy-list li i {
            color: #2ecc71;
            font-size: 10px;
        }

        .method-desc-box:empty,
        .method-desc-box div:empty {
            display: none;
        }

        .description-box:empty {
            display: none;
        }

        /* Success Card */
        .success-card-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .success-card {
            background: rgba(17, 17, 17, 0.9);
            border: 1px solid var(--border-red);
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            max-width: 550px;
            box-shadow: var(--shadow-red);
        }

        .success-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 25px;
            filter: drop-shadow(0 0 15px rgba(46, 204, 113, 0.4));
        }

        .success-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .action-btn {
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
        }

        .action-btn.logs {
            background: var(--gradient-red);
            color: white;
        }

        .action-btn.dash {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Info Sidebar (Same as Deposit) */
        .info-card {
            background: rgba(17, 17, 17, 0.8);
            border: 1px solid var(--border-red);
            border-radius: 15px;
            margin-bottom: 25px;
            overflow: hidden;
        }

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

        /* FAQ Section (Exact as Deposit) */
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
            color: var(--text-white);
            font-size: 15px;
            font-weight: 500;
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

        /* Viser Form Fields Styling */
        #dynamic-form-fields .form-group {
            margin-bottom: 20px;
        }

        #dynamic-form-fields label {
            color: white;
            margin-bottom: 8px;
            display: block;
            font-weight: 500;
        }

        #dynamic-form-fields input,
        #dynamic-form-fields select,
        #dynamic-form-fields textarea {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-red) !important;
            color: white !important;
            border-radius: 10px !important;
            padding: 12px 15px !important;
            width: 100%;
            transition: var(--transition);
        }

        #dynamic-form-fields input:focus {
            border-color: var(--light-red) !important;
        }



        /* Responsive Design */
        @media (max-width: 1200px) {
            .withdraw-container {
                margin-left: 280px;
                padding: 20px;
            }

            .withdraw-grid {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 1024px) {
            .withdraw-container {
                margin-left: 0;
                padding: 60px 15px 100px;
            }
        }

        @media screen and (max-width: 768px) {
            .progress-steps {
                margin-bottom: 25px;
            }

            .step-number {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .step-label {
                font-size: 12px;
            }

            .step::before {
                top: 16px;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .method-card-horizontal {
                padding: 12px 15px;
            }

            .instruction-box-modern {
                padding: 15px;
                gap: 15px;
                flex-direction: column;
                text-align: center;
            }

            .i-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }

        @media screen and (max-width: 480px) {
            .step-number {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .step-label {
                font-size: 10px;
            }

            .step::before {
                top: 12px;
                left: 63%;
                right: -38%;
            }

            .amount-input {
                font-size: 18px !important;
            }

            .withdraw-form {
                padding: 15px;
            }

            .withdrawal-type-list {
                flex-direction: column;
                gap: 10px;
            }

            .type-card {
                padding: 12px;
            }

            .type-icon {
                width: 35px;
                height: 35px;
                font-size: 16px;
            }

            .type-details h4 {
                font-size: 13px;
            }

            .type-details p {
                font-size: 12px;
            }

            /* Presets 2-column */
            .amount-presets {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .preset-btn {
                width: 100%;
                margin: 0;
                padding: 12px;
                font-size: 14px;
            }

            /* Method Cards Vertical Style */
            .method-list {
                gap: 12px;
            }

            .method-card-horizontal {
                flex-direction: column;
                text-align: center;
                padding: 15px;
                gap: 10px;
            }

            .method-card-horizontal .m-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
                margin: 0 auto;
            }

            .method-card-horizontal .m-details h4 {
                font-size: 15px;
                margin-bottom: 4px;
            }

            .method-card-horizontal .m-limits {
                font-size: 11px;
                line-height: 1.5;
            }

            .method-card-horizontal .m-select {
                position: relative;
                right: auto;
                top: auto;
                margin-top: 5px;
                opacity: 1;
                transform: scale(0.9);
            }

            .method-card-horizontal:not(.selected) .m-select {
                opacity: 0.1;
            }
        }
    </style>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";
 
            let userBalance = {{ auth()->user()->balance }};
            let investBalance = {{ $totalInvestment }};

            // Withdrawal Type Selection
            $('.type-card').on('click', function () {
                $('.type-card').removeClass('selected');
                $(this).addClass('selected');
                const type = $(this).data('type');
                $('input[name=withdrawal_type]').val(type);
                
                if(type == 2) {
                    $('#investment-warning').removeClass('d-none');
                } else {
                    $('#investment-warning').addClass('d-none');
                }
                updateCalculations();
            });

            // Method Selection (Horizontal)
            $('.method-card-horizontal').on('click', function () {
                $('.method-card-horizontal').removeClass('selected');
                $(this).addClass('selected');

                const methodId = $(this).data('method');
                $('input[name=method_code]').val(methodId);

                updateCalculations();
            });

            // Preset Amount Buttons
            $('.preset-btn').on('click', function () {
                $('.preset-btn').removeClass('active');
                $(this).addClass('active');
                const amount = $(this).data('amount');
                $('.amount-input').val(amount).trigger('input');
            });

            // Amount Input
            $('.amount-input').on('input', function () {
                $('#step1-error').addClass('d-none');
                $(this).removeClass('is-invalid-modern');
                updateCalculations();
            });

            function updateCalculations() {
                let selectedMethod = $('.method-card-horizontal.selected');
                const amount = parseFloat($('.amount-input').val());

                // Auto-select first method if amount is entered and nothing is selected
                if (!selectedMethod.length && amount > 0) {
                    $('.method-card-horizontal:first').trigger('click');
                    selectedMethod = $('.method-card-horizontal.selected');
                }

                if (!selectedMethod.length || isNaN(amount) || amount <= 0) {
                    $('.payment-preview').addClass('d-none');
                    $('#submitBtnStep1').prop('disabled', true);
                    return;
                }

                const resource = selectedMethod.data('resource');
                const fixed_charge = parseFloat(resource.fixed_charge);
                const percent_charge = parseFloat(resource.percent_charge);
                const investment_charge = parseFloat(resource.investment_charge || 20);
                const rate = parseFloat(resource.rate);
                const min_limit = parseFloat(resource.min_limit);
                const max_limit = parseFloat(resource.max_limit);
                const type = $('input[name=withdrawal_type]').val();
                
                // Balance Check
                let currentWalletBalance = (type == 1) ? userBalance : investBalance;
                $('#maxAvailableBalanceDisplay').text(currentWalletBalance.toFixed(2));

                if (amount > currentWalletBalance) {
                    $('#withdrawBalanceError').removeClass('d-none');
                    $('.amount-input').addClass('is-invalid-modern');
                    $('#submitBtnStep1').prop('disabled', true);
                    $('.payment-preview').addClass('d-none');
                    $('.tooltip-text').removeClass('show'); // Hide range tooltip if balance is insufficient
                    return;
                } else {
                    $('#withdrawBalanceError').addClass('d-none');
                    $('.amount-input').removeClass('is-invalid-modern');
                }

                $('.payment-preview').removeClass('d-none');
                $('.req_amount').text(amount.toFixed(2));
                
                let charge = (fixed_charge + (amount * percent_charge / 100));
                
                // Add deduction for investment type
                if(type == 2) {
                    const investDeduction = amount * (investment_charge / 100);
                    charge += investDeduction;
                    $('#investment-warning span').html(`<strong>Note:</strong> A ${investment_charge}% deduction will be applied if you withdraw from your investment amount.`);
                }
                
                charge = charge.toFixed(2);
                $('.charge_val').text(charge);
                const receivable = (amount - parseFloat(charge)).toFixed(2);
                $('.receivable_val').text(receivable);

                if (resource.currency != '{{ __($general->cur_text) }}') {
                    $('.conversion-info').removeClass('d-none');
                    $('.rate_val').text(rate);
                    $('.method_cur').text(resource.currency);
                    const final_val = (receivable * rate).toFixed(2);
                    $('.final_val').text(final_val);
                } else {
                    $('.conversion-info').addClass('d-none');
                }

                // Method Range Check
                if (amount >= min_limit && amount <= max_limit) {
                    $('#submitBtnStep1').prop('disabled', false);
                    $('.tooltip-text').removeClass('show');
                } else {
                    $('#submitBtnStep1').prop('disabled', true);
                    let msg = amount < min_limit ? `Minimum: ${min_limit} ${resource.currency}` : `Maximum: ${max_limit} ${resource.currency}`;
                    $('.tooltip-text').addClass('show').html(`<i class="fas fa-info-circle"></i> ${msg}<br><small>The entered amount is outside the permitted withdrawal range.</small>`);
                }
            }

            // Step 1 Submission
            $('#withdrawMethodForm').on('submit', function (e) {
                e.preventDefault();
                const btn = $('#submitBtnStep1');
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            const withdraw = response.withdraw;
                            $('#selected-method-name').text(response.method_name);
                            $('#method-description-text').html(response.gateway_description);
                            $('#s-requested').text(parseFloat(withdraw.amount).toFixed(2) + ' {{ $general->cur_text }}');
                            $('#s-charge').text('- ' + parseFloat(withdraw.charge).toFixed(2) + ' {{ $general->cur_text }}');

                            if (parseFloat(withdraw.rate) != 1) {
                                $('.s-conversion').removeClass('d-none');
                                $('#s-rate').text('1 {{ $general->cur_text }} = ' + parseFloat(withdraw.rate).toFixed(2) + ' ' + withdraw.currency);
                                $('#s-receivable').text(parseFloat(withdraw.final_amount).toFixed(2) + ' ' + withdraw.currency);
                            } else {
                                $('.s-conversion').addClass('d-none');
                                $('#s-receivable').text(parseFloat(withdraw.after_charge).toFixed(2) + ' {{ $general->cur_text }}');
                            }
                            const formHtml = $('#form-template-' + response.form_id).html();
                            $('#dynamic-form-fields').html(formHtml);

                            // Setup dynamic wallet address dropdown replacement
                            setupWalletSelector();

                            $('#step-1').hide();
                            $('#step-2').fadeIn();
                            $('.step[data-step="1"]').addClass('completed').removeClass('active');
                            $('.step[data-step="2"]').addClass('active');
                        } else {
                            $('#step1-error').removeClass('d-none').find('.error-msg').text(response.message || 'Validation failed');
                            $('.amount-input').addClass('is-invalid-modern');
                            notify('error', response.message || 'Validation failed');
                        }
                        btn.prop('disabled', false).html(originalHtml);
                    },
                    error: function () {
                        notify('error', 'Network error, please try again.');
                        btn.prop('disabled', false).html(originalHtml);
                    }
                });
            });

            // Function to submit verification form directly
            function submitVerificationForm(successCb, errorCb) {
                const form = $('#withdrawVerificationForm');
                const btn = $('#submitBtnStep2');
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: new FormData(form[0]),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        btn.prop('disabled', false).html(originalHtml);
                        if (response.success) {
                            if (typeof successCb === 'function') {
                                successCb(response);
                            } else {
                                $('#step-2').hide();
                                $('#step-3').fadeIn();
                                $('.step[data-step="2"]').addClass('completed').removeClass('active');
                                $('.step[data-step="3"]').addClass('active').addClass('completed');
                            }
                        } else {
                            if (typeof errorCb === 'function') {
                                errorCb(response.message || 'Submission failed');
                            } else {
                                notify('error', response.message || 'Submission failed');
                            }
                        }
                    },
                    error: function () {
                        btn.prop('disabled', false).html(originalHtml);
                        if (typeof errorCb === 'function') {
                            errorCb('Error submitting verification');
                        } else {
                            notify('error', 'Error submitting verification');
                        }
                    }
                });
            }

            // Step 2 Submission
            $('#withdrawVerificationForm').on('submit', function (e) {
                e.preventDefault();

                // Check if manual wallet input is active, visible and has a value
                const manualWrapper = $('.manual-wallet-input-wrapper');
                const manualInput = $('#manualWalletAddress');
                const manualVal = (manualInput.length && manualInput.val()) ? manualInput.val().trim() : '';
                
                if (manualWrapper.length && !manualWrapper.hasClass('d-none') && manualVal !== '') {
                    $('#modalSaveAddressValue').val(manualVal);
                    
                    // Show our custom save confirmation modal
                    toggleModal('#saveWalletConfirmModal', 'show');
                    return; // Stop standard submission for now
                }

                // Otherwise, proceed to standard submission
                submitVerificationForm();
            });

            $('#backToStep1').on('click', function () {
                $('#step-2').hide();
                $('#step-1').fadeIn();
                $('.step[data-step="2"]').removeClass('active');
                $('.step[data-step="1"]').addClass('active').removeClass('completed');
            });

            // FAQ Toggle
            $(document).on('click', '.faq-question', function () {
                $(this).closest('.faq-item').toggleClass('active');
            });

            // Auto-select on page load
            $(document).ready(function () {
                if ($('.method-card-horizontal').length > 0) {
                    $('.method-card-horizontal:first').trigger('click');
                }
            });

            // --- Saved Wallets Integration in Verification Details ---
            let walletInput = null;
            let dynamicWalletInputName = '';
            let walletInputIsRequired = false;

            // Dynamic path resolver for subdirectory installs on localhost
            function getAppUrl(path) {
                let currentPath = window.location.pathname;
                let routeSuffixes = [
                    "/user/withdraw/wallets/manage",
                    "/user/withdraw/wallets/list",
                    "/user/withdraw/wallets",
                    "/user/withdraw/preview",
                    "/user/withdraw"
                ];
                let basePath = "";
                for (let i = 0; i < routeSuffixes.length; i++) {
                    let suffix = routeSuffixes[i];
                    let index = currentPath.toLowerCase().indexOf(suffix.toLowerCase());
                    if (index !== -1) {
                        basePath = currentPath.substring(0, index);
                        break;
                    }
                }
                if (basePath === "" && currentPath.toLowerCase().indexOf("/user/") !== -1) {
                    basePath = currentPath.substring(0, currentPath.toLowerCase().indexOf("/user/"));
                }
                return basePath + path;
            }

            function setupWalletSelector() {
                // Find any wallet address or address input/textarea field in the dynamic form programmatically
                walletInput = $('#withdrawVerificationForm input, #withdrawVerificationForm textarea').filter(function() {
                    const name = ($(this).attr('name') || '').toLowerCase();
                    if (name === '_token' || name === 'authenticator_code') return false;
                    return name.indexOf('address') !== -1 || name.indexOf('wallet') !== -1 || name.indexOf('your_wallet') !== -1;
                }).first();

                // Fallback: if no keyword match, take the first visible text/textarea field in the form (excluding authenticator and token)
                if (!walletInput.length) {
                    walletInput = $('#withdrawVerificationForm input:not([type="hidden"]):not([type="submit"]):not([name="authenticator_code"]):not([name="_token"]), #withdrawVerificationForm textarea').first();
                }
                
                if (walletInput.length) {
                    dynamicWalletInputName = walletInput.attr('name');
                    walletInputIsRequired = walletInput.prop('required');
                    const isRequiredAttr = walletInputIsRequired ? 'required' : '';

                    // Build a card selection list instead of a select element
                    let selectHtml = `
                        <div class="wallet-select-wrapper mt-2">
                            <!-- Hidden input for selected saved wallet address -->
                            <input type="hidden" name="${dynamicWalletInputName}" id="selectedWalletAddress" ${isRequiredAttr} value="">
                            
                            <!-- Manual Wallet Address Input (shown when no saved wallets) -->
                            <div class="manual-wallet-input-wrapper d-none">
                                <div style="position: relative; display: flex; align-items: center; width: 100%;">
                                    <i class="fas fa-wallet" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--light-red); font-size: 16px; pointer-events: none; z-index: 10;"></i>
                                    <input type="text" id="manualWalletAddress" class="form-control text-white" placeholder="Enter Wallet Address (BEP-20)" style="padding-left: 45px !important;">
                                </div>
                            </div>

                            <div class="wallet-option-list">
                                <!-- Will load dynamically via loadWalletsSelect() -->
                            </div>
                            
                            <div class="wallet-helper-row d-flex justify-content-between align-items-center mt-2 px-1">
                                <span class="text-muted" style="font-size: 12px;"><i class="fas fa-info-circle"></i> Quick-select a saved address (Max 2)</span>
                                <a href="javascript:void(0)" id="btnManageWallets" class="text-danger" style="font-size: 13px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 5px; transition: var(--transition);">
                                    <i class="fas fa-address-book"></i> Address Book
                                </a>
                            </div>
                        </div>
                    `;

                    // Replace the original input with the custom card selector
                    walletInput.replaceWith(selectHtml);
                    
                    // Update walletInput reference to point to our newly created hidden input
                    walletInput = $(`#selectedWalletAddress`);

                    // Initial loading of wallets into the card list
                    loadWalletsSelect();
                }
            }

            // Function to fetch and display saved wallets as cards
            function loadWalletsSelect(setAddress = '') {
                const hiddenInput = $('#selectedWalletAddress');
                if (!hiddenInput.length) return;
                
                $.get(getAppUrl("/user/withdraw/wallets"), function(response) {
                    if (response.success) {
                        const listContainer = $('.wallet-option-list');
                        const manualWrapper = $('.manual-wallet-input-wrapper');
                        const manualInput = $('#manualWalletAddress');
                        const helperRow = $('.wallet-helper-row');
                        
                        let currentVal = setAddress || hiddenInput.val();
                        
                        if (response.wallets.length > 0) {
                            // We have saved wallets!
                            manualWrapper.addClass('d-none');
                            manualInput.removeAttr('name').removeAttr('required').val('');
                            
                            hiddenInput.attr('name', dynamicWalletInputName);
                            if (walletInputIsRequired) {
                                hiddenInput.attr('required', 'required');
                            }
                            
                            listContainer.removeClass('d-none');
                            helperRow.removeClass('d-none');
                            
                            // If no value is selected yet and there are saved wallets, auto-select the first one
                            if (!currentVal) {
                                currentVal = response.wallets[0].address;
                            }
                            hiddenInput.val(currentVal).trigger('change');

                            let html = '';
                            response.wallets.forEach(function(wallet) {
                                const isSelected = (wallet.address === currentVal);
                                html += `
                                    <div class="wallet-option-card ${isSelected ? 'selected' : ''}" data-address="${wallet.address}">
                                        <div class="wallet-option-icon">
                                            <i class="fas ${isSelected ? 'fa-check' : 'fa-wallet'}"></i>
                                        </div>
                                        <div class="wallet-option-details">
                                            <h4>
                                                ${wallet.label}
                                                <span class="badge-bep20-page" style="margin-left: 5px; font-size: 9px; padding: 1px 6px; background: linear-gradient(135deg, rgba(243, 186, 47, 0.15) 0%, rgba(243, 186, 47, 0.05) 100%) !important; border: 1px solid rgba(243, 186, 47, 0.3) !important; color: #f3ba2f !important; font-weight: 700; border-radius: 20px; letter-spacing: 0.5px;">BEP-20</span>
                                            </h4>
                                            <p>${wallet.address}</p>
                                        </div>
                                        <div class="wallet-option-select">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                `;
                            });
                            listContainer.html(html);
                        } else {
                            // NO saved wallets!
                            listContainer.addClass('d-none').html('');
                            helperRow.addClass('d-none');
                            
                            hiddenInput.removeAttr('name').removeAttr('required').val('');
                            
                            manualInput.attr('name', dynamicWalletInputName);
                            if (walletInputIsRequired) {
                                manualInput.attr('required', 'required');
                            }
                            manualWrapper.removeClass('d-none');
                        }
                        
                        // Show warning or limit helper on modal if user has reached max limit
                        if (response.wallets.length >= 2) {
                            $('.max-wallets-limit-warning').removeClass('d-none');
                            $('#addWalletForm button[type="submit"]').prop('disabled', true).html('<i class="fas fa-ban"></i> Max Saved');
                            $('#addWalletForm input[name="label"], #addWalletForm input[name="address"]').prop('disabled', true);
                        } else {
                            $('.max-wallets-limit-warning').addClass('d-none');
                            $('#addWalletForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-plus"></i>');
                            $('#addWalletForm input[name="label"], #addWalletForm input[name="address"]').prop('disabled', false);
                        }

                        // Also update the manage modal list
                        updateManageModalList(response.wallets);
                    }
                });
            }

            // Function to update the management list inside the modal
            function updateManageModalList(wallets) {
                let html = '';
                const currentSelectedAddress = walletInput ? walletInput.val() : '';
                
                if (wallets.length > 0) {
                    wallets.forEach(function(wallet) {
                        const isCurrent = (wallet.address === currentSelectedAddress);
                        html += `
                            <div class="saved-wallet-card select-wallet-row ${isCurrent ? 'active-wallet-card' : ''}" data-address="${wallet.address}" title="${isCurrent ? 'Currently Selected' : 'Click to select this address'}">
                                <div class="wallet-card-left">
                                    <div class="wallet-icon-avatar ${isCurrent ? 'active-avatar' : ''}">
                                        <i class="fas ${isCurrent ? 'fa-check' : 'fa-coins'}"></i>
                                    </div>
                                    <div class="wallet-info-content">
                                        <div class="wallet-title-row">
                                            <span class="wallet-label-text">${wallet.label}</span>
                                            ${isCurrent ? `
                                                <span class="badge-selected">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            ` : `
                                                <span class="badge-bep20">
                                                    <i class="fas fa-link"></i> BEP-20
                                                </span>
                                            `}
                                        </div>
                                        <div class="wallet-address-display" title="Click to copy" data-address="${wallet.address}">
                                            <span class="address-text">${wallet.address}</span>
                                            <i class="far fa-copy copy-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="wallet-card-actions">
                                    <button type="button" class="btn-copy-address" title="Copy Address" data-address="${wallet.address}">
                                        <i class="far fa-copy"></i> Copy
                                    </button>
                                    <button type="button" class="btn-delete-wallet" title="Delete Saved Wallet" data-id="${wallet.id}">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = `
                        <div class="text-center py-5 text-muted" style="background: rgba(255,255,255,0.01); border: 1px dashed rgba(255,255,255,0.05); border-radius: 12px; margin: 10px 0;">
                            <i class="fas fa-wallet fa-2x mb-3 text-muted" style="opacity: 0.3;"></i>
                            <p class="mb-0" style="font-size: 14px; font-weight: 500;">No saved wallet addresses found.</p>
                            <small class="text-muted">Save your BEP-20 addresses above for quick access.</small>
                        </div>
                    `;
                }
                $('.wallets-list-container').html(html);
            }

            // Click to select wallet card directly from card selection view
            $(document).on('click', '.wallet-option-card:not(.no-wallet-option-card)', function() {
                const address = $(this).attr('data-address') || $(this).data('address');
                const hiddenInput = $('#selectedWalletAddress');
                if (hiddenInput.length && address) {
                    hiddenInput.val(address).trigger('change');
                    $('.wallet-option-card').removeClass('selected');
                    $(this).addClass('selected');
                    
                    // Update check icons
                    $('.wallet-option-card').each(function() {
                        const isSel = $(this).hasClass('selected');
                        $(this).find('.wallet-option-icon i').attr('class', isSel ? 'fas fa-check' : 'fas fa-wallet');
                    });
                    
                    // Update modal active state as well
                    $.get(getAppUrl("/user/withdraw/wallets"), function(response) {
                        if (response.success) {
                            updateManageModalList(response.wallets);
                        }
                    });
                }
            });

            // Copy to clipboard event handler
            $(document).on('click', '.btn-copy-address, .wallet-address-display', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const address = $(this).attr('data-address') || $(this).data('address');
                if (!address) return;

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(address).then(function() {
                        notify('success', 'Wallet address copied to clipboard!');
                    }).catch(function() {
                        fallbackCopyText(address);
                    });
                } else {
                    fallbackCopyText(address);
                }
            });

            function fallbackCopyText(text) {
                const temp = $("<input>");
                $("body").append(temp);
                temp.val(text).select();
                document.execCommand("copy");
                temp.remove();
                notify('success', 'Wallet address copied to clipboard!');
            }

            // Safe modal hide/show helper function
            function toggleModal(modalSelector, action) {
                const $modal = $(modalSelector);
                if (!$modal.length) return;

                if (typeof $.fn.modal === 'function') {
                    $modal.modal(action);
                } else if (window.bootstrap && bootstrap.Modal) {
                    const modal = bootstrap.Modal.getOrCreateInstance($modal[0]);
                    if (action === 'show') modal.show();
                    else modal.hide();
                } else {
                    if (action === 'show') {
                        $modal.addClass('show').css('display', 'block');
                        if (!$('.modal-backdrop').length) {
                            $('body').append('<div class="modal-backdrop fade show"></div>');
                        }
                        $('body').addClass('modal-open');
                    } else {
                        $modal.removeClass('show').css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css('overflow', '');
                    }
                }
            }

            // Open management modal when clicking "Manage"
            $(document).on('click', '#btnManageWallets', function() {
                toggleModal('#walletsModal', 'show');
            });

            // Close modal when close buttons are clicked
            $(document).on('click', '[data-bs-dismiss="modal"], [data-dismiss="modal"]', function() {
                toggleModal('#walletsModal', 'hide');
            });

            // Form submission for adding a new wallet
            $('#addWalletForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: getAppUrl("/user/withdraw/wallets/save"),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        submitBtn.prop('disabled', false);
                        if (response.success) {
                            notify('success', response.message);
                            form.find('input[name="label"]').val('');
                            form.find('input[name="address"]').val('');
                            
                            // Close modal on successful save
                            toggleModal('#walletsModal', 'hide');

                            // Reload and auto-select new address
                            loadWalletsSelect(response.wallet.address);
                        } else {
                            notify('error', response.message || 'Failed to save address.');
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false);
                        let errorMsg = 'An error occurred while saving.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        notify('error', errorMsg);
                    }
                });
            });

            // Click to select saved wallet address from modal
            $(document).on('click', '.select-wallet-row', function(e) {
                // If clicked on action buttons (copy, delete), ignore select
                if ($(e.target).closest('.wallet-card-actions').length || $(e.target).hasClass('btn-copy-address') || $(e.target).hasClass('btn-delete-wallet') || $(e.target).closest('.btn-copy-address').length || $(e.target).closest('.btn-delete-wallet').length) {
                    return;
                }

                const address = $(this).attr('data-address') || $(this).data('address');
                const hiddenInput = $('#selectedWalletAddress');
                if (hiddenInput.length && address) {
                    hiddenInput.val(address).trigger('change');
                    toggleModal('#walletsModal', 'hide');
                    loadWalletsSelect(address);
                }
            });

            // Handle confirmation modal buttons
            $(document).on('click', '#btnSubmitWithoutSaving', function() {
                const btn = $(this);
                const originalHtml = btn.html();
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
                $('#btnSaveAndSubmit').prop('disabled', true);
                
                submitVerificationForm(function(submitRes) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('#btnSaveAndSubmit').prop('disabled', false);
                    toggleModal('#saveWalletConfirmModal', 'hide');
                    
                    $('#step-2').hide();
                    $('#step-3').fadeIn();
                    $('.step[data-step="2"]').addClass('completed').removeClass('active');
                    $('.step[data-step="3"]').addClass('active').addClass('completed');
                }, function(errorMsg) {
                    btn.prop('disabled', false).html(originalHtml);
                    $('#btnSaveAndSubmit').prop('disabled', false);
                    toggleModal('#saveWalletConfirmModal', 'hide');
                    notify('error', errorMsg);
                });
            });

            $(document).on('click', '#btnSaveAndSubmit', function() {
                const labelInput = $('#modalSaveLabel');
                let labelVal = (labelInput.length && labelInput.val()) ? labelInput.val().trim() : '';
                
                // Fallback to default label if empty
                if (!labelVal) {
                    labelVal = "My Wallet";
                    if (labelInput.length) {
                        labelInput.val(labelVal);
                    }
                }

                const addressInput = $('#modalSaveAddressValue');
                let addressVal = (addressInput.length && addressInput.val()) ? addressInput.val().trim() : '';
                
                // Direct fallback: read from #manualWalletAddress if hidden modal input is somehow empty
                if (!addressVal) {
                    const manualInput = $('#manualWalletAddress');
                    if (manualInput.length && manualInput.val()) {
                        addressVal = manualInput.val().trim();
                        if (addressInput.length) {
                            addressInput.val(addressVal);
                        }
                    }
                }

                if (!addressVal) {
                    notify('error', 'Wallet address is missing. Please type your wallet address.');
                    return;
                }

                const btn = $(this);
                const originalHtml = btn.html();
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving Wallet...');
                $('#btnSubmitWithoutSaving').prop('disabled', true);

                $.ajax({
                    url: getAppUrl("/user/withdraw/wallets/save"),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        label: labelVal,
                        address: addressVal
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
                            
                            // Immediately submit the withdrawal form
                            submitVerificationForm(function(submitRes) {
                                btn.prop('disabled', false).html(originalHtml);
                                $('#btnSubmitWithoutSaving').prop('disabled', false);
                                toggleModal('#saveWalletConfirmModal', 'hide');
                                
                                $('#step-2').hide();
                                $('#step-3').fadeIn();
                                $('.step[data-step="2"]').addClass('completed').removeClass('active');
                                $('.step[data-step="3"]').addClass('active').addClass('completed');
                            }, function(errorMsg) {
                                btn.prop('disabled', false).html(originalHtml);
                                $('#btnSubmitWithoutSaving').prop('disabled', false);
                                toggleModal('#saveWalletConfirmModal', 'hide');
                                notify('error', errorMsg);
                            });
                        } else {
                            btn.prop('disabled', false).html(originalHtml);
                            $('#btnSubmitWithoutSaving').prop('disabled', false);
                            notify('error', response.message || 'Failed to save address.');
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(originalHtml);
                        $('#btnSubmitWithoutSaving').prop('disabled', false);
                        let errorMsg = 'An error occurred while saving.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        notify('error', errorMsg);
                    }
                });
            });

            // Storing the wallet ID to delete
            let walletIdToDelete = null;

            // Deleting a saved wallet address (opens confirmation modal)
            $(document).on('click', '.btn-delete-wallet', function(e) {
                e.stopPropagation(); // Stop propagation so it doesn't trigger card selection
                walletIdToDelete = $(this).data('id');
                toggleModal('#deleteConfirmModal', 'show');
            });

            // Confirm delete wallet click
            $(document).on('click', '#btnConfirmDeleteWallet', function() {
                if (!walletIdToDelete) return;
                const btn = $(this);
                const originalHtml = btn.html();
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: getAppUrl(`/user/withdraw/wallets/delete/${walletIdToDelete}`),
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(originalHtml);
                        toggleModal('#deleteConfirmModal', 'hide');
                        if (response.success) {
                            notify('success', response.message);
                            loadWalletsSelect();
                        } else {
                            notify('error', response.message || 'Failed to delete address.');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html(originalHtml);
                        toggleModal('#deleteConfirmModal', 'hide');
                        notify('error', 'An error occurred while deleting.');
                    }
                });
            });

        })(jQuery);
    </script>
    <style>
        footer {
            display: none !important;
        }

        .mobile-nav,
        .nav {
            display: none !important;
        }
    </style>
@endpush