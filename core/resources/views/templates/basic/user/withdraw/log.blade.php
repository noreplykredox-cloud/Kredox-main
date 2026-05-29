@extends($activeTemplate . 'layouts.master')
@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('content')
    <div class="dashboard-container">
        <!-- Video Background -->

        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>Withdraw History</h1>
                    <p>Track all your withdrawal transactions</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Withdrawn</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($withdraws->where('status', 1)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-check-circle"></i> Success
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-info">
                    <h4>Pending</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($withdraws->where('status', 2)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend warning">
                    <i class="fas fa-clock"></i> In Review
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h4>Rejected</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($withdraws->where('status', 3)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend down">
                    <i class="fas fa-ban"></i> Failed
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Requests</h4>
                    <h3>{{ $withdraws->count() }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-history"></i> All Time
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="deposit-history-container">
            <div class="card deposit-card">
                <div class="card-header">
                    <h3><i class="fas fa-file-invoice"></i> Withdraw History</h3>
                    <div class="card-actions-wrapper">
                        <!-- Filters Group -->
                        <div class="filter-controls">
                            <div class="filter-item">
                                <select id="statusFilter" onchange="applyFilters()" class="filter-select">
                                    <option value="all">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <button type="button" onclick="resetFilters()" class="btn-reset-filters" title="Reset Filters">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <!-- Search Box -->
                        <div class="search-group">
                            <input type="text" id="trxSearch" onkeyup="applyFilters()" class="search-input"
                                placeholder="Search TRX...">
                            <div class="search-icon-box">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="deposits-table desktop-view">
                    <table class="deposit-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Initiated At</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Net Payout</th>
                                <th>Wallet</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($withdraws->count() > 0)
                                @foreach($withdraws as $withdraw)
                                    <tr class="table-row-item" data-trx="{{ strtolower($withdraw->trx) }}"
                                        data-status="{{ $withdraw->status == 2 ? 'pending' : ($withdraw->status == 1 ? 'approved' : ($withdraw->status == 3 ? 'rejected' : 'all')) }}"
                                        style="--delay: {{ $loop->index * 0.1 }}s; animation-delay: {{ $loop->index * 0.1 }}s">
                                        <td>
                                            <span class="serial-number">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="date-time-cell">
                                                <div class="date">{{ showDateTime($withdraw->created_at, 'd M, Y') }}</div>
                                                <div class="time">{{ showDateTime($withdraw->created_at, 'h:i A') }}</div>
                                            </div>
                                        </td>

                                        <td>
                                            <code class="trx-code">{{ $withdraw->trx }}</code>
                                        </td>
                                        <td>
                                            <div class="amount-cell">
                                                <span
                                                    class="amount-main">{{ $general->cur_sym }}{{ showAmount($withdraw->amount) }}</span>
                                                <span class="currency">{{ $general->cur_text }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="charge-text">
                                                <i class="fas fa-minus"></i>{{ showAmount($withdraw->charge) }}
                                                {{ $general->cur_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="total-amount">
                                                {{ showAmount($withdraw->amount - $withdraw->charge) }} {{ $general->cur_text }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($withdraw->withdraw_type == 2)
                                                <span class="badge badge--warning">Investment</span>
                                            @else
                                                <span class="badge badge--primary">Balance</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php echo $withdraw->statusBadge @endphp
                                        </td>
                                        <td class="text-center">
                                            <button class="action-btn view-details-btn detailBtn"
                                                data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                                data-trx="{{ $withdraw->trx }}"
                                                data-gateway="{{ __(@$withdraw->method->name ?? 'E-pin') }}"
                                                data-date="{{ showDateTime($withdraw->created_at, 'd M, Y | h:i A') }}"
                                                data-amount="{{ showAmount($withdraw->amount) }} {{ $general->cur_text }}"
                                                data-charge="{{ showAmount($withdraw->charge) }} {{ $general->cur_text }}"
                                                data-total="{{ showAmount($withdraw->amount - $withdraw->charge) }} {{ $general->cur_text }}"
                                                data-status_text="{{ $withdraw->status == 2 ? 'Pending' : ($withdraw->status == 1 ? 'Approved' : 'Rejected') }}"
                                                data-status_class="{{ $withdraw->status == 2 ? 'warning' : ($withdraw->status == 1 ? 'success' : 'danger') }}"
                                                @if ($withdraw->status == 3) data-admin_feedback="{{ $withdraw->admin_feedback }}"
                                                @endif>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-folder-open"></i>
                                            </div>
                                            <h4>No Withdrawal History Found</h4>
                                            <p>Your withdrawal history will appear here.</p>
                                            <a href="{{ route('user.withdraw') }}" class="btn-new-deposit">Request Now</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <!-- No results row (hidden by default) -->
                            <tr id="noResultsRow" style="display: none;">
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-search-minus"></i>
                                        </div>
                                        <h4 id="noResultsTitle">History Not Found</h4>
                                        <p id="noResultsDesc">Try adjusting your filters or search terms.</p>
                                        <button type="button" onclick="resetFilters()" class="btn-new-deposit">Show All History</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="deposits-mobile-view">
                    @if($withdraws->count() > 0)
                        @foreach($withdraws as $withdraw)
                            <div class="deposit-card-mobile mobile-card-item" data-trx="{{ strtolower($withdraw->trx) }}"
                                data-status="{{ $withdraw->status == 2 ? 'pending' : ($withdraw->status == 1 ? 'approved' : ($withdraw->status == 3 ? 'rejected' : 'all')) }}"
                                style="animation-delay: {{ $loop->index * 0.1 }}s">

                                <div class="card-mobile-header">
                                    <div class="card-mobile-avatar">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </div>
                                    <div class="card-mobile-identity">
                                        <div class="card-mobile-name">{{ __(@$withdraw->method->name ?? 'E-pin') }}</div>
                                        <div class="card-mobile-subtext">{{ $withdraw->trx }}</div>
                                    </div>
                                    <div class="card-mobile-status">
                                        @php echo $withdraw->statusBadge @endphp
                                    </div>
                                </div>

                                <div class="card-mobile-body">
                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-calendar-day"></i> <span>Initiated</span>
                                        </div>
                                        <div class="card-row-value">
                                            {{ showDateTime($withdraw->created_at, 'd M, Y | h:i A') }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-money-bill-wave"></i> <span>Requested</span>
                                        </div>
                                        <div class="card-row-value">
                                            {{ $general->cur_sym }}{{ showAmount($withdraw->amount) }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-minus-circle"></i> <span>Charge</span>
                                        </div>
                                        <div class="card-row-value text--danger">
                                            -{{ showAmount($withdraw->charge) }} {{ $general->cur_text }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-check-double"></i> <span>Net Payout</span>
                                        </div>
                                        <div class="card-row-value total-business-value">
                                            {{ showAmount($withdraw->amount - $withdraw->charge) }} {{ $general->cur_text }}
                                        </div>
                                    </div>
                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-wallet"></i> <span>Wallet</span>
                                        </div>
                                        <div class="card-row-value">
                                            {{ $withdraw->withdraw_type == 2 ? 'Investment' : 'Balance' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="card-mobile-actions">
                                    <button class="view-details-btn-mobile detailBtn"
                                        data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                        data-trx="{{ $withdraw->trx }}" data-gateway="{{ __(@$withdraw->method->name ?? 'E-pin') }}"
                                        data-date="{{ showDateTime($withdraw->created_at, 'd M, Y | h:i A') }}"
                                        data-amount="{{ showAmount($withdraw->amount) }} {{ $general->cur_text }}"
                                        data-charge="{{ showAmount($withdraw->charge) }} {{ $general->cur_text }}"
                                        data-total="{{ showAmount($withdraw->amount - $withdraw->charge) }} {{ $general->cur_text }}"
                                        data-status_text="{{ $withdraw->status == 2 ? 'Pending' : ($withdraw->status == 1 ? 'Approved' : 'Rejected') }}"
                                        data-status_class="{{ $withdraw->status == 2 ? 'warning' : ($withdraw->status == 1 ? 'success' : 'danger') }}"
                                        @if ($withdraw->status == 3) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                        <i class="fas fa-eye"></i> View Full Details
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h4>No Withdrawal History Found</h4>
                            <p>Your withdrawal history will appear here.</p>
                            <a href="{{ route('user.withdraw') }}" class="btn-new-deposit">Request Now</a>
                        </div>
                    @endif
                    <!-- No results mobile (hidden by default) -->
                    <div id="noResultsMobile" style="display: none;">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search-minus"></i>
                            </div>
                            <h4 id="noResultsTitleMobile">History Not Found</h4>
                            <p id="noResultsDescMobile">No record matches your current filters.</p>
                            <button type="button" onclick="resetFilters()" class="btn-new-deposit">Show All History</button>
                        </div>
                    </div>
                </div>

                @if($withdraws->count() > 0)
                    <div class="custom-pagination">
                        <div class="rows-per-page">
                            <label for="itemsPerPage">Rows per page:</label>
                            <div class="select-wrapper">
                                <select id="itemsPerPage" onchange="changeItemsPerPage()">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                        <div class="pagination-right">
                            <div class="page-info">
                                <span id="pageInfoText"></span>
                            </div>
                            <div class="page-controls">
                                <button type="button" id="prevPageBtn" onclick="prevPage()"><i
                                        class="fas fa-chevron-left"></i></button>
                                <button type="button" id="nextPageBtn" onclick="nextPage()"><i
                                        class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
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
                        <div id="modalStatusIcon" class="status-icon-wrapper mb-2"></div>
                        <h3 id="modalTotalAmount" class="final-amount mb-1 text-white font-weight-bold"></h3>
                        <div id="modalStatusBadge" class="status-label-badge mb-1"></div>
                    </div>

                    <div class="details-section p-3">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i
                                class="fas fa-info-circle mr-2"></i> CORE INFORMATION</h6>
                        <div class="info-grid-modern">
                            <div class="info-item-modern">
                                <span class="label text-muted small">Transaction ID</span>
                                <span id="modalTrx" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Method</span>
                                <span id="modalGateway" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Date & Time</span>
                                <span id="modalDate" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Request Amount</span>
                                <span id="modalAmount" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Processing Charge</span>
                                <span id="modalCharge" class="value text--danger d-block font-weight-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div id="userDataDivider" class="modal-divider" style="display:none;"></div>
                    <div id="userDataSection" class="p-3" style="display:none;">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i class="fas fa-user-edit mr-2"></i>
                            USER SUBMITTED DATA</h6>
                        <div class="userData info-grid-modern"></div>
                    </div>

                    <div id="feedbackSection" class="p-3 bg-dark-accent" style="display:none;">
                        <h6 class="section-title text--danger text-uppercase small mb-1 font-weight-bold">Admin Feedback
                        </h6>
                        <p id="feedbackText" class="text-white mb-0 font-italic small"></p>
                    </div>

                    <!-- Hidden Receipt Template for PDF -->
                    <div style="position: absolute; left: -9999px; top: -9999px;">
                        <div id="printableInvoice"
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
                                                id="pdfTrx" style="font-weight: bold; color: #000;"></span></p>
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
                                            Net Payout Amount</p>
                                        <h3 id="pdfTotal"
                                            style="font-size: 48px; margin: 0; color: #111; font-weight: 800;"></h3>
                                    </div>
                                    <div style="text-align: center;">
                                        <div id="pdfStatus"
                                            style="display: inline-block; padding: 10px 25px; border-radius: 50px; font-weight: 800; font-size: 16px; text-transform: uppercase; border: 2px solid currentColor;">
                                        </div>
                                    </div>
                                </div>

                                <div
                                    style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 50px; margin-bottom: 60px;">
                                    <div
                                        style="background: #fdfdfd; padding: 25px; border-radius: 15px; border: 1px solid #eee;">
                                        <h4
                                            style="margin: 0 0 15px 0; color: #e1211b; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                                            Transaction Details</h4>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Payout Method</td>
                                                <td id="pdfGateway"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Requested Amount</td>
                                                <td id="pdfAmount"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Withdrawal Charge</td>
                                                <td id="pdfCharge"
                                                    style="padding: 10px 0; text-align: right; color: #e1211b; font-weight: bold;">
                                                </td>
                                            </tr>
                                            <tr style="border-top: 2px solid #333;">
                                                <td style="padding: 15px 0; font-weight: 800; font-size: 18px;">Net Payout
                                                </td>
                                                <td id="pdfTotal2"
                                                    style="padding: 15px 0; text-align: right; font-weight: 800; font-size: 20px; color: #e1211b;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div
                                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                                        <div
                                            style="width: 160px; height: 160px; border: 4px double #e1211b; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; transform: rotate(-15deg); color: #e1211b; background: rgba(225, 33, 27, 0.02);">
                                            <span
                                                style="font-size: 12px; font-weight: bold; text-transform: uppercase;">Verified
                                                by</span>
                                            <span
                                                style="font-size: 16px; font-weight: 900; margin: 5px 0;">{{ __($general->site_name) }}</span>
                                            <div style="width: 80%; height: 1px; background: #e1211b; margin: 5px 0;"></div>
                                            <span
                                                style="font-size: 10px; font-weight: bold;">{{ request()->getHost() }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div style="border-top: 1px solid #eee; padding-top: 30px; text-align: center;">
                                    <p style="color: #333; font-weight: bold; margin-bottom: 5px;">Thank you for using our
                                        payout service!</p>
                                    <p style="color: #999; font-size: 11px; margin: 0;">© {{ date('Y') }}
                                        {{ __($general->site_name) }}. All rights reserved.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-red"
                    style="display: flex !important; justify-content: flex-end !important;">
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <i class="fas fa-check"></i> OK, Got it
                    </button>
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

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
        }

        .dashboard-header {
            background: #000;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            padding: 20px 25px;
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

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--gradient-card);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
            box-shadow: var(--shadow-card);
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--light-red);
            box-shadow: var(--shadow-red);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #ff0000;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.4);
        }

        .stat-info h4 {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0 0 5px 0;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .stat-info h3 {
            color: var(--text-white);
            font-size: 24px;
            margin: 0;
            font-weight: 800;
        }

        .stat-trend {
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: auto;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-trend.up {
            background: rgba(0, 255, 0, 0.1);
            color: #00ff00;
            border: 1px solid rgba(0, 255, 0, 0.2);
        }

        .stat-trend.warning {
            background: rgba(255, 165, 0, 0.1);
            color: #ff3333;
            border: 1px solid rgba(255, 165, 0, 0.2);
        }

        .stat-trend.down {
            background: rgba(255, 0, 0, 0.1);
            color: #ff4444;
            border: 1px solid rgba(255, 0, 0, 0.2);
        }

        .stat-trend i {
            font-size: 10px;
        }

        .deposit-card {
            background: var(--gradient-card);
            border-radius: 15px;
            border: 1px solid var(--border-red);
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .card-header {
            padding: 12px 9px;
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
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-reset-filters:hover {
            background: var(--light-red);
            color: white;
            transform: rotate(180deg);
        }

        .search-group {
            position: relative;
            width: 280px;
        }

        .search-input {
            background: #000 !important;
            border: 1px solid var(--border-red) !important;
            color: white !important;
            padding: 10px 15px 10px 45px !important;
            border-radius: 10px;
            font-size: 14px;
            width: 100%;
            height: 45px;
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
            min-width: 1000px;
        }

        .deposit-table thead {
            background: rgba(255, 0, 0, 0.1);
        }

        .deposit-table th {
            padding: 15px 20px;
            text-align: center;
            color: var(--light-red);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-bottom: 1px solid var(--border-red);
        }

        .deposit-table td {
            padding: 20px;
            color: var(--text-light);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
            text-align: center;
        }

        .deposit-table tr:hover {
            background: rgba(255, 255, 255, 0.02);
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
            color: var(--text-white);
            font-family: monospace;
            font-size: 13px;
        }

        .amount-cell {
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: center;
        }

        .amount-main {
            color: white;
            font-weight: 700;
            font-size: 15px;
        }

        .charge-text {
            color: var(--danger-red);
            font-weight: 600;
        }

        .total-amount {
            color: var(--success-green);
            font-weight: 800;
            font-size: 15px;
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

        .badge {
            padding: 6px 12px !important;
            border-radius: 6px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            border: 1px solid currentColor !important;
            background: transparent !important;
        }

        .badge--success {
            color: #00ff00 !important;
        }

        .badge--warning {
            color: #ff3333 !important;
        }

        .badge--danger {
            color: #ff4d4d !important;
        }

        /* Mobile Styles */
        .deposits-mobile-view {
            display: none;
        }

        @media (max-width: 991px) {
            .dashboard-container {
                margin-left: 0;
                padding: 10px 12px;
                padding-bottom: 60px;
            }

            .desktop-view {
                display: none;
            }

            .quick-stats {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 15px !important;
            }
            
            .dashboard-header {
                padding: 15px 12px;
                margin-bottom: 12px;
            }

            .stat-card {
                padding: 18px 25px;
                gap: 20px;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                min-height: 100px;
                background: #0f0f0f;
                border: 1px solid rgba(255, 0, 0, 0.15);
            }

            .stat-icon {
                width: 65px;
                height: 65px;
                font-size: 28px;
                margin-right: 0;
                background: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
                border-radius: 12px;
                flex-shrink: 0;
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
            }

            .stat-info {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                flex: 1;
                text-align: center;
            }

            .stat-info h4 {
                font-size: 14px;
                color: var(--text-muted);
                margin-bottom: 6px;
                font-weight: 600;
            }

            .stat-info h3 {
                font-size: 28px;
                letter-spacing: 0.5px;
                color: white;
                font-weight: 800;
            }

            .stat-trend {
                flex-shrink: 0;
                font-size: 13px;
                padding: 6px 14px;
                border-radius: 30px;
                margin-left: 0;
                min-width: 80px;
                justify-content: center;
                position: static;
            }

            .deposits-mobile-view {
                display: block;
            }

            .deposit-card-mobile {
                background: #0f0f0f;
                border: 1px solid rgba(255, 0, 0, 0.15);
                border-radius: 16px;
                padding: 20px;
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
                margin-bottom: 25px;
                position: relative;
            }

            .card-mobile-avatar {
                width: 60px;
                height: 60px;
                background: #ff0000;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 24px;
                flex-shrink: 0;
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
            }

            .card-mobile-identity {
                flex: 1;
            }

            .card-mobile-name {
                color: white;
                font-size: 18px;
                font-weight: 700;
                margin-bottom: 2px;
            }

            .card-mobile-subtext {
                color: #ff3333;
                font-size: 13px;
                font-weight: 500;
            }

            .card-mobile-status {
                position: absolute;
                top: 0;
                right: 0;
            }

            .card-mobile-body {
                background: rgba(255, 255, 255, 0.02);
                border-radius: 12px;
                padding: 2px 12px;
                margin-bottom: 12px;
            }

            .card-mobile-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
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
                color: rgba(255, 255, 255, 0.8);
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
                padding: 12px;
                border-radius: 10px;
                font-size: 14px;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: all 0.3s ease;
            }

            .view-details-btn-mobile:hover {
                background: rgba(255, 255, 255, 0.1);
            }

            .card-header {
                flex-wrap: wrap;
            }

            .card-actions-wrapper {
                width: 100%;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .filter-controls {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 10px;
            }

            .search-group {
                width: 100%;
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
            font-size: 32px;
            color: var(--light-red);
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

        .btn-download {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
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

        .custom-pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            border-top: 1px solid var(--border-red);
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
            font-size: 8px;
            color: var(--text-muted);
            position: absolute;
            right: 10px;
            pointer-events: none;
        }

        .custom-pagination select {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-white);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 4px 25px 4px 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .custom-pagination select:hover {
            border-color: var(--light-red);
            background: rgba(0, 0, 0, 0.5);
        }

        .custom-pagination select option {
            background: #1a1a1a;
            color: white;
            padding: 10px;
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

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        (function ($) {
            "use strict";

            $('.detailBtn').on('click', function () {
                var modal = $('#detailModal');
                var btn = $(this);

                modal.find('#modalTrx').text(btn.data('trx'));
                modal.find('#modalGateway').text(btn.data('gateway'));
                modal.find('#modalDate').text(btn.data('date'));
                modal.find('#modalAmount').text(btn.data('amount'));
                modal.find('#modalCharge').text(btn.data('charge'));
                modal.find('#modalTotalAmount').text(btn.data('total'));

                var statusText = btn.data('status_text');
                var statusClass = btn.data('status_class');
                var iconHtml = '';

                if (statusClass == 'success') iconHtml = '<i class="fas fa-check-circle text-success" style="font-size: 45px;"></i>';
                else if (statusClass == 'warning') iconHtml = '<i class="fas fa-clock text-warning" style="font-size: 45px;"></i>';
                var userData = $(this).data('user_data');
                var html = ``;
                modal.find('.userData').html('');

                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                                <div class="info-item-modern">
                                    <span class="label text-muted small">${element.name}</span>
                                    <span class="value text-white d-block font-weight-bold">${element.value}</span>
                                </div>`;
                        }
                    });
                    modal.find('.userData').html(html);
                    modal.find('#userDataSection, #userDataDivider').show();
                } else {
                    modal.find('#userDataSection, #userDataDivider').hide();
                }

                var adminFeedback = $(this).data('admin_feedback');
                if (adminFeedback) {
                    modal.find('#feedbackText').text(adminFeedback);
                    modal.find('#feedbackSection').show();
                } else {
                    modal.find('#feedbackSection').hide();
                }

                modal.find('#modalTrx').text($(this).data('trx'));
                modal.find('#modalGateway').text($(this).data('gateway'));
                modal.find('#modalDate').text($(this).data('date'));
                modal.find('#modalAmount').text($(this).data('amount'));
                modal.find('#modalCharge').text($(this).data('charge'));
                modal.find('#modalTotalAmount').text($(this).data('total'));

                var statusText = $(this).data('status_text');
                var statusClass = $(this).data('status_class');
                var iconHtml = '';

                if (statusClass == 'success') iconHtml = '<i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>';
                else if (statusClass == 'warning') iconHtml = '<i class="fas fa-history text-warning" style="font-size: 40px;"></i>';
                else iconHtml = '<i class="fas fa-times-circle text-danger" style="font-size: 40px;"></i>';

                modal.find('#modalStatusIcon').html(iconHtml);
                modal.find('#modalStatusBadge').html(`<span class="badge badge--${statusClass} text-uppercase px-3 py-2 font-weight-bold" style="letter-spacing: 1px;">${statusText}</span>`);

                // Sync with PDF Template
                modal.find('#pdfTrx').text($(this).data('trx'));
                modal.find('#pdfGateway').text($(this).data('gateway'));
                modal.find('#pdfDate').text($(this).data('date'));
                modal.find('#pdfAmount').text($(this).data('amount'));
                modal.find('#pdfCharge').text($(this).data('charge'));
                modal.find('#pdfTotal, #pdfTotal2').text($(this).data('total'));
                modal.find('#pdfStatus').text(statusText);

                var pdfStatusStyle = {
                    'Approved': { bg: '#e8f7f0', color: '#10b981' },
                    'Pending': { bg: '#fff8ea', color: '#f59e0b' },
                    'Rejected': { bg: '#feeded', color: '#ef4444' }
                };
                var style = pdfStatusStyle[statusText] || pdfStatusStyle['Pending'];
                modal.find('#pdfStatus').css({ 'background-color': style.bg, 'color': style.color });

                modal.modal('show');
            });

            window.downloadInvoice = function () {
                const trx = $('#modalTrx').text();
                const element = document.getElementById('printableInvoice');
                const opt = {
                    margin: 0.2,
                    filename: `Withdraw_Receipt_${trx}.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { scale: 3, useCORS: true, letterRendering: true, logging: false },
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
            };
        })(jQuery);;

        let allTableRows = [];
        let allMobileCards = [];
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalItems = 0;

        function initPagination() {
            allTableRows = Array.from(document.querySelectorAll('.table-row-item'));
            allMobileCards = Array.from(document.querySelectorAll('.mobile-card-item'));
            applyFilters();
        }

        function applyFilters() {
            const trxQuery = document.getElementById('trxSearch').value.toLowerCase();
            const statusQuery = document.getElementById('statusFilter').value;
            currentPage = 1;

            allTableRows.forEach(row => {
                const trx = row.getAttribute('data-trx');
                const status = row.getAttribute('data-status');
                const matchTrx = trx.includes(trxQuery);
                const matchStatus = statusQuery === 'all' || status === statusQuery;
                if (matchTrx && matchStatus) row.classList.add('is-filtered');
                else row.classList.remove('is-filtered');
            });

            allMobileCards.forEach(card => {
                const trx = card.getAttribute('data-trx');
                const status = card.getAttribute('data-status');
                const matchTrx = trx.includes(trxQuery);
                const matchStatus = statusQuery === 'all' || status === statusQuery;
                if (matchTrx && matchStatus) card.classList.add('is-filtered');
                else card.classList.remove('is-filtered');
            });

            updatePaginationUI();
        }

        function resetFilters() {
            document.getElementById('trxSearch').value = '';
            document.getElementById('statusFilter').value = 'all';
            applyFilters();
        }

        function updatePaginationUI() {
            const filteredRows = allTableRows.filter(row => row.classList.contains('is-filtered'));
            const filteredCards = allMobileCards.filter(card => card.classList.contains('is-filtered'));
            totalItems = filteredRows.length;
            
            let start = (currentPage - 1) * itemsPerPage;
            let end = start + itemsPerPage;

            allTableRows.forEach(row => row.style.display = 'none');
            allMobileCards.forEach(card => card.style.display = 'none');

            filteredRows.forEach((row, i) => { if (i >= start && i < end) row.style.display = 'table-row'; });
            filteredCards.forEach((card, i) => { if (i >= start && i < end) card.style.display = 'block'; });

            const pageInfo = document.getElementById('pageInfoText');
            if (pageInfo) {
                const noResultsRow = document.getElementById('noResultsRow');
                const noResultsMobile = document.getElementById('noResultsMobile');
                const statusText = document.getElementById('statusFilter').value;
                const displayStatus = statusText !== 'all' ? statusText.charAt(0).toUpperCase() + statusText.slice(1) : "";

                if (totalItems > 0) {
                    if (noResultsRow) noResultsRow.style.display = 'none';
                    if (noResultsMobile) noResultsMobile.style.display = 'none';

                    let currentEnd = end > totalItems ? totalItems : end;
                    pageInfo.innerText = `${start + 1}–${currentEnd} of ${totalItems}`;
                    document.getElementById('prevPageBtn').disabled = currentPage === 1;
                    document.getElementById('nextPageBtn').disabled = end >= totalItems;
                    document.querySelector('.custom-pagination').style.display = 'flex';
                } else {
                    if (noResultsRow) {
                        noResultsRow.style.display = 'table-row';
                        document.getElementById('noResultsTitle').innerText = `History Not Found ${displayStatus ? '(' + displayStatus + ')' : ''}`;
                    }
                    if (noResultsMobile) {
                        noResultsMobile.style.display = 'block';
                        document.getElementById('noResultsTitleMobile').innerText = `History Not Found ${displayStatus ? '(' + displayStatus + ')' : ''}`;
                    }
                    
                    pageInfo.innerText = `0–0 of 0`;
                    document.querySelector('.custom-pagination').style.display = 'none';
                }
            }
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            currentPage = 1;
            updatePaginationUI();
        }

        function prevPage() { if (currentPage > 1) { currentPage--; updatePaginationUI(); } }
        function nextPage() { if (currentPage < Math.ceil(totalItems / itemsPerPage)) { currentPage++; updatePaginationUI(); } }

        document.addEventListener('DOMContentLoaded', initPagination);
    </script>
@endpush