@extends($activeTemplate . 'layouts.master')
@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --card-black: #111111;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --border-red: rgba(255, 0, 0, 0.2);
            --text-white: #ffffff;
            --text-muted: #999999;
            --success-green: #00ff00;
            --danger-red: #ff3333;
            --warning-orange: #ff9900;
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --gradient-card: linear-gradient(145deg, #111111 0%, #1a1a1a 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.5);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--dark-black);
            color: var(--text-white);
        }

        .dashboard-container {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .dashboard-header {
            background: #000;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            padding: 15px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
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

        .header-top {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .greeting-text h1 {
            color: var(--text-white);
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .greeting-text p {
            color: var(--text-muted);
            font-size: 14px;
            margin: 0;
            font-weight: 500;
        }

        .deposit-card {
            background: var(--gradient-card);
            border-radius: 15px;
            border: 1px solid var(--border-red);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .card-header {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-red);
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            gap: 20px;
        }

        .card-header h3 {
            color: var(--text-white);
            font-size: 18px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .user-id {
            color: var(--text-muted);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 5px;
            font-weight: 500;
        }

        .user-id i {
            font-size: 11px;
            color: #00ff00;
            margin-right: 2px;
        }

        .user-id-value {
            color: inherit;
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
            top: -1px;
        }

        .status-online {
            color: var(--success-green);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            margin-left: 10px;
        }

        .status-online i {
            font-size: 8px;
            animation: pulse 2s infinite;
            text-shadow: 0 0 8px var(--success-green);
        }

        .card-actions-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: nowrap;
        }

        .filter-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-select {
            background: #000 !important;
            border: 1px solid var(--border-red) !important;
            color: white !important;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 13px;
            height: 42px;
            outline: none;
        }

        .btn-reset-filters {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid var(--border-red);
            color: var(--light-red);
            height: 42px;
            padding: 0 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-reset-filters:hover {
            background: var(--light-red);
            color: white;
        }

        .search-group {
            position: relative;
            width: 250px;
        }

        .search-input {
            background: #000 !important;
            border: 1px solid var(--border-red) !important;
            color: white !important;
            padding: 10px 15px 10px 40px !important;
            border-radius: 10px;
            font-size: 13px;
            width: 100%;
            height: 42px;
            outline: none;
        }

        .search-icon-box {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
        }

        .deposit-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .deposit-table thead {
            background: #8b0000;
        }

        .deposit-table th {
            padding: 18px 20px;
            text-align: center;
            color: white;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 800;
            border: none;
        }

        .deposit-table td {
            padding: 20px;
            color: var(--text-white);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
        }

        .serial-number {
            font-weight: 700;
            color: var(--text-muted);
        }

        .date-time-cell {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .date-time-cell .date {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .date-time-cell .time {
            color: var(--text-muted);
            font-size: 12px;
        }

        .trx-code {
            color: white;
            font-family: 'Consolas', monospace;
            font-size: 13px;
            background: rgba(20, 10, 10, 0.8);
            padding: 6px 15px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: inline-block;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .amount-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .amount-main {
            font-weight: 700;
            font-size: 15px;
        }

        .amount-plus .amount-main {
            color: #00ff00;
        }

        .amount-minus .amount-main {
            color: #ff3333;
        }

        .currency {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 500;
        }

        .post-balance-cell {
            font-weight: 600;
            color: var(--text-white);
        }

        .details-cell {
            color: var(--text-muted);
            font-size: 13px;
            max-width: 250px;
            margin: 0 auto;
            line-height: 1.4;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-red);
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--gradient-red);
            transform: translateY(-2px);
        }

        /* Mobile Styles */
        .deposits-mobile-view {
            display: none;
        }

        @media (max-width: 991px) {
            .dashboard-container {
                margin-left: 0;
                padding: 15px;
            }

            .desktop-view {
                display: none;
            }

            .deposits-mobile-view {
                display: block;
            }

            .dashboard-header {
                margin-bottom: -50px;
                padding: 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }

            .card-actions-wrapper {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .filter-controls {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .btn-reset-filters {
                grid-column: span 2;
                width: 100%;
            }

            .search-group {
                width: 100%;
            }

            .deposit-card-mobile {
                background: #0f0f0f;
                border: 1px solid rgba(255, 0, 0, 0.15);
                border-radius: 16px;
                padding: 7px;
                margin-bottom: 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                position: relative;
                overflow: hidden;
            }

            .deposit-card-mobile::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #ff0000, transparent);
                opacity: 0.5;
            }

            .card-mobile-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 20px;
                position: relative;
            }

            .card-mobile-avatar {
                width: 50px;
                height: 50px;
                background: #ff0000;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 20px;
                flex-shrink: 0;
                box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
            }

            .card-mobile-identity {
                flex: 1;
            }

            .card-mobile-name {
                color: white;
                font-size: 15px;
                font-weight: 700;
                margin-bottom: 2px;
                line-height: 1.4;
                word-break: break-word;
            }

            .card-mobile-subtext {
                color: #ff3333;
                font-size: 12px;
                font-weight: 500;
                font-family: monospace;
            }

            .card-mobile-status {
                flex-shrink: 0;
                margin-left: auto;
                align-self: flex-start;
                padding-top: 5px;
            }

            .card-mobile-body {
                background: rgba(255, 255, 255, 0.02);
                border-radius: 12px;
                padding: 5px 15px;
                margin-bottom: 15px;
            }

            .card-mobile-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            }

            .card-mobile-row:last-child {
                border-bottom: none;
            }

            .card-row-label {
                display: flex;
                align-items: center;
                gap: 12px;
                color: rgba(255, 255, 255, 0.8);
                font-size: 14px;
            }

            .card-row-label i {
                width: 16px;
                font-size: 16px;
                color: rgba(255, 255, 255, 0.6);
            }

            .card-row-value {
                color: white;
                font-size: 14px;
                font-weight: 600;
                text-align: right;
            }

            .view-details-btn-mobile {
                width: 100%;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                padding: 10px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }
        }

        .modal-backdrop.show {
            backdrop-filter: blur(8px);
            background-color: rgba(0, 0, 0, 0.8) !important;
            opacity: 1 !important;
        }

        .modal-content {
            background: rgba(10, 10, 10, 0.8) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 0, 0, 0.2) !important;
            border-radius: 20px;
            color: var(--text-light);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(255, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-10deg);
            width: 300px;
            height: 300px;
            background: url("{{ getImage(getFilePath('logoIcon') . '/logo.png') }}") no-repeat center;
            background-size: contain;
            opacity: 0.05;
            z-index: 0;
            pointer-events: none;
            filter: grayscale(100%) brightness(2);
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 15px 20px !important;
            background: linear-gradient(135deg, rgba(139, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.95) 100%) !important;
            position: relative;
            z-index: 1;
            border-top: 2px solid #ff0000 !important;
        }

        .modal-title {
            color: var(--text-white);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .transaction-summary-header {
            background: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            position: relative;
            z-index: 1;
            padding-bottom: 25px !important;
        }

        .transaction-summary-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .details-section {
            position: relative;
            overflow: hidden;
        }

        .details-section::before {
            content: 'TRX';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            z-index: 0;
            pointer-events: none;
            letter-spacing: 10px;
        }

        .section-title {
            position: relative;
            z-index: 1;
            font-weight: 800 !important;
            letter-spacing: 1px;
        }

        .info-grid-modern {
            position: relative;
            z-index: 1;
        }

        .final-amount {
            font-size: 28px;
            font-weight: 800;
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 0, 0, 0.2) !important;
            padding: 20px !important;
            background: rgba(0, 0, 0, 0.3) !important;
            display: flex !important;
            justify-content: flex-end !important;
        }

        .btn-close-modal {
            background: var(--gradient-red) !important;
            color: white !important;
            border: none !important;
            padding: 12px 24px !important;
            border-radius: 8px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        .btn-close-modal:hover {
            background: var(--light-red) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.4) !important;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: var(--text-white) !important;
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            font-size: 14px !important;
            padding: 0 !important;
            line-height: 1 !important;
        }

        .close-btn:hover {
            background: #ff0000 !important;
            color: white !important;
            transform: rotate(90deg) !important;
            border-color: transparent !important;
        }

        .info-grid-modern {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item-modern {
            background: rgba(255, 255, 255, 0.03);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-item-modern .label {
            font-size: 11px;
            color: var(--text-muted);
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .info-item-modern .value {
            font-size: 14px;
            color: white;
            font-weight: 600;
        }

        .btn-download {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn {
            background: #cc0000;
            border: none;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(204, 0, 0, 0.3);
            margin: 0 auto;
        }

        .action-btn:hover {
            background: #ff0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 0, 0, 0.4);
        }



        footer {
            display: none !important;
        }

        /* Empty State Styling */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            animation: fadeIn 0.8s ease;
        }

        .empty-icon {
            font-size: 60px;
            color: var(--light-red);
            margin-bottom: 20px;
            opacity: 0.3;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .empty-state h4 {
            color: var(--text-white);
            margin-bottom: 10px;
            font-size: 20px;
        }

        .empty-state p {
            margin-bottom: 30px;
            font-size: 14px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .btn-new-deposit {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--gradient-red);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-new-deposit:hover {
            background: var(--light-red);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(255, 0, 0, 0.4);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="video-background">
            <video autoplay muted loop id="myVideo">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-abstract-red-waves-1175-large.mp4"
                    type="video/mp4">
            </video>
        </div>

        <div class="dashboard-header">
            <div class="header-top">
                <div class="user-greeting">
                    <div class="greeting-icon"></div>
                    <div class="greeting-text">
                        <h1>Transaction History</h1>
                        <p class="user-id"><i class="fas fa-user-shield"></i> UID: <span
                                class="user-id-value">{{ auth()->user()->username }}</span> <span class="status-online"><i
                                    class="fas fa-circle"></i> Online</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="deposit-history-container">
            <div class="card deposit-card">
                <div class="card-header">
                    <h3><i class="fas fa-list-alt"></i> Transaction History</h3>
                    <div class="card-actions-wrapper">
                        <div class="filter-controls">
                            <select id="typeFilter" onchange="applyTrxFilters()" class="filter-select">
                                <option value="all">All Types</option>
                                <option value="+" @selected(request()->trx_type == '+')>Income</option>
                                <option value="-" @selected(request()->trx_type == '-')>Expense</option>
                            </select>
                            <select id="remarkFilter" onchange="applyTrxFilters()" class="filter-select">
                                <option value="all">All Remarks</option>
                                @foreach($remarks as $remark)
                                    @continue($remark->remark == 'referral_commission')
                                    <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                        {{ __(keyToTitle($remark->remark)) }}
                                    </option>
                                @endforeach
                            </select>
                            <button onclick="resetTrxFilters()" class="btn-reset-filters"><i class="fas fa-sync-alt"></i>
                                <span>Reset</span></button>
                        </div>
                        <div class="search-group">
                            <input type="text" id="trxSearch" onkeyup="applyTrxFilters()" class="search-input"
                                placeholder="Search TRX...">
                            <div class="search-icon-box"><i class="fas fa-search"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="deposits-table desktop-view">
                    <table class="deposit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date & Time</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Post Balance</th>
                                <th>Details</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                                <tr class="trx-row-item" data-trx="{{ $trx->trx }}" data-type="{{ $trx->trx_type }}"
                                    data-remark="{{ $trx->remark }}" data-details="{{ strtolower(__($trx->details)) }}"
                                    data-date="{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}"
                                    data-amount="{{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}"
                                    data-charge="{{ showAmount($trx->charge) }} {{ __($general->cur_text) }}"
                                    data-post_balance="{{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}"
                                    data-remark_title="{{ __(keyToTitle($trx->remark)) }}">
                                    <td>
                                        <span class="serial-number">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <div class="date-time-cell">
                                            <div class="date">{{ showDateTime($trx->created_at, 'd M, Y') }}</div>
                                            <div class="time">{{ showDateTime($trx->created_at, 'h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <code class="trx-code">{{ $trx->trx }}</code>
                                    </td>
                                    <td>
                                        <div class="amount-cell {{ $trx->trx_type == '+' ? 'amount-plus' : 'amount-minus' }}">
                                            <span class="amount-main">{{ $trx->trx_type }}{{ showAmount($trx->amount) }}</span>
                                            <span class="currency">{{ __($general->cur_text) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="post-balance-cell">
                                            {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="details-cell">{{ __($trx->details) }}</div>
                                    </td>
                                    <td class="text-center">
                                        <button class="action-btn viewTrxBtn"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-folder-open"></i>
                                            </div>
                                            <h4>No Transaction History Found</h4>
                                            <p>Your transaction records will appear here as you interact with the platform.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            <!-- No results row (hidden by default) -->
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-search-minus"></i>
                                        </div>
                                        <h4 id="noResultsTitle">No Matching Results</h4>
                                        <p id="noResultsDesc">Try adjusting your filters or search terms.</p>
                                        <button type="button" onclick="resetTrxFilters()" class="btn-new-deposit">Show All History</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="deposits-mobile-view">
                    @forelse($transactions as $trx)
                        <div class="deposit-card-mobile trx-mobile-item" data-trx="{{ $trx->trx }}"
                            data-type="{{ $trx->trx_type }}" data-remark="{{ $trx->remark }}"
                            data-details="{{ strtolower(__($trx->details)) }}"
                            data-date="{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}"
                            data-amount="{{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}"
                            data-charge="{{ showAmount($trx->charge) }} {{ __($general->cur_text) }}"
                            data-post_balance="{{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}"
                            data-remark_title="{{ __(keyToTitle($trx->remark)) }}">
                            <div class="card-mobile-header">
                                <div class="card-mobile-avatar">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="card-mobile-identity">
                                    <div class="card-mobile-name">{{ __($trx->details) }}</div>
                                    <div class="card-mobile-subtext">{{ $trx->trx }}</div>
                                </div>
                                <div class="card-mobile-status">
                                    <span class="badge"
                                        style="background: transparent; color: {{ $trx->trx_type == '+' ? '#00ff00' : '#ff3333' }}; font-weight: 700; border: 1px solid currentColor;">
                                        {{ $trx->trx_type }}{{ showAmount($trx->amount) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-mobile-body">
                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-calendar-alt"></i> <span>Date & Time</span>
                                    </div>
                                    <div class="card-row-value">{{ showDateTime($trx->created_at, 'd M, Y | h:i A') }}</div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-money-bill-wave"></i> <span>Amount</span>
                                    </div>
                                    <div class="card-row-value"
                                        style="color: {{ $trx->trx_type == '+' ? '#00ff00' : '#ff3333' }}; font-weight: 700;">
                                        {{ $trx->trx_type }}{{ showAmount($trx->amount) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-minus-circle"></i> <span>Charge</span>
                                    </div>
                                    <div class="card-row-value text--danger">
                                        {{ showAmount($trx->charge) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-wallet"></i> <span>Post Balance</span>
                                    </div>
                                    <div class="card-row-value" style="color: #fff; font-weight: 600;">
                                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>

                                <div class="card-mobile-row" style="border:none;">
                                    <div class="card-row-label">
                                        <i class="fas fa-tag"></i> <span>Category</span>
                                    </div>
                                    <div class="card-row-value"
                                        style="font-size: 11px; font-weight: 400; max-width: 60%; text-align: right; color: var(--text-muted);">
                                        {{ __(keyToTitle($trx->remark)) }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-mobile-actions">
                                <button class="view-details-btn-mobile viewTrxBtn"><i class="fas fa-eye"></i> View Full Details</button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h4>No Transaction History Found</h4>
                            <p>Your transaction records will appear here.</p>
                        </div>
                    @endforelse
                    <div id="noResultsMobile" style="display: none;">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h4 id="noResultsTitleMobile">No Matching Results</h4>
                            <p id="noResultsDescMobile">No record matches your current filters.</p>
                            <button type="button" onclick="resetTrxFilters()" class="btn-new-deposit">Show All History</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Transaction Detail Modal - SAME AS DEPOSIT HISTORY -->
    <div id="trxModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-receipt"></i> Transaction Receipt</h5>

                    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="transaction-summary-header text-center p-3">
                        <div id="modalStatusIcon" class="status-icon-wrapper mb-2">
                            <!-- JS will inject icon here -->
                        </div>
                        <h3 id="modalAmountText" class="final-amount mb-1 text-white font-weight-bold"></h3>
                        <div id="modalRemarkBadge" class="status-label-badge mb-1">
                            <!-- JS will inject badge here -->
                        </div>
                    </div>

                    <div class="details-section p-3">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i
                                class="fas fa-info-circle mr-2"></i> CORE INFORMATION</h6>
                        <div class="info-grid-modern">
                            <div class="info-item-modern">
                                <span class="label text-muted small">Transaction ID</span>
                                <span id="modalTrxId" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Type</span>
                                <span id="modalType" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Date & Time</span>
                                <span id="modalDate" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Post Balance</span>
                                <span id="modalPostBalance" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern" style="grid-column: span 2;">
                                <span class="label text-muted small">Transaction Details</span>
                                <span id="modalDetails" class="value text-white d-block" style="font-weight: 400;"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Receipt Template for PDF -->
                    <div style="position: absolute; left: -9999px; top: -9999px;">
                        <div id="printableTrxInvoice"
                            style="background: white; color: black; padding: 50px; font-family: 'Helvetica', sans-serif; width: 800px; position: relative;">
                            <div class="pdf-watermark"
                                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); opacity: 0.08; z-index: 0; pointer-events: none; width: 80%; text-align: center;">
                                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                                    style="width: 100%; filter: grayscale(100%);">
                            </div>

                            <div style="position: relative; z-index: 1;">
                                <div
                                    style="border-bottom: 3px solid #e1211b; padding-bottom: 25px; margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}"
                                            style="height: 80px; margin-bottom: 15px;">
                                        <h1 style="color: #e1211b; margin: 0; font-size: 32px; letter-spacing: 1px;">
                                            TRANSACTION RECEIPT</h1>
                                        <p style="margin: 5px 0; color: #555; font-size: 14px;">Transaction No: <span
                                                id="pdfTrxId" style="font-weight: bold; color: #000;"></span></p>
                                    </div>
                                    <div style="text-align: right;">
                                        <h2 style="margin: 0; font-size: 22px; color: #333;">{{ __($general->site_name) }}
                                        </h2>
                                        <p style="margin: 5px 0; color: #e1211b; font-weight: bold;">
                                            {{ request()->getHost() }}
                                        </p>
                                        <p style="margin: 5px 0; color: #888; font-size: 13px;">Date: <span
                                                id="pdfDate"></span></p>
                                    </div>
                                </div>

                                <div
                                    style="margin-bottom: 50px; display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p
                                            style="color: #888; text-transform: uppercase; font-size: 12px; margin-bottom: 8px; font-weight: bold;">
                                            Transaction Amount</p>
                                        <h3 id="pdfAmountText"
                                            style="font-size: 48px; margin: 0; color: #111; font-weight: 800;"></h3>
                                    </div>
                                    <div style="text-align: center;">
                                        <div
                                            style="display: inline-block; padding: 10px 25px; border-radius: 50px; font-weight: 800; font-size: 16px; text-transform: uppercase; border: 2px solid #008000; color: #008000; background: #e8f7f0;">
                                            COMPLETED
                                        </div>
                                    </div>
                                </div>

                                <div
                                    style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 50px; margin-bottom: 60px;">
                                    <div
                                        style="background: #fdfdfd; padding: 25px; border-radius: 15px; border: 1px solid #eee;">
                                        <h4
                                            style="margin: 0 0 15px 0; color: #e1211b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                                            Summary Details</h4>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Account Holder</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">{{ auth()->user()->username }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Transaction Remark</td>
                                                <td id="pdfRemark"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Post Balance</td>
                                                <td id="pdfPostBalance"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div
                                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                                        <div
                                            style="width: 160px; height: 160px; border: 4px double #e1211b; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; transform: rotate(-15deg); color: #e1211b; background: rgba(225, 33, 27, 0.02);">
                                            <span
                                                style="font-size: 12px; font-weight: bold; text-transform: uppercase;">Official
                                                Seal</span>
                                            <span
                                                style="font-size: 16px; font-weight: 900; margin: 5px 0;">{{ __($general->site_name) }}</span>
                                            <div style="width: 80%; height: 1px; background: #e1211b; margin: 5px 0;"></div>
                                            <span
                                                style="font-size: 10px; font-weight: bold;">{{ request()->getHost() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    style="padding: 20px; background: #fdfdfd; border: 1px solid #eee; border-radius: 12px; margin-bottom: 30px;">
                                    <h5 style="margin: 0 0 10px 0; color: #888; font-size: 12px; text-transform: uppercase;">Description / Note:</h5>
                                    <p id="pdfDetails" style="margin: 0; color: #333; font-size: 14px; line-height: 1.6; font-style: italic;"></p>
                                </div>

                                <div style="border-top: 1px solid #eee; padding-top: 30px; text-align: center;">
                                    <p style="color: #333; font-weight: bold; margin-bottom: 5px;">This is a system generated document.</p>
                                    <p style="color: #999; font-size: 11px; margin: 0;">© {{ date('Y') }}
                                        {{ __($general->site_name) }}. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-red" style="display: flex !important; justify-content: flex-end !important;">
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> OK, Got it
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            "use strict";

            // Consolidated Filter Logic - Optimized for speed and accuracy
            window.applyTrxFilters = function() {
                const searchTerm = $('#trxSearch').val().toLowerCase().trim();
                const typeTerm = $('#typeFilter').val();
                const remarkTerm = $('#remarkFilter').val();

                let desktopMatched = 0;
                let mobileMatched = 0;

                // Process Desktop Rows
                $('.trx-row-item').each(function() {
                    const trx = ($(this).attr('data-trx') || '').toLowerCase();
                    const details = ($(this).attr('data-details') || '').toLowerCase();
                    const type = $(this).attr('data-type');
                    const remark = $(this).attr('data-remark');

                    const matchSearch = searchTerm === "" || trx.includes(searchTerm) || details.includes(searchTerm);
                    const matchType = typeTerm === 'all' || type === typeTerm;
                    const matchRemark = remarkTerm === 'all' || remark === remarkTerm;

                    if (matchSearch && matchType && matchRemark) {
                        $(this).addClass('matched').fadeIn(200);
                        desktopMatched++;
                    } else {
                        $(this).removeClass('matched').hide();
                    }
                });

                // Process Mobile Rows
                $('.trx-mobile-item').each(function() {
                    const trx = ($(this).attr('data-trx') || '').toLowerCase();
                    const details = ($(this).attr('data-details') || '').toLowerCase();
                    const type = $(this).attr('data-type');
                    const remark = $(this).attr('data-remark');

                    const matchSearch = searchTerm === "" || trx.includes(searchTerm) || details.includes(searchTerm);
                    const matchType = typeTerm === 'all' || type === typeTerm;
                    const matchRemark = remarkTerm === 'all' || remark === remarkTerm;

                    if (matchSearch && matchType && matchRemark) {
                        $(this).addClass('matched').fadeIn(200);
                        mobileMatched++;
                    } else {
                        $(this).removeClass('matched').hide();
                    }
                });

                // Handle Empty States
                if (desktopMatched === 0) $('#noResultsRow').show();
                else $('#noResultsRow').hide();

                if (mobileMatched === 0) $('#noResultsMobile').show();
                else $('#noResultsMobile').hide();
            };

            window.resetTrxFilters = function() {
                $('#trxSearch').val('');
                $('#typeFilter').val('all');
                $('#remarkFilter').val('all');
                $('.trx-row-item, .trx-mobile-item').addClass('matched').fadeIn(200);
                $('#noResultsRow, #noResultsMobile').hide();
            };

            function scrollToTable() {
                const tablePos = $('.deposit-history-container').offset().top - 50;
                $('html, body').animate({ scrollTop: tablePos }, 500);
            }
            // Transaction Modal Implementation - Using delegation for reliability
            $(document).on('click', '.viewTrxBtn', function () {
                const parent = $(this).closest('[data-trx]');
                const modal = $('#trxModal');

                const amount = parent.data('amount');
                const type = parent.data('type');
                const remark_title = parent.data('remark_title');

                // Populate Modal Summary
                modal.find('#modalAmountText').text(amount);
                modal.find('#modalAmountText').css('color', type === '+' ? '#00ff00' : '#ff3333');

                const statusClass = type === '+' ? 'success' : 'danger';
                modal.find('#modalRemarkBadge').html(`<span class="badge badge--${statusClass} text-uppercase px-3 py-2" style="letter-spacing: 1px; border: 1px solid currentColor; background: transparent;">${remark_title}</span>`);

                modal.find('#modalStatusIcon').html(type === '+' ?
                    '<i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>' :
                    '<i class="fas fa-arrow-circle-up text-danger" style="font-size: 40px;"></i>'
                );

                // Populate Grid Data
                modal.find('#modalTrxId').text(parent.data('trx'));
                modal.find('#modalType').text(type === '+' ? 'Income / Credit' : 'Expense / Debit');
                modal.find('#modalDate').text(parent.data('date'));
                modal.find('#modalPostBalance').text(parent.data('post_balance'));
                modal.find('#modalDetails').text(parent.data('details').charAt(0).toUpperCase() + parent.data('details').slice(1));

                // Sync with PDF Template
                modal.find('#pdfTrxId').text(parent.data('trx'));
                modal.find('#pdfAmountText').text(amount);
                modal.find('#pdfAmountText').css('color', type === '+' ? '#008000' : '#d90000');
                modal.find('#pdfRemark').text(remark_title);
                modal.find('#pdfDate').text(parent.data('date'));
                modal.find('#pdfPostBalance').text(parent.data('post_balance'));
                modal.find('#pdfDetails').text(parent.data('details').charAt(0).toUpperCase() + parent.data('details').slice(1));

                modal.modal('show');
            });

            window.downloadTrxInvoice = function () {
                const trx = $('#modalTrxId').text();
                const element = document.getElementById('printableTrxInvoice');
                const opt = {
                    margin: 0.2,
                    filename: `Transaction_Receipt_${trx}.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { scale: 3, useCORS: true, letterRendering: true, logging: false },
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
            };



        });
    </script>
@endpush