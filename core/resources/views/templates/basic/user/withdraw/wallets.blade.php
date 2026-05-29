@extends($activeTemplate . 'layouts.master')
@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --ms-primary: #ff0000;
            --ms-bg: #0a0a0a;
            --ms-card: #111111;
            --ms-border: rgba(255, 0, 0, 0.15);
            --ms-text: #ffffff;
            --ms-text-soft: #b0b0b0;
            --ms-muted: #666;
            --ms-gradient: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            font-family: 'Outfit', sans-serif;
            background-color: var(--ms-bg);
            color: var(--ms-text);
            margin: 0;
            overflow: hidden;
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
            z-index: -1;
            overflow: hidden;
        }

        #bgVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.15;
            filter: brightness(0.15) sepia(0.3) hue-rotate(-10deg);
        }

        /* Compact Layout Wrapper */
        .viewport-wrapper {
            margin-left: 280px;
            height: 100vh;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Header Style */
        .dashboard-header {
            background: #000;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            padding: 20px 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .inner-header-box {
            padding: 9px 7px;
        }

        .greeting-text h1 {
            color: var(--ms-text);
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .greeting-text p {
            color: var(--ms-text-soft);
            font-size: 14px;
            margin: 0;
            font-weight: 500;
            max-width: 100%;
        }

        /* Main Grid */
        .compact-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 25px;
            flex: 1;
            min-height: 0;
            margin-bottom: 40px;
        }

        .main-card {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--ms-primary) transparent;
        }

        .main-card::-webkit-scrollbar { width: 3px; }
        .main-card::-webkit-scrollbar-thumb { background: var(--ms-primary); }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--ms-gradient);
            border-radius: 24px 24px 0 0;
        }

        /* Side Panel */
        .side-panel {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sb-feat {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .sb-ico {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 0, 0, 0.08);
            border: 1px solid rgba(255, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--ms-primary);
            font-size: 20px;
        }

        .sb-txt h4 {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 3px;
            color: #fff;
        }

        .sb-txt p {
            font-size: 11.5px;
            color: var(--ms-text-soft);
            line-height: 1.4;
            margin: 0;
        }

        /* Inputs & Form */
        .fg {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .fl {
            font-size: 12px;
            font-weight: 700;
            color: var(--ms-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-left: 2px;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            color: var(--ms-muted);
            font-size: 20px;
            transition: var(--transition);
        }

        .fi {
            width: 100%;
            background: rgba(255, 255, 255, 0.01) !important;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-radius: 12px !important;
            padding: 14px 16px 14px 45px !important;
            color: #fff !important;
            font-size: 15px !important;
            font-weight: 500 !important;
            transition: var(--transition) !important;
            outline: none !important;
        }

        .fi:focus {
            border-color: rgba(243, 186, 47, 0.4) !important; /* BSC Gold border on focus */
            background: rgba(255, 255, 255, 0.03) !important;
            box-shadow: 0 0 12px rgba(243, 186, 47, 0.1) !important;
        }

        .fi:focus + i {
            color: rgba(243, 186, 47, 0.8) !important;
        }

        .sb-btn {
            background: var(--ms-gradient) !important;
            color: #fff !important;
            border: none !important;
            padding: 15px 45px !important;
            border-radius: 16px !important;
            font-size: 15px !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            cursor: pointer !important;
            transition: var(--transition) !important;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.4) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            margin-top: 10px !important;
            width: 100% !important;
        }

        .sb-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 35px rgba(255, 0, 0, 0.6) !important;
        }

        /* Saved Payout Cards Layout */
        .saved-wallet-card-page {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            border-radius: 16px !important;
            padding: 15px 20px !important;
            margin-bottom: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 20px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .saved-wallet-card-page:hover {
            background: rgba(255, 255, 255, 0.04) !important;
            border-color: rgba(243, 186, 47, 0.2) !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
            transform: translateY(-2px) !important;
        }

        .wallet-card-left-page {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
            min-width: 0 !important;
            flex: 1 !important;
        }

        .wallet-icon-avatar-page {
            width: 44px !important;
            height: 44px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, rgba(243, 186, 47, 0.2) 0%, rgba(243, 186, 47, 0.05) 100%) !important;
            border: 1px solid rgba(243, 186, 47, 0.3) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #f3ba2f !important;
            flex-shrink: 0 !important;
        }

        .wallet-icon-avatar-page i {
            font-size: 18px !important;
            filter: drop-shadow(0 0 3px rgba(243, 186, 47, 0.4)) !important;
        }

        .wallet-info-content-page {
            min-width: 0 !important;
            flex: 1 !important;
        }

        .wallet-title-row-page {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-bottom: 4px !important;
        }

        .wallet-label-text-page {
            font-weight: 700 !important;
            color: #fff !important;
            font-size: 15px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .badge-bep20-page {
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

        .badge-bep20-page i {
            font-size: 9px !important;
        }

        .wallet-address-display-page {
            font-size: 12px !important;
            color: var(--ms-text-soft) !important;
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

        .wallet-address-display-page:hover {
            color: #f3ba2f !important;
        }

        .wallet-address-display-page .address-text-page {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .wallet-address-display-page .copy-icon-page {
            font-size: 12px !important;
            opacity: 0.5 !important;
            transition: all 0.2s ease !important;
        }

        .wallet-address-display-page:hover .copy-icon-page {
            opacity: 1 !important;
            transform: scale(1.1) !important;
        }

        .wallet-card-actions-page {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            flex-shrink: 0 !important;
        }

        .btn-copy-address-page {
            height: 36px !important;
            padding: 0 16px !important;
            border-radius: 10px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            background: rgba(255, 255, 255, 0.03) !important;
            color: var(--ms-text-soft) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
        }

        .btn-copy-address-page:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-delete-wallet-page {
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

        .btn-delete-wallet-page:hover {
            background: #ea5455 !important;
            color: #fff !important;
            border-color: #ea5455 !important;
            box-shadow: 0 0 10px rgba(234, 84, 85, 0.4) !important;
        }

        /* Table Style */
        .table-responsive {
            margin-top: 25px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            color: var(--ms-text);
        }

        .table-custom th {
            border-bottom: 2px solid var(--ms-border);
            padding: 12px 10px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--ms-muted);
        }

        .table-custom td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            padding: 18px 10px;
            font-size: 14px;
        }

        .table-custom tr:hover td {
            background: rgba(255, 255, 255, 0.01);
        }

        /* FAQ / Tips */
        .q-title {
            font-size: 16px;
            font-weight: 800;
            margin: 20px 0 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .q-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--ms-border);
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .q-head {
            padding: 10px 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
        }

        .q-head i {
            color: var(--ms-primary);
            font-size: 18px;
        }

        .q-body {
            padding: 0 15px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
            font-size: 12px;
            color: var(--ms-text-soft);
        }

        .q-card.active .q-body {
            padding: 5px 15px 15px;
            max-height: 100px;
        }

        /* RESPONSIVE */
        @media (max-width: 1400px) {
            .compact-grid { grid-template-columns: 1fr; }
            body { overflow: auto; }
            .viewport-wrapper { height: auto; margin-left: 280px; padding: 25px; }
        }

        @media (max-width: 1200px) {
            .viewport-wrapper { margin-left: 0; padding: 70px 10px 15px 10px; }
            body { overflow: auto; }
            .dashboard-header { padding: 15px 12px; margin-bottom: 8px; }
            .greeting-text h1 { font-size: 22px; }
            .greeting-text p { font-size: 13px; }
        }

        @media (max-width: 768px) {
            .saved-wallet-card-page {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 15px !important;
                padding: 15px !important;
            }
            .wallet-card-left-page {
                width: 100% !important;
            }
            .wallet-title-row-page {
                flex-wrap: wrap !important;
                gap: 8px !important;
            }
            .wallet-address-display-page {
                width: 100% !important;
                justify-content: space-between !important;
            }
            .wallet-address-display-page .address-text-page {
                max-width: calc(100vw - 165px) !important;
            }
            .wallet-card-actions-page {
                width: 100% !important;
                display: flex !important;
                gap: 10px !important;
                border-top: 1px dashed rgba(255, 255, 255, 0.08) !important;
                padding-top: 12px !important;
            }
            .btn-copy-address-page, .btn-delete-wallet-page {
                flex: 1 !important;
                justify-content: center !important;
            }
        }

        @media (max-width: 576px) {
            .viewport-wrapper { padding-top: 85px; padding-left: 12px; padding-right: 12px; }
            .dashboard-header { padding: 18px 12px; }
            .greeting-text h1 { font-size: 20px; }
            .main-card { padding: 20px 15px; }
        }
    </style>

    <div class="viewport-wrapper">

        <div class="video-background">
            <video autoplay muted loop id="bgVideo">
                <source src="https://kredox.org/All-Media/Dashboard.webm" type="video/mp4">
            </video>
        </div>

        {{-- Header --}}
        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>{{ __($pageTitle) }}</h1>
                    <p>Register and manage your payout destinations. Saved wallet addresses can be clicked to instantly autofill withdrawal requests.</p>
                </div>
            </div>
        </div>

        <div class="compact-grid">

            <div class="main-card">
                <form id="addWalletFormPage" class="mb-4">
                    @csrf
                    <div class="max-wallets-limit-warning d-none alert alert-warning p-2 mb-3" style="background: rgba(243, 186, 47, 0.1); border: 1px solid rgba(243, 186, 47, 0.2); border-radius: 10px; color: #f3ba2f; font-size: 12px; display: flex; align-items: center; gap: 8px; width: 100%;">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>You have reached the maximum limit of 2 saved wallet addresses. Delete an address to save a new one.</span>
                    </div>
                    <h5 class="mb-4 text-white" style="font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-plus text-danger mr-2"></i> Save New Payout Address</h5>
                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="fg">
                                <label class="fl">Wallet Label</label>
                                <div class="input-group-custom">
                                    <i class="material-icons" style="line-height: inherit;">label</i>
                                    <input type="text" name="label" class="fi" required placeholder="e.g. My Trust Wallet">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="fg">
                                <label class="fl">Wallet Address</label>
                                <div class="input-group-custom">
                                    <i class="material-icons" style="line-height: inherit;">account_balance_wallet</i>
                                    <input type="text" name="address" class="fi" required placeholder="Enter payout address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="sb-btn" id="btnSubmitFormPage">
                        Save Payout Wallet
                        <i class="material-icons">save</i>
                    </button>
                </form>

                <hr style="border: 0; border-top: 1px dashed rgba(255,0,0,0.15); margin: 30px 0;">

                <h5 class="text-white mb-3" style="font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;"><i class="fas fa-history text-danger mr-2"></i> Saved Addresses</h5>
                
                <div class="wallets-list-container-page mt-3" style="max-height: 480px; overflow-y: auto; padding-right: 5px;">
                    <!-- List will load via AJAX -->
                </div>
            </div>

            <div class="side-panel">
                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">bolt</i></div>
                    <div class="sb-txt">
                        <h4>Instant Autofill</h4>
                        <p>During a withdrawal request, you can choose from these saved destinations with one click.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">lock</i></div>
                    <div class="sb-txt">
                        <h4>Secure Routing</h4>
                        <p>Addresses are securely saved to your personal profile. Ensure 2FA is active on your account.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">layers</i></div>
                    <div class="sb-txt">
                        <h4>Supported Networks</h4>
                        <p>You can save addresses for BEP-20 (USDT), ERC-20, TRC-20, BTC, or custom payout routes.</p>
                    </div>
                </div>

                <div class="q-title"><i class="material-icons">security</i> Security Tips</div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Double-check Addresses <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Always verify the address character by character. Sending assets to the wrong address is irreversible.</div>
                </div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Ensure Label Accuracy <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Use clear labels like "Binance - BEP20" or "Metamask - ERC20" to avoid picking the wrong network address during withdrawals.</div>
                </div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Do Not Share Account <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Never share your MLM login credentials. Anyone with access can edit these saved destinations.</div>
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
@endsection

@push('script')
<script>
    (function ($) {
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

            // Initial load of saved wallets
            loadWalletsTable();

            // Load saved wallets and render inside card layout container
            function loadWalletsTable() {
                $('.wallets-list-container-page').html(`
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-spinner fa-spin fa-2x mb-3 text-danger"></i>
                        <p class="mb-0">Loading saved addresses...</p>
                    </div>
                `);

                $.get(getAppUrl("/user/withdraw/wallets"), function(response) {
                    if (response.success) {
                        let html = '';
                        if (response.wallets.length > 0) {
                            response.wallets.forEach(function(wallet) {
                                html += `
                                    <div class="saved-wallet-card-page">
                                        <div class="wallet-card-left-page">
                                            <div class="wallet-icon-avatar-page">
                                                <i class="fas fa-coins"></i>
                                            </div>
                                            <div class="wallet-info-content-page">
                                                <div class="wallet-title-row-page">
                                                    <span class="wallet-label-text-page">${wallet.label}</span>
                                                    <span class="badge-bep20-page">
                                                        <i class="fas fa-link"></i> BEP-20
                                                    </span>
                                                </div>
                                                <div class="wallet-address-display-page" title="Click to copy" data-address="${wallet.address}">
                                                    <span class="address-text-page">${wallet.address}</span>
                                                    <i class="far fa-copy copy-icon-page"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wallet-card-actions-page">
                                            <button type="button" class="btn-copy-address-page" title="Copy Address" data-address="${wallet.address}">
                                                <i class="far fa-copy"></i> Copy
                                            </button>
                                            <button type="button" class="btn-delete-wallet-page" title="Delete Saved Wallet" data-id="${wallet.id}">
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
                        $('.wallets-list-container-page').html(html);

                        // Disable form and show warning if 2 wallets are saved
                        if (response.wallets.length >= 2) {
                            $('.max-wallets-limit-warning').removeClass('d-none');
                            $('#btnSubmitFormPage').prop('disabled', true).html('Limit Reached (2/2 Saved) <i class="fas fa-ban"></i>');
                            $('#addWalletFormPage input[name="label"], #addWalletFormPage input[name="address"]').prop('disabled', true);
                        } else {
                            $('.max-wallets-limit-warning').addClass('d-none');
                            $('#btnSubmitFormPage').prop('disabled', false).html('Save Payout Wallet <i class="material-icons">save</i>');
                            $('#addWalletFormPage input[name="label"], #addWalletFormPage input[name="address"]').prop('disabled', false);
                        }
                    }
                });
            }

            // Copy to clipboard helper
            $(document).on('click', '.btn-copy-address-page, .wallet-address-display-page', function(e) {
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

            // Save new wallet address form submit
            $('#addWalletFormPage').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const submitBtn = $('#btnSubmitFormPage');
                submitBtn.prop('disabled', true).html('Saving Payout Wallet <i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: getAppUrl("/user/withdraw/wallets/save"),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        submitBtn.prop('disabled', false).html('Save Payout Wallet <i class="material-icons">save</i>');
                        if (response.success) {
                            notify('success', response.message);
                            form.find('input[name="label"]').val('');
                            form.find('input[name="address"]').val('');
                            loadWalletsTable();
                        } else {
                            notify('error', response.message || 'Failed to save address.');
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html('Save Payout Wallet <i class="material-icons">save</i>');
                        let errorMsg = 'An error occurred while saving.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        notify('error', errorMsg);
                    }
                });
            });

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

            // Close modal when cancel or close button inside confirm modal is clicked
            $(document).on('click', '[data-bs-dismiss="modal"], [data-dismiss="modal"]', function() {
                toggleModal('#deleteConfirmModal', 'hide');
            });

            // Storing the wallet ID to delete
            let walletIdToDelete = null;

            // Delete wallet address click
            $(document).on('click', '.btn-delete-wallet-page', function() {
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
                            loadWalletsTable();
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
        });
    })(jQuery);
</script>
@endpush
