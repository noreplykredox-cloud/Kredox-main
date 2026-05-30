@extends($activeTemplate . 'layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --card-black: rgba(17, 17, 17, 0.9);
            --text-white: #ffffff;
            --text-light: #e6e6e6;
            --text-muted: #999999;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --success-green: #00ff00;
            --border-red: rgba(255, 0, 0, 0.2);
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            background-color: var(--dark-black);
            color: var(--text-white);
            font-family: 'Inter', sans-serif;
        }

        .dashboard-container {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Tabs */
        .view-tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-red);
            padding-bottom: 10px;
        }

        .view-tab-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 600;
            padding: 10px 20px;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-tab-btn:hover {
            color: var(--text-white);
        }

        .view-tab-btn.active {
            color: var(--text-white);
        }

        .view-tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -11px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-red);
            border-radius: 3px 3px 0 0;
            box-shadow: var(--shadow-red);
        }

        /* Media queries for generic components remain if needed, but team-stat-card is removed */
        @media(max-width: 576px) {
            .view-tabs {
                flex-direction: row;
                gap: 10px;
            }

            .view-tab-btn {
                flex: 1;
                justify-content: center;
                padding: 10px 5px;
                font-size: 13px;
            }
        }

        /* Filter Section */
        .filter-section {
            margin-bottom: 30px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .filter-main-row {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 12px;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
            flex: 1;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .search-back-btn {
            display: none;
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 18px;
            cursor: pointer;
            z-index: 100;
        }

        .search-icon-main {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-red);
            font-size: 18px;
            z-index: 5;
            transition: opacity 0.3s;
        }

        .search-input {
            width: 100% !important;
            height: 55px;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--border-red) !important;
            border-radius: 15px !important;
            padding: 0 100px 0 55px !important;
            color: white !important;
            font-size: 16px !important;
            transition: var(--transition) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: block;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-red) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.25);
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .search-actions-inner {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 10;
        }

        /* Mobile Search Active Mode */
        @media(max-width: 768px) {
            body.search-mode-active {
                overflow: hidden !important;
            }

            body.search-mode-active::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                backdrop-filter: blur(10px);
                z-index: 9998;
            }

            .search-wrapper.mobile-active {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 65px;
                z-index: 9999;
                padding: 5px 10px;
                background: #000;
                display: flex;
                align-items: center;
                border-bottom: 1px solid var(--border-red);
            }

            .search-wrapper.mobile-active .search-input {
                height: 50px;
                border: none !important;
                background: transparent !important;
                padding-left: 50px !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .search-wrapper.mobile-active .search-icon-main {
                display: none;
            }

            .search-wrapper.mobile-active .search-back-btn {
                display: block;
            }

            .search-wrapper.mobile-active .suggestion-dropdown {
                position: fixed;
                top: 65px;
                left: 0;
                width: 100%;
                height: calc(100vh - 65px);
                max-height: none;
                border: none;
                border-radius: 0;
                background: #000;
            }
        }



        .selected-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            justify-content: flex-start;
            width: 100%;
        }

        .selected-tags:empty {
            display: none;
            margin-top: 0;
        }

        .tag-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 0, 0, 0.2);
            border-radius: 10px;
            padding: 5px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-white);
            font-size: 13px;
            animation: tagPop 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        @keyframes tagPop {
            from {
                transform: translateY(5px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .tag-img-box {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--dark-black);
            position: relative;
            overflow: hidden;
            border: 1.5px solid var(--accent-red);
            flex-shrink: 0;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.25);
            padding: 1px;
        }

        .tag-img-box i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 12px;
            color: white;
            margin: 0;
            padding: 0;
        }

        .tag-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .tag-remove {
            cursor: pointer;
            color: var(--text-muted);
            font-size: 14px;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .tag-remove:hover {
            color: var(--accent-red);
            transform: scale(1.1);
        }



        .reset-filter {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
            border: none;
            background: transparent;
        }

        .reset-filter:hover {
            color: var(--accent-red);
            transform: rotate(180deg) scale(1.1);
        }

        .info-icon:hover {
            color: var(--text-white);
            transform: scale(1.1);
        }

        .info-tooltip {
            position: absolute;
            bottom: calc(100% + 15px);
            right: 0;
            background: rgba(20, 20, 20, 0.98);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            width: 240px;
            line-height: 1.5;
            pointer-events: none;
            opacity: 0;
            transform: translateY(10px);
            transition: var(--transition);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.9);
            border: 1px solid var(--border-red);
            backdrop-filter: blur(20px);
            z-index: 2000;
            text-align: center;
        }

        .info-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            right: 25px;
            border: 8px solid transparent;
            border-top-color: var(--border-red);
        }

        .info-wrapper:hover .info-tooltip {
            opacity: 1;
            transform: translateY(0);
        }



        .info-wrapper {
            cursor: help;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-icon {
            color: var(--text-muted);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: var(--transition);
        }

        .reset-filter {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .reset-filter:hover {
            color: var(--accent-red);
            transform: rotate(180deg);
        }

        .suggestion-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            width: 100%;
            background: rgba(18, 18, 18, 0.98);
            border: 1px solid rgba(255, 0, 0, 0.3);
            border-radius: 15px;
            max-height: 350px;
            overflow-y: auto;
            z-index: 1100;
            display: none;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(30px);
        }

        /* Custom Scrollbar for Suggestions */
        .suggestion-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .suggestion-dropdown::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .suggestion-dropdown::-webkit-scrollbar-thumb {
            background: var(--accent-red);
            border-radius: 10px;
        }

        .suggestion-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            border-left: 3px solid transparent;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover,
        .suggestion-item.active {
            background: linear-gradient(90deg, rgba(255, 0, 0, 0.1) 0%, transparent 100%);
            padding-left: 32px;
            border-left-color: var(--accent-red);
        }

        .suggestion-item:hover .suggest-img,
        .suggestion-item.active .suggest-img {
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.45);
            transform: scale(1.05);
            border-color: var(--light-red);
        }

        .suggest-img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--dark-black);
            position: relative;
            overflow: hidden;
            border: 2px solid var(--accent-red);
            flex-shrink: 0;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.35);
            padding: 3px;
            transition: all 0.3s ease;
        }

        .suggest-img i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 26px;
            color: var(--text-muted);
            margin: 0;
            padding: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .suggest-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .suggest-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .suggest-name {
            color: white;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .suggest-username {
            color: var(--light-red);
            font-size: 13px;
            font-weight: 500;
            opacity: 0.8;
        }
        }

        /* Premium Table Styles */
        .deposit-card {
            background: rgba(10, 10, 10, 0.8) !important;
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-red) !important;
            border-radius: 20px !important;
            overflow: hidden;
        }

        .deposits-table {
            background: rgba(10, 10, 10, 0.8);
            border-radius: 20px;
            border: 1px solid var(--border-red);
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .deposit-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .deposit-table thead {
            background: rgba(255, 0, 0, 0.05);
        }

        .deposit-table th {
            padding: 18px 20px;
            color: var(--light-red);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1.5px;
            border-bottom: 1px solid var(--border-red);
            text-align: center;
        }

        .deposit-table td {
            padding: 20px;
            color: var(--text-light);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
            text-align: center;
            font-size: 14px;
        }

        .deposit-table th.left-aligned-header {
            text-align: left !important;
            padding-left: 97px !important;
            /* 30px cell padding + 52px avatar + 15px gap */
        }

        .user-profile-cell {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
            text-align: left;
            padding-left: 30px;
        }

        .user-profile-img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--dark-black);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--accent-red);
            overflow: hidden;
            color: white;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.35);
            padding: 3px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .user-profile-cell:hover .user-profile-img {
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
            transform: scale(1.05);
        }

        .user-profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-width: 0;
            /* Important for ellipsis */
        }

        .user-profile-info .name {
            font-weight: 700;
            color: var(--text-white);
            font-size: 16px;
            text-transform: capitalize;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            display: block;
        }

        .user-profile-info .username {
            color: var(--light-red);
            font-size: 13px;
            font-weight: 500;
        }

        .level-badge {
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid rgba(255, 0, 0, 0.2);
            display: inline-block;
            text-transform: uppercase;
        }

        /* Mobile Premium View */
        .deposits-mobile-view {
            display: none;
        }

        @media(max-width: 768px) {
            .deposits-table {
                display: none;
            }

            .deposits-mobile-view {
                display: block;
            }

            .deposit-card-mobile {
                background: rgba(15, 15, 15, 0.8);
                backdrop-filter: blur(15px);
                border-radius: 18px;
                border: 1px solid var(--border-red);
                margin-bottom: 20px;
                padding: 0;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            }

            .card-mobile-header {
                padding: 15px 20px;
                background: rgba(255, 255, 255, 0.03);
                display: flex;
                align-items: center;
                gap: 15px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .card-mobile-avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: var(--dark-black);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 18px;
                border: 1.5px solid var(--accent-red);
                box-shadow: 0 0 12px rgba(255, 0, 0, 0.35);
                flex-shrink: 0;
                overflow: hidden;
                padding: 2px;
            }

            .card-mobile-avatar img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }

            .card-mobile-identity {
                flex-grow: 1;
            }

            .card-mobile-name {
                color: white;
                font-size: 16px;
                font-weight: 700;
                margin-bottom: 2px;
            }

            .card-mobile-subtext {
                color: var(--light-red);
                font-size: 13px;
                font-weight: 500;
            }

            .card-mobile-status {
                flex-shrink: 0;
            }

            .card-mobile-body {
                padding: 5px 20px 15px;
            }

            .card-mobile-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .card-mobile-row:last-child {
                border-bottom: none;
            }

            .card-row-label {
                display: flex;
                align-items: center;
                gap: 12px;
                color: var(--text-muted);
                font-size: 14px;
            }

            .card-row-label i {
                width: 16px;
                font-size: 16px;
                color: var(--light-red);
            }

            .card-row-value {
                color: white;
                font-size: 14px;
                font-weight: 700;
                text-align: right;
            }
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
        }

        .empty-icon {
            font-size: 60px;
            color: var(--light-red);
            margin-bottom: 25px;
            opacity: 0.5;
        }

        .empty-state h4 {
            color: white;
            font-weight: 700;
            margin-bottom: 10px;
        }



        /* Standardized Header Styles */
            .dashboard-header {
                background: var(--gradient-black);
                border-radius: 15px;
                border: 1px solid var(--border-red);
                padding: 0;
                margin-bottom: 30px;
                box-shadow: var(--shadow-card);
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

            .inner-header-box {
                border-radius: 8px;
                padding: 0px;
            }

            .greeting-text h1 {
                color: white;
                font-size: 24px;
                margin: 0;
                font-weight: 700;
            }

            .greeting-text p {
                color: var(--text-muted);
                margin: 5px 0 0 0;
                font-size: 14px;
            }
        </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="header-top">
                <div class="user-greeting" style="padding: 15px 20px;">
                    <div class="greeting-text">
                        <h1>My Team Network</h1>
                        <p>Manage and visualize your referral downline</p>
                    </div>
                </div>
            </div>
            <div class="header-bottom">
                <div class="referral-box premium-node-card">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <p class="referral-label mb-0"><i class="fas fa-link text-danger me-2"></i> UNIQUE REFERRAL LINK</p>
                        <span class="badge-status-node"><i class="fas fa-check-circle me-1"></i> ACTIVE</span>
                    </div>
                    <p class="node-description-text mb-3">
                        Use this unique referral link to invite partners and grow your network. Share it to connect them directly to your 4X Elite Strategy Network and earn team commissions.
                    </p>
                    <div class="referral-input-group">
                        <input type="text" name="key" value="{{ route('user.register') }}?node=NODE_{{ bin2hex($user->username) }}"
                            class="referral-input node-input-glow" id="nodeLink" readonly>
                        <button type="button" class="copy-btn btn-node-glow" id="copyBoard">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @php
            function flattenReferrals($user, $layer = 1, $maxLevel = 10)
            {
                $result = [];
                foreach ($user->allReferrals as $referral) {
                    $result[] = [
                        'user' => $referral,
                        'level' => $layer,
                        'parentObj' => $user
                    ];
                    if ($layer < $maxLevel && $referral->allReferrals->count()) {
                        $result = array_merge($result, flattenReferrals($referral, $layer + 1, $maxLevel));
                    }
                }
                return $result;
            }

            $allReferrals = flattenReferrals($user, 1, $general->matrix_height ?? 10);

            // Collect Unique Uplines for Autocomplete
            $uniqueUplines = [];
            foreach ($allReferrals as $ref) {
                if (isset($ref['parentObj']) && $ref['parentObj']) {
                    $u = $ref['parentObj'];
                    if (!isset($uniqueUplines[$u->id])) {
                        $uniqueUplines[$u->id] = [
                            'id' => $u->id,
                            'name' => $u->fullname,
                            'username' => $u->username,
                            'image' => $u->image ? getImage(getFilePath('userProfile') . '/' . $u->image) : null
                        ];
                    }
                }
            }
            $uniqueUplinesJson = json_encode(array_values($uniqueUplines));

            $allIds = array_map(function ($item) {
                return $item['user']->id;
            }, $allReferrals);
            $directIds = $user->allReferrals->pluck('id')->toArray();

            $totalMembers = count($allReferrals);
            $directMembers = count($directIds);

            $totalBusiness = count($allIds) > 0 ? \DB::table('transactions')->where('remark', 'plan_purchase')->whereIn('user_id', $allIds)->sum('amount') : 0;
            $directBusiness = count($directIds) > 0 ? \DB::table('transactions')->where('remark', 'plan_purchase')->whereIn('user_id', $directIds)->sum('amount') : 0;
        @endphp

        <!-- Quick Stats Summary -->
        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Team Members</h4>
                    <h3>{{ $totalMembers }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-network-wired"></i> Network
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Team Business</h4>
                    <h3>{{ number_format($totalBusiness, 2) }} {{ $general->cur_text }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-check-circle"></i> Active
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stat-info">
                    <h4>Direct Members</h4>
                    <h3>{{ $directMembers }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-link"></i> Direct
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="stat-info">
                    <h4>Direct Team Business</h4>
                    <h3>{{ number_format($directBusiness, 2) }} {{ $general->cur_text }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-coins"></i> Revenue
                </div>
            </div>
        </div>

        <!-- View Toggle Tabs -->
        <div class="view-tabs">
            <button type="button" class="view-tab-btn active" onclick="switchView('table')">
                <i class="fas fa-table"></i> Table View
            </button>
            <button type="button" class="view-tab-btn" onclick="switchView('tree')">
                <i class="fas fa-sitemap"></i> Tree View
            </button>
        </div>

        <div class="filter-section" id="multiSelectBox">
            <div class="filter-main-row">
                <div class="search-wrapper" id="searchWrapper">
                    <div class="search-back-btn" onclick="exitSearchMode()">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <i class="fas fa-search search-icon-main"></i>
                    <input type="text" id="uplineSearch" class="search-input" placeholder="Search team members..."
                        autocomplete="off" onfocus="enterSearchMode()">

                    <div class="search-actions-inner">
                        <div class="info-wrapper">
                            <div class="info-icon"><i class="fas fa-question-circle"></i></div>
                            <div class="info-tooltip">
                                Selecting a member will instantly display their entire downline team network.
                            </div>
                        </div>
                        <div class="reset-filter" onclick="clearAllFilters()" title="Reset all filters">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                    </div>

                    <div id="suggestionDropdown" class="suggestion-dropdown"></div>
                </div>
            </div>
            <div id="selectedTags" class="selected-tags"></div>
        </div>

        <!-- TABLE VIEW -->
        <div id="tableView" class="view-section active">
            <!-- Desktop Table View -->
            <div class="deposits-table desktop-view">
                <table class="deposit-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">S.N.</th>
                            <th class="left-aligned-header">Member Details</th>
                            <th class="left-aligned-header">Direct Upline</th>
                            <th>Team Size</th>
                            <th>Investment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($allReferrals) > 0)
                            @foreach($allReferrals as $index => $ref)
                                @php
                                    $investAmount = $ref['user']->invest_amount;
                                    $teamSize = $ref['user']->allReferrals->count();
                                @endphp
                                <tr class="table-row-item">
                                    <td>
                                        <span style="color:var(--light-red); font-weight:700;">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="user-profile-cell">
                                            <div class="user-profile-img">
                                                @if($ref['user']->image)
                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $ref['user']->image) }}"
                                                        alt="Avatar">
                                                @else
                                                    <i class="fas fa-user"></i>
                                                @endif
                                            </div>
                                            <div class="user-profile-info">
                                                <span class="name">{{ $ref['user']->fullname }}</span>
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <span class="username">@​{{ $ref['user']->username }}</span>
                                                    <span class="level-badge">L{{ $ref['level'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if(isset($ref['parentObj']) && $ref['parentObj'])
                                            <div class="user-profile-cell">
                                                <div class="user-profile-img" style="width:44px; height:44px;">
                                                    @if($ref['parentObj']->image)
                                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $ref['parentObj']->image) }}"
                                                            alt="Avatar">
                                                    @else
                                                        <i class="fas fa-user" style="font-size:14px;"></i>
                                                    @endif
                                                </div>
                                                <div class="user-profile-info">
                                                    <span class="name" style="font-size:13px;">{{ $ref['parentObj']->fullname }}</span>
                                                    <span class="username"
                                                        style="font-size:11px;">@​{{ $ref['parentObj']->username }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Direct</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                            <span style="color:white; font-weight:800; font-size: 16px;">{{ $teamSize }}</span>
                                            <span
                                                style="font-size: 10px; text-transform: uppercase; color: var(--text-muted);">Members</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                            <span
                                                style="color:var(--success-green); font-weight:800; font-size: 16px;">${{ number_format($investAmount, 2) }}</span>
                                            <span
                                                style="font-size: 10px; text-transform: uppercase; color: var(--text-muted);">USDT</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-users-slash"></i></div>
                                        <h4>No Team Members Found</h4>
                                        <p class="text-muted">Start sharing your referral link to build your team!</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Mobile Premium Cards View -->
            <div class="deposits-mobile-view">
                @if(count($allReferrals) > 0)
                    @foreach($allReferrals as $index => $ref)
                        @php
                            $investAmount = $ref['user']->invest_amount;
                            $teamSize = $ref['user']->allReferrals->count();
                        @endphp
                        <div class="deposit-card-mobile mobile-card-item">
                            <div class="card-mobile-header">
                                <div class="card-mobile-avatar">
                                    @if($ref['user']->image)
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $ref['user']->image) }}">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <div class="card-mobile-identity">
                                    <div class="card-mobile-name">{{ $ref['user']->fullname }}</div>
                                    <div class="card-mobile-subtext">@​{{ $ref['user']->username }}</div>
                                </div>
                                <div class="card-mobile-status">
                                    <span class="level-badge">Level {{ $ref['level'] }}</span>
                                </div>
                            </div>

                            <div class="card-mobile-body">
                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-sitemap"></i> <span>Upline</span>
                                    </div>
                                    <div class="card-row-value">
                                        @if(isset($ref['parentObj']) && $ref['parentObj'])
                                            <div style="display: flex; align-items: center; gap: 8px; justify-content: flex-end;">
                                                <div
                                                    style="width: 28px; height: 28px; border-radius: 50%; background: var(--dark-black); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1.5px solid var(--accent-red); box-shadow: 0 0 8px rgba(255, 0, 0, 0.25); padding: 2px;">
                                                    @if($ref['parentObj']->image)
                                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $ref['parentObj']->image) }}"
                                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                                    @else
                                                        <i class="fas fa-user" style="font-size: 11px; color: var(--text-muted);"></i>
                                                    @endif
                                                </div>
                                                <span>{{ $ref['parentObj']->fullname }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">Direct</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-users"></i> <span>Team Size</span>
                                    </div>
                                    <div class="card-row-value">{{ $teamSize }} Members</div>
                                </div>
                                <div class="card-mobile-row">
                                    <div class="card-row-label">
                                        <i class="fas fa-chart-bar"></i> <span>Investment</span>
                                    </div>
                                    <div class="card-row-value" style="color: var(--success-green);">
                                        ${{ number_format($investAmount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-users-slash"></i></div>
                        <h4>No Team Members Found</h4>
                    </div>
                @endif
            </div>
        </div>

        <!-- TREE VIEW -->
        <div id="treeView" class="view-section" style="display: none;">
            @php
                function getFlatOrgChartData($rootUser)
                {
                    $flatData = [];
                    $queue = [
                        ['user' => $rootUser, 'parentId' => '', 'level' => 0]
                    ];

                    while (count($queue) > 0) {
                        $current = array_shift($queue);
                        $u = $current['user'];
                        $pid = $current['parentId'];
                        $lvl = $current['level'];

                        $img = $u->image ? getImage(getFilePath('userProfile') . '/' . $u->image) : '';

                        $flatData[] = [
                            'id' => (string) $u->id,
                            'parentId' => $pid,
                            'name' => $u->fullname,
                            'username' => $u->username,
                            'image' => $img,
                            'level' => $lvl,
                            'teamSize' => count($u->allReferrals),
                            'volume' => $u->invest_amount
                        ];

                        if ($u->allReferrals) {
                            foreach ($u->allReferrals as $child) {
                                $queue[] = ['user' => $child, 'parentId' => (string) $u->id, 'level' => $lvl + 1];
                            }
                        }
                    }
                    return $flatData;
                }
                $orgChartData = getFlatOrgChartData($user);
                $orgChartJson = json_encode($orgChartData);
            @endphp

            <div class="tree-container" style="padding:0; position: relative;">
                <div id="chart-container"
                    style="background: var(--dark-black); width: 100%; border-radius: 12px; height: 75vh; border: 1px solid rgba(255,0,0,0.1); box-shadow: 0 4px 20px rgba(0,0,0,0.2); overflow:hidden; touch-action: none;">
                </div>
            </div>
        </div>
    </div>

    <!-- Node Details Modal -->
    <div id="nodeDetailModal" class="custom-modal-overlay">
        <div class="custom-modal-card">
            <div class="modal-header">
                <h5 class="modal-title">Member Profile</h5>
                <button type="button" class="modal-close" onclick="closeNodeModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body text-center">
                <div class="modal-avatar" id="modalUserAvatar">
                    <!-- Avatar injected via JS -->
                </div>
                <h4 class="modal-user-name" id="modalUserName"></h4>
                <p class="modal-user-username" id="modalUserUsername"></p>

                <div class="modal-stats-grid">
                    <div class="modal-stat-box">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-title">Team Size</div>
                        <div class="stat-value" id="modalUserTeam"></div>
                    </div>
                    <div class="modal-stat-box">
                        <div class="stat-icon" style="color:var(--success-green); background:rgba(46,213,115,0.1);"><i
                                class="fas fa-coins"></i></div>
                        <div class="stat-title">Investment</div>
                        <div class="stat-value" id="modalUserVol" style="color:var(--success-green);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .custom-modal-overlay.active {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .custom-modal-card {
            background: var(--card-black);
            border: 1px solid rgba(255, 0, 0, 0.2);
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .custom-modal-overlay.active .custom-modal-card {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modal-title {
            color: var(--text-white);
            margin: 0;
            font-weight: 600;
            font-size: 18px;
        }

        .modal-close {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: var(--light-red);
        }

        .modal-body {
            padding: 30px;
        }

        .modal-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 2px solid var(--accent-red);
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--dark-black);
            overflow: hidden;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
            padding: 4px;
        }

        .modal-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .modal-avatar i {
            font-size: 40px;
            color: var(--text-muted);
        }

        .modal-user-name {
            color: var(--text-white);
            margin-bottom: 5px;
            font-size: 20px;
            font-weight: 700;
        }

        .modal-user-username {
            color: var(--light-red);
            margin-bottom: 25px;
            font-size: 14px;
        }

        .modal-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .modal-stat-box {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .stat-title {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .stat-value {
            color: var(--text-white);
            font-size: 18px;
            font-weight: 700;
        }

        .custom-pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            font-family: inherit;
        }

        .custom-pagination .rows-per-page {
            display: flex;
            align-items: center;
            white-space: nowrap;
            margin-right: 25px;
        }

        .custom-pagination label {
            margin-right: 15px;
            margin-bottom: 0;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.7);
        }

        .custom-pagination .select-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .custom-pagination .select-wrapper::after {
            content: '\25BC';
            /* Down Arrow */
            font-size: 9px;
            color: rgba(255, 255, 255, 0.7);
            margin-left: 8px;
            pointer-events: none;
        }

        .custom-pagination select {
            background: transparent;
            border: none;
            color: var(--text-white);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 5px;
        }

        .custom-pagination select option {
            background: var(--card-black);
            color: var(--text-white);
        }

        .custom-pagination .pagination-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .custom-pagination .page-info {
            white-space: nowrap;
            margin-right: 15px;
        }

        .page-controls {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .page-controls button {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            padding: 5px 8px;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-controls button:hover:not(:disabled) {
            color: var(--text-white);
        }

        .page-controls button:disabled {
            color: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
        }

        /* Mobile specifically */
        @media(max-width: 768px) {
            .custom-pagination {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 15px 10px;
            }

            .custom-pagination .rows-per-page {
                margin-right: 0;
                margin-bottom: 15px;
                width: 50%;
            }

            .custom-pagination .pagination-right {
                width: 50%;
                justify-content: flex-end;
                margin-bottom: 15px;
            }

            .custom-pagination .page-info {
                margin-right: 5px;
            }

            .page-controls {
                width: 100%;
                justify-content: flex-end;
                margin-top: -10px;
            }
        }
    </style>

    <!-- D3 and OrgChart libraries -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-org-chart@3.1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-flextree@2.1.2/build/d3-flextree.js"></script>

    <script>
        let chart;
        let orgChartData = {!! $orgChartJson !!};

        function renderOrgChart() {
            if (!chart) {
                chart = new d3.OrgChart()
                    .container('#chart-container')
                    .data(orgChartData)
                    .nodeWidth((d) => 240)
                    .initialZoom(0.7)
                    .nodeHeight((d) => 200)
                    .childrenMargin((d) => 60)
                    .compact(false)
                    .layout("top")
                    .onNodeClick(d => {
                        openNodeModal(d.data);
                    })
                    .linkUpdate(function (d, i, arr) {
                        d3.select(this)
                            .attr("stroke", "rgba(255,0,0,0.3)")
                            .attr("stroke-width", 2);
                    })
                    .buttonContent(({ node, state }) => {
                        return `<div style="color:var(--text-white); border-radius:50%; width:28px; height:28px; display:flex; justify-content:center; align-items:center; background-color:var(--card-black); border:1.5px solid var(--accent-red); box-shadow:0 0 10px rgba(0,0,0,0.5); font-size:14px; transition:all 0.3s; cursor:pointer;" onMouseOver="this.style.background='#222'" onMouseOut="this.style.background='var(--card-black)'">
                                        <i class="fas ${node.children ? 'fa-minus' : 'fa-plus'}"></i>
                                    </div>`;
                    })
                    .nodeContent(function (d, i, arr, state) {
                        const isRoot = d.data.parentId === '';

                        let imageHtml = '';
                        if (d.data.image && d.data.image.trim() !== '') {
                            imageHtml = `<img src="${d.data.image}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                        } else {
                            imageHtml = `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #2a2a2a; border-radius: 50%;">
                                                        <i class="fas fa-user" style="font-size: 28px; color: var(--text-muted);"></i>
                                                     </div>`;
                        }

                        return `
                                    <div style="font-family: inherit; box-sizing: border-box; width:${d.width}px; height:${d.height}px; padding-top:20px; background: linear-gradient(145deg, #1e1e1e, #141414); border: ${isRoot ? '2px solid var(--accent-red)' : '1px solid rgba(255,255,255,0.08)'}; border-radius: 12px; box-shadow: ${isRoot ? '0 0 20px rgba(255,0,0,0.2)' : '0 4px 25px rgba(0,0,0,0.5)'}; display: flex; flex-direction: column; align-items: center; position: relative;">

                                        <div style="flex-shrink: 0; width: 66px; height: 66px; border-radius: 50%; border: 2px solid ${isRoot ? 'var(--accent-red)' : 'var(--light-red)'}; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; background: var(--dark-black); z-index: 2; box-shadow: 0 0 15px rgba(255,0,0,0.3); padding: 3px; overflow: hidden;">
                                            ${imageHtml}
                                        </div>

                                        <div style="flex-shrink: 0; color: #fff; font-weight: 600; font-size: 15px; margin-bottom: 2px; text-align: center; width: 90%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-transform: capitalize;">${d.data.name}</div>
                                        <div style="flex-shrink: 0; color: rgba(255,255,255,0.5); font-size: 12px; margin-bottom: 4px; text-align: center; font-weight: 500;">@${d.data.username}</div>

                                        ${!isRoot ? `<div style="flex-shrink: 0; margin-bottom: auto; text-align: center;"><span style="background: rgba(255, 0, 0, 0.1); color: var(--light-red); padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; border: 1px solid rgba(255, 0, 0, 0.2);">Level ${d.data.level}</span></div>` : '<div style="flex-shrink: 0; margin-bottom: auto;"></div>'}

                                        <div style="box-sizing: border-box; display: flex; justify-content: space-between; width: 100%; border-top: 1px solid rgba(255,255,255,0.05); background: rgba(0,0,0,0.3); padding: 12px 15px 16px 15px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 48%; border-right: 1px solid rgba(255,255,255,0.05);">
                                                <span style="color: rgba(255,255,255,0.4); font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Team</span>
                                                <span style="color: #fff; font-weight: 600; font-size: 13px;">
                                                    <i class="fas fa-users" style="color: var(--light-red); margin-right: 3px; font-size: 11px;"></i>${d.data.teamSize}
                                                </span>
                                            </div>
                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 48%;">
                                                <span style="color: rgba(255,255,255,0.4); font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Investment</span>
                                                <span style="color: #f1f1f1; font-weight: 600; font-size: 13px;">
                                                    $${Number(d.data.volume).toFixed(2)}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    `;
                    })
                    .render();

                // Collapse nodes beyond level 2 (which is visually level 3, since root is level 0)
                chart.getNodes().forEach(node => {
                    if (node.depth >= 2) {
                        chart.setExpanded(node.id, false);
                    }
                });

                chart.render().fit();
            }
        }
        function switchView(viewName) {
            // Handle Button States
            document.querySelectorAll('.view-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.currentTarget.classList.add('active');

            const multiSelectBox = document.getElementById('multiSelectBox');

            // Handle View Visibility
            if (viewName === 'table') {
                document.getElementById('tableView').style.display = 'block';
                document.getElementById('treeView').style.display = 'none';
                if (multiSelectBox) multiSelectBox.style.display = 'flex';
            } else {
                document.getElementById('tableView').style.display = 'none';
                document.getElementById('treeView').style.display = 'block';
                if (multiSelectBox) multiSelectBox.style.display = 'none';
                // Render the graph if it hasn't been rendered yet
                setTimeout(() => {
                    renderOrgChart();
                }, 50);
            }
        }

        const uniqueUplines = {!! $uniqueUplinesJson !!};
        let selectedUplines = [];
        let currentFocus = -1;

        const searchInput = document.getElementById('uplineSearch');
        const dropdown = document.getElementById('suggestionDropdown');
        const tagsContainer = document.getElementById('selectedTags');
        const searchWrapper = document.getElementById('searchWrapper');

        function enterSearchMode() {
            if (window.innerWidth <= 768) {
                document.body.classList.add('search-mode-active');
                searchWrapper.classList.add('mobile-active');
            }
        }

        function exitSearchMode() {
            document.body.classList.remove('search-mode-active');
            searchWrapper.classList.remove('mobile-active');
            searchInput.blur();
            closeDropdown();
        }

        searchInput.addEventListener('input', function (e) {
            let val = this.value.toLowerCase();
            closeDropdown();
            if (!val) return false;
            currentFocus = -1;

            let matches = uniqueUplines.filter(u =>
                (u.name.toLowerCase().includes(val) || u.username.toLowerCase().includes(val)) &&
                !selectedUplines.some(sel => sel.id === u.id)
            );

            if (matches.length > 0) {
                showDropdown(matches);
            }
        });

        searchInput.addEventListener('keydown', function (e) {
            let items = dropdown.querySelectorAll('.suggestion-item');
            if (e.keyCode == 40) { // DOWN
                currentFocus++;
                addActive(items);
            } else if (e.keyCode == 38) { // UP
                currentFocus--;
                addActive(items);
            } else if (e.keyCode == 13) { // ENTER
                e.preventDefault();
                if (currentFocus > -1) {
                    if (items[currentFocus]) items[currentFocus].click();
                }
            } else if (e.keyCode == 8 && !this.value && selectedUplines.length > 0) { // BACKSPACE
                removeUplineTag(selectedUplines[selectedUplines.length - 1].id);
            }
        });

        function showDropdown(matches) {
            dropdown.innerHTML = '';
            matches.forEach((u, index) => {
                let div = document.createElement('div');
                div.className = 'suggestion-item';
                let imgHtml = u.image ? `<img src="${u.image}">` : `<i class="fas fa-user"></i>`;
                div.innerHTML = `
                            <div class="suggest-img">${imgHtml}</div>
                            <div class="suggest-info">
                                <span class="suggest-name">${u.name}</span>
                                <span class="suggest-username">@${u.username}</span>
                            </div>
                        `;
                div.addEventListener('click', function () {
                    addUplineTag(u);
                });
                dropdown.appendChild(div);
            });
            dropdown.style.display = 'block';
        }

        function addActive(items) {
            if (!items) return false;
            removeActive(items);
            if (currentFocus >= items.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (items.length - 1);
            items[currentFocus].classList.add('active');
            items[currentFocus].scrollIntoView({ block: 'nearest' });
        }

        function removeActive(items) {
            for (let i = 0; i < items.length; i++) {
                items[i].classList.remove('active');
            }
        }

        function closeDropdown() {
            dropdown.style.display = 'none';
        }

        function addUplineTag(upline) {
            selectedUplines.push(upline);
            searchInput.value = '';
            closeDropdown();
            renderTags();
            applyMultiFilters();
        }

        function removeUplineTag(id) {
            selectedUplines = selectedUplines.filter(u => u.id !== id);
            renderTags();
            applyMultiFilters();
        }

        function clearAllFilters() {
            selectedUplines = [];
            searchInput.value = '';
            closeDropdown();
            renderTags();
            applyMultiFilters();
        }

        function renderTags() {
            tagsContainer.innerHTML = '';
            selectedUplines.forEach(u => {
                let tag = document.createElement('div');
                tag.className = 'tag-item';
                let imgHtml = u.image ? `<img src="${u.image}">` : `<i class="fas fa-user"></i>`;
                tag.innerHTML = `
                            <div class="tag-img-box">${imgHtml}</div>
                            <span>${u.name}</span>
                            <div class="tag-remove" onclick="removeUplineTag(${u.id})">
                                <i class="fas fa-times"></i>
                            </div>
                        `;
                tagsContainer.appendChild(tag);
            });
        }

        function applyMultiFilters() {
            let filterNames = selectedUplines.map(u => u.name.toLowerCase());
            let filterUsernames = selectedUplines.map(u => u.username.toLowerCase());

            // Filter Table View
            let tableRows = document.querySelectorAll('.table-row-item');
            tableRows.forEach(row => {
                let uplineText = row.cells[2].innerText.toLowerCase();

                if (selectedUplines.length === 0) {
                    row.style.display = 'table-row';
                } else {
                    let matches = filterNames.some(name => uplineText.includes(name)) ||
                        filterUsernames.some(uname => uplineText.includes(uname));
                    row.style.display = matches ? 'table-row' : 'none';
                }
            });

            // Filter Mobile View
            let mobileCards = document.querySelectorAll('.mobile-card-item');
            mobileCards.forEach(card => {
                let rows = card.querySelectorAll('.card-mobile-row');
                let uplineValue = "";

                rows.forEach(row => {
                    let label = row.querySelector('.card-row-label span');
                    if (label && label.innerText.trim() === 'Upline') {
                        uplineValue = row.querySelector('.card-row-value').innerText.toLowerCase();
                    }
                });

                if (selectedUplines.length === 0) {
                    card.style.display = 'block';
                } else {
                    let matches = filterNames.some(name => uplineValue.includes(name)) ||
                        filterUsernames.some(uname => uplineValue.includes(uname));
                    card.style.display = matches ? 'block' : 'none';
                }
            });
        }

        document.addEventListener('click', function (e) {
            if (!document.getElementById('multiSelectBox').contains(e.target)) {
                if (document.body.classList.contains('search-mode-active')) {
                    exitSearchMode();
                } else {
                    closeDropdown();
                }
            }
        });

        // Modal logic
        function openNodeModal(data) {
            let avatarHtml = '';
            if (data.image && data.image.trim() !== '') {
                avatarHtml = `<img src="${data.image}">`;
            } else {
                avatarHtml = `<i class="fas fa-user"></i>`;
            }

            document.getElementById('modalUserAvatar').innerHTML = avatarHtml;
            document.getElementById('modalUserName').innerText = data.name;
            document.getElementById('modalUserUsername').innerText = '@' + data.username;
            document.getElementById('modalUserTeam').innerText = data.teamSize;
            document.getElementById('modalUserVol').innerText = '$' + Number(data.volume).toFixed(2);

            document.getElementById('nodeDetailModal').classList.add('active');
        }

        function closeNodeModal() {
            document.getElementById('nodeDetailModal').classList.remove('active');
        }

        // Close modal on outside click
        document.getElementById('nodeDetailModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeNodeModal();
            }
        });
        // Copy Referral Link
        $('#copyBoard').click(function () {
            var copyText = document.getElementsByClassName("referral-input")[0];
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            const btn = $(this);
            const originalHtml = btn.html();
            btn.html('<i class="fas fa-check"></i> Copied!');
            btn.css('background', 'var(--success-green)');

            setTimeout(() => {
                btn.html(originalHtml);
                btn.css('background', '');
            }, 2000);
        });
    </script>

    <style>
        footer {
            display: none !important;
        }
    </style>
@endsection