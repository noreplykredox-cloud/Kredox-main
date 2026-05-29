@extends($activeTemplate.'layouts.master')
@section('content')
<div class="withdraw-container">
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop id="myVideo">
            <source src="https://kredox.org/All-Media/Dashboard.webm" type="video/mp4">
            <img src="{{ asset('assets/images/frontend/bg.jpg') }}" alt="Background">
        </video>
        <div class="video-overlay"></div>
    </div>

    <!-- Progress Bar Section -->
    <div class="progress-bar-container">
        <div class="progress-steps">
            <div class="step completed" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Withdrawal Method</div>
            </div>
            <div class="step active" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Verification</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="withdraw-wrapper">
        <div class="withdraw-grid">
            <!-- Withdrawal Form Column -->
            <div class="withdraw-form-card">
                <div class="card-header">
                    <h3><i class="fas fa-edit"></i> Required Information</h3>
                    <div class="method-badge">
                        <i class="fas fa-university"></i> {{ $withdraw->method->name }}
                    </div>
                </div>
                
                <form id="withdrawForm" action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data" class="withdraw-form">
                    @csrf
                    
                    <div class="method-description mb-4">
                        <div class="description-box">
                            <i class="fas fa-info-circle"></i>
                            <div class="text">
                                @php
                                    echo $withdraw->method->description;
                                @endphp
                            </div>
                        </div>
                    </div>
                    
                    <div class="dynamic-form-fields">
                        <x-viser-form identifier="id" identifierValue="{{ $withdraw->method->form_id }}" />
                    </div>
                    
                    @if(auth()->user()->ts)
                    <div class="form-group mt-4">
                        <label class="form-label">
                            <i class="fas fa-key"></i> Google Authenticator Code
                        </label>
                        <div class="auth-input-wrapper">
                            <input type="text" name="authenticator_code" class="form-control auth-input" placeholder="000000" required>
                        </div>
                    </div>
                    @endif
                    
                    <button type="submit" class="withdraw-submit-btn">
                        <span>Submit Withdrawal Request</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Information Column -->
            <div class="info-sidebar">
                <!-- Transaction Summary Card -->
                <div class="info-card summary-highlight">
                    <div class="card-header" style="margin-bottom: 20px;">
                        <h3 style="margin:0;"><i class="fas fa-file-invoice"></i> Withdrawal Summary</h3>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <div class="summary-list">
                            <div class="summary-item">
                                <span class="label">Wallet Type:</span>
                                <span class="val text-primary">{{ $withdraw->withdraw_type == 2 ? 'Investment Amount' : 'Current Balance' }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Requested:</span>
                                <span class="val">{{ showAmount($withdraw->amount) }} {{ $general->cur_text }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="label">Charge:</span>
                                <span class="val text-danger">{{ showAmount($withdraw->charge) }} {{ $general->cur_text }}</span>
                            </div>
                            <div class="summary-item total-row">
                                <span class="label">Receivable:</span>
                                <span class="val text-success">{{ showAmount($withdraw->amount - $withdraw->charge) }} {{ $general->cur_text }}</span>
                            </div>
                            @if($withdraw->method->currency != $general->cur_text)
                            <div class="summary-item highlight-row">
                                <span class="label">In {{ $withdraw->method->currency }}:</span>
                                <span class="val">{{ showAmount($withdraw->final_amount) }} {{ $withdraw->method->currency }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Security Trust -->
                <div class="faq-card">
                    <h3><i class="fas fa-shield-alt"></i> Safety First</h3>
                    <p style="font-size: 13px; color: var(--text-muted); line-height: 1.6; margin:0;">Your withdrawal request will be manually reviewed by our finance team to ensure the security of your funds. This process typically takes between 1-24 hours.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manage Wallets Modal -->
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

@push('script')
<script>
    (function($) {
        "use strict";

        $(document).ready(function() {
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

            // --- Saved Wallets Integration in Verification Details ---
            let walletInput = null;
            let dynamicWalletInputName = '';
            let walletInputIsRequired = false;

            // Find any wallet address or address input/textarea field in the form programmatically (excluding csrf & authenticator)
            walletInput = $('#withdrawForm input, #withdrawForm textarea').filter(function() {
                const name = ($(this).attr('name') || '').toLowerCase();
                if (name === '_token' || name === 'authenticator_code') return false;
                return name.indexOf('address') !== -1 || name.indexOf('wallet') !== -1 || name.indexOf('your_wallet') !== -1;
            }).first();

            // Fallback: if no keyword match, take the first visible text/textarea field in the form (excluding authenticator and token)
            if (!walletInput.length) {
                walletInput = $('#withdrawForm input:not([type="hidden"]):not([type="submit"]):not([name="authenticator_code"]):not([name="_token"]), #withdrawForm textarea').first();
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
                        
                        if (currentVal) {
                            hiddenInput.val(currentVal).trigger('change');
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
                const currentSelectedAddress = $('#selectedWalletAddress').val();
                
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
                    
                    notify('success', 'Wallet address selected!');
                    
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
                    notify('success', 'Wallet address selected successfully!');
                    toggleModal('#walletsModal', 'hide');
                    loadWalletsSelect(address);
                }
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

            // Form submission intercept for confirmation modal
            $('#withdrawForm').on('submit', function (e) {
                // Check if manual wallet input is active, visible and has a value
                const manualWrapper = $('.manual-wallet-input-wrapper');
                const manualInput = $('#manualWalletAddress');
                const manualVal = (manualInput.length && manualInput.val()) ? manualInput.val().trim() : '';
                
                if (manualWrapper.length && !manualWrapper.hasClass('d-none') && manualVal !== '') {
                    e.preventDefault(); // Stop normal form post
                    $('#modalSaveAddressValue').val(manualVal);
                    
                    // Show our custom save confirmation modal
                    toggleModal('#saveWalletConfirmModal', 'show');
                }
            });

            $(document).on('click', '#btnSubmitWithoutSaving', function() {
                const btn = $(this);
                const originalHtml = btn.html();
                
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
                $('#btnSaveAndSubmit').prop('disabled', true);
                
                toggleModal('#saveWalletConfirmModal', 'hide');
                $('#withdrawForm')[0].submit(); // Standard HTML form post
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
                            toggleModal('#saveWalletConfirmModal', 'hide');
                            $('#withdrawForm')[0].submit(); // Standard HTML form post
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
        });
    })(jQuery);
</script>
@endpush

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

    .withdraw-container {
        margin-left: 280px;
        padding: 30px;
        min-height: 100vh;
        position: relative;
        z-index: 1;
        padding-bottom: 100px;
    }

    /* Video Background */
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
        filter: brightness(0.15) sepia(0.3) hue-rotate(-10deg);
        opacity: 0.4;
    }
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.8) 100%);
    }

    /* Progress Bar */
    .progress-bar-container {
        background: rgba(17, 17, 17, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid var(--border-red);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-red);
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
        background: var(--gradient-red);
        opacity: 0.3;
    }
    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 1;
    }
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        flex: 1;
    }
    .step::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: rgba(255, 255, 255, 0.1);
        z-index: -1;
    }
    .step:last-child::before { display: none; }
    .step.active .step-number, .step.completed .step-number {
        background: var(--gradient-red);
        border-color: var(--light-red);
        color: white;
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
    }
    .step.active .step-number { animation: pulse 2s infinite; }
    .step.completed .step-number::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 14px;
    }
    .step.completed .step-number { color: transparent; }
    
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
    .step-label { color: var(--text-muted); font-size: 14px; font-weight: 500; }
    .step.active .step-label, .step.completed .step-label { color: var(--text-white); text-shadow: 0 0 10px rgba(255, 0, 0, 0.3); }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5); }
        70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
    }

    /* Grid Layout */
    .withdraw-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
    }

    /* Form Card */
    .withdraw-form-card {
        background: rgba(17, 17, 17, 0.9);
        border: 1px solid var(--border-red);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .card-header h3 { font-size: 20px; color: white; margin: 0; display: flex; align-items: center; gap: 12px; }
    .card-header h3 i { color: var(--accent-red); }
    .method-badge { background: rgba(255, 0, 0, 0.1); border: 1px solid var(--border-red); color: var(--light-red); padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: 600; }

    .description-box {
        background: rgba(255, 255, 255, 0.05);
        border-left: 4px solid var(--accent-red);
        padding: 15px 20px;
        border-radius: 8px;
        display: flex;
        gap: 15px;
        color: var(--text-muted);
        font-size: 14px;
        line-height: 1.6;
    }
    .description-box i { color: var(--accent-red); font-size: 18px; margin-top: 3px; }

    /* Viser Form Styling Override */
    .dynamic-form-fields .form-group { margin-bottom: 20px; }
    .dynamic-form-fields label { display: block; color: #fff; margin-bottom: 10px; font-weight: 500; font-size: 15px; }
    .dynamic-form-fields input, 
    .dynamic-form-fields select, 
    .dynamic-form-fields textarea {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        padding: 12px 15px !important;
        border-radius: 10px !important;
        width: 100%;
        transition: var(--transition);
    }
    .dynamic-form-fields input:focus { border-color: var(--accent-red) !important; outline: none; box-shadow: 0 0 10px rgba(255,0,0,0.2); }

    /* Auth Input */
    .auth-input-wrapper .auth-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        padding: 15px !important;
        border-radius: 12px !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        letter-spacing: 5px;
        text-align: center;
        width: 100%;
    }

    /* Submit Button */
    .withdraw-submit-btn {
        width: 100%;
        background: var(--gradient-red);
        border: none;
        border-radius: 12px;
        padding: 18px;
        color: white;
        font-size: 18px;
        font-weight: 700;
        margin-top: 30px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: var(--transition);
        box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
    }
    .withdraw-submit-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(255, 0, 0, 0.5); }

    /* Sidebar Cards */
    .info-card { background: rgba(17, 17, 17, 0.8); border: 1px solid var(--border-red); border-radius: 15px; padding: 25px; margin-bottom: 25px; }
    .summary-list { display: flex; flex-direction: column; gap: 15px; }
    .summary-item { display: flex; justify-content: space-between; font-size: 15px; color: var(--text-muted); }
    .summary-item .val { color: white; font-weight: 600; }
    .summary-item.total-row { border-top: 1px dashed var(--border-red); padding-top: 15px; margin-top: 5px; font-weight: 700; font-size: 18px; }
    .summary-item.highlight-row { background: rgba(255, 255, 255, 0.05); padding: 10px; border-radius: 8px; margin-top: 10px; }

    .faq-card { background: rgba(17, 17, 17, 0.8); border: 1px solid var(--border-red); border-radius: 15px; padding: 25px; }
    .faq-card h3 { font-size: 18px; color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; }

    /* Responsive */
    @media (max-width: 1200px) {
        .withdraw-container { margin-left: 0; padding: 20px; padding-bottom: 40px; }
        .withdraw-grid { grid-template-columns: 1fr; }
        .info-sidebar { order: 2; }
        .withdraw-form-card { order: 1; }
    }

    /* Wallet Select Cards */
    .wallet-select-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        position: relative;
        overflow: hidden;
    }
    
    .wallet-select-card:hover {
        background: rgba(255, 0, 0, 0.03);
        border-color: rgba(255, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .wallet-select-card.active {
        background: rgba(255, 0, 0, 0.08);
        border-color: rgba(255, 0, 0, 0.8);
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
    }
    
    .wallet-select-card.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background: var(--gradient-red);
    }
    
    .wallet-card-label {
        font-size: 14px;
        font-weight: 700;
        color: #fff;
    }
    
    .wallet-card-address {
        font-family: monospace;
        font-size: 12px;
        color: var(--text-muted);
        word-break: break-all;
    }
    
    .wallet-select-card.active .wallet-card-address {
        color: #ddd;
    }
</style>
@endpush

<style>
footer { display: none !important; }
/* Remove default mobile navigation */
.mobile-nav, .nav { display: none !important; }
</style>