@extends($activeTemplate . 'layouts.master')
@push('style')
    <link rel="stylesheet" href="{{ asset('/core/resources/views/templates/basic/user/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>Deposit History</h1>
                    <p>Track all your deposit transactions</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Deposited</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposits->where('status', 1)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i> Active
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h4>Pending</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposits->where('status', 2)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-clock"></i> Processing
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h4>Rejected</h4>
                    <h3>{{ $general->cur_sym }}{{ showAmount($deposits->where('status', 3)->sum('amount')) }}</h3>
                </div>
                <div class="stat-trend down">
                    <i class="fas fa-arrow-down"></i> Failed
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Transactions</h4>
                    <h3>{{ $deposits->count() }}</h3>
                </div>
                <div class="stat-trend up">
                    <i class="fas fa-chart-line"></i> All
                </div>
            </div>
        </div>

        <!-- Main Content Section -->
        <div class="deposit-history-container">
            <div class="card deposit-card">
                <div class="card-header">
                    <h3><i class="fas fa-file-invoice-dollar"></i> Deposit History</h3>
                    <div class="card-actions-wrapper">
                        <!-- Filters Group -->
                        <div class="filter-controls">
                            <!-- Status Filter -->
                            <div class="filter-item">
                                <select id="statusFilter" onchange="applyFilters()" class="filter-select">
                                    <option value="all">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <!-- Reset Button -->
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
                                <th>Date & Time</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Charge</th>
                                <th>Total Deposit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($deposits->count() > 0)
                                @foreach($deposits as $deposit)
                                    <tr class="table-row-item" data-trx="{{ strtolower($deposit->trx) }}"
                                        data-status="{{ $deposit->status == 2 ? 'pending' : ($deposit->status == 1 ? 'approved' : ($deposit->status == 3 ? 'rejected' : 'all')) }}"
                                        style="--delay: {{ $loop->index * 0.1 }}s; animation-delay: {{ $loop->index * 0.1 }}s">
                                        <td>
                                            <span class="serial-number">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="date-time-cell">
                                                <div class="date">{{ showDateTime($deposit->created_at, 'd M, Y') }}</div>
                                                <div class="time">{{ showDateTime($deposit->created_at, 'h:i A') }}</div>
                                            </div>
                                        </td>

                                        <td>
                                            <code class="trx-code">{{ $deposit->trx }}</code>
                                        </td>
                                        <td>
                                            <div class="amount-cell">
                                                <span
                                                    class="amount-main">{{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }}</span>
                                                <span class="currency">{{ __($general->cur_text) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="charge-text">
                                                <i class="fas fa-plus"></i>{{ showAmount($deposit->charge) }}
                                                {{ __($general->cur_text) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="total-amount">
                                                {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                            </div>
                                        </td>
                                        <td>
                                            @php echo $deposit->statusBadge @endphp
                                        </td>
                                        <td>
                                            <button
                                                class="action-btn view-details-btn @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                                @if ($deposit->method_code >= 1000) data-info="{{ json_encode($deposit->detail) }}"
                                                    data-trx="{{ $deposit->trx }}"
                                                    data-gateway="{{ __(@$deposit->gateway->name ?? 'E-pin') }}"
                                                    data-date="{{ showDateTime($deposit->created_at, 'd M, Y | h:i A') }}"
                                                    data-amount="{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}"
                                                    data-charge="{{ showAmount($deposit->charge) }} {{ __($general->cur_text) }}"
                                                    data-total="{{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}"
                                                    data-status_text="{{ $deposit->status == 2 ? 'Pending' : ($deposit->status == 1 ? 'Approved' : 'Rejected') }}"
                                                    data-status_class="{{ $deposit->status == 2 ? 'warning' : ($deposit->status == 1 ? 'success' : 'danger') }}"
                                                @endif @if ($deposit->status == 3)
                                                data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
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
                                            <h4>No Deposit History Found</h4>
                                            <p>You haven't made any deposits yet.</p>
                                            <a href="{{ route('user.deposit.index') }}" class="primary-btn mt-3">Make a
                                                Deposit</a>
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
                                        <button type="button" onclick="resetFilters()" class="btn-new-deposit">Show All
                                            History</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards View -->
                <div class="deposits-mobile-view">
                    @if($deposits->count() > 0)
                        @foreach($deposits as $deposit)
                            <div class="deposit-card-mobile mobile-card-item" data-trx="{{ strtolower($deposit->trx) }}"
                                data-status="{{ $deposit->status == 2 ? 'pending' : ($deposit->status == 1 ? 'approved' : ($deposit->status == 3 ? 'rejected' : 'all')) }}"
                                style="animation-delay: {{ $loop->index * 0.1 }}s">
                                <!-- Card Header: Avatar + Identity + Status -->
                                <div class="card-mobile-header">
                                    <div class="card-mobile-avatar">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="card-mobile-identity">
                                        <div class="card-mobile-name">
                                            @if ($deposit->method_code != 0)
                                                {{ __(@$deposit->gateway->name) }}
                                            @else
                                                @lang('E-pin')
                                            @endif
                                        </div>
                                        <div class="card-mobile-subtext">{{ $deposit->trx }}</div>
                                    </div>
                                    <div class="card-mobile-status">
                                        @php echo $deposit->statusBadge @endphp
                                    </div>
                                </div>

                                <!-- Card Body: Structured Rows -->
                                <div class="card-mobile-body">
                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-calendar-day"></i> <span>Date & Time</span>
                                        </div>
                                        <div class="card-row-value">
                                            {{ showDateTime($deposit->created_at, 'd M, Y') }} |
                                            {{ showDateTime($deposit->created_at, 'h:i A') }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-wallet"></i> <span>Amount</span>
                                        </div>
                                        <div class="card-row-value">
                                            {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-plus-circle"></i> <span>Charge</span>
                                        </div>
                                        <div class="card-row-value text--danger">
                                            +{{ showAmount($deposit->charge) }} {{ __($general->cur_text) }}
                                        </div>
                                    </div>

                                    <div class="card-mobile-row">
                                        <div class="card-row-label">
                                            <i class="fas fa-calculator"></i> <span>Total Deposite</span>
                                        </div>
                                        <div class="card-row-value total-business-value">
                                            {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Actions -->
                                <div class="card-mobile-actions">
                                    <button
                                        class="view-details-btn-mobile @if($deposit->method_code >= 1000) detailBtn @else disabled @endif"
                                        @if ($deposit->method_code >= 1000) data-info="{{ json_encode($deposit->detail) }}"
                                            data-trx="{{ $deposit->trx }}" data-gateway="{{ __(@$deposit->gateway->name ?? 'E-pin') }}"
                                            data-date="{{ showDateTime($deposit->created_at, 'd M, Y | h:i A') }}"
                                            data-amount="{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}"
                                            data-charge="{{ showAmount($deposit->charge) }} {{ __($general->cur_text) }}"
                                            data-total="{{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}"
                                            data-status_text="{{ $deposit->status == 0 ? 'Pending' : ($deposit->status == 1 ? 'Approved' : 'Rejected') }}"
                                            data-status_class="{{ $deposit->status == 0 ? 'warning' : ($deposit->status == 1 ? 'success' : 'danger') }}"
                                        @endif @if ($deposit->status == 3) data-admin_feedback="{{ $deposit->admin_feedback }}"
                                        @endif>
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
                            <h4>No Deposit History Found</h4>
                            <p>You haven't made any deposits yet.</p>
                            <a href="{{ route('user.deposit.index') }}" class="primary-btn mt-3"
                                style="display:inline-block; padding: 10px 20px; text-decoration: none;">Make a Deposit</a>
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

                @if($deposits->count() > 0)
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
                        <div id="modalStatusIcon" class="status-icon-wrapper mb-2">
                            <!-- JS will inject icon here -->
                        </div>
                        <h3 id="modalTotalAmount" class="final-amount mb-1 text-white font-weight-bold"></h3>
                        <div id="modalStatusBadge" class="status-label-badge mb-1"></div>
                    </div>

                    <div class="details-section p-3">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i
                                class="fas fa-info-circle mr-2"></i> Core Information</h6>
                        <div class="info-grid-modern">
                            <div class="info-item-modern">
                                <span class="label text-muted small">Transaction ID</span>
                                <span id="modalTrx" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Gateway</span>
                                <span id="modalGateway" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Date & Time</span>
                                <span id="modalDate" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Deposit Amount</span>
                                <span id="modalAmount" class="value text-white d-block font-weight-bold"></span>
                            </div>
                            <div class="info-item-modern">
                                <span class="label text-muted small">Charge Amount</span>
                                <span id="modalCharge" class="value text--danger d-block font-weight-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div id="userDataDivider" class="modal-divider" style="display:none;"></div>

                    <div id="userDataSection" class="p-3" style="display:none;">
                        <h6 class="section-title text-muted text-uppercase small mb-2"><i class="fas fa-user-edit mr-2"></i>
                            User Submitted Data</h6>
                        <div class="userData info-grid-modern"></div>
                    </div>

                    <div id="feedbackSection" class="p-3 bg-dark-accent" style="display:none;">
                        <h6 class="section-title text--danger text-uppercase small mb-1 font-weight-bold">Admin Feedback
                        </h6>
                        <p id="feedbackText" class="text-white mb-0 font-italic small"></p>
                    </div>

                    <!-- Hidden Receipt Template for PDF (Off-screen) -->
                    <div style="position: absolute; left: -9999px; top: -9999px;">
                        <div id="printableInvoice"
                            style="background: white; color: black; padding: 50px; font-family: 'Helvetica', sans-serif; width: 800px; position: relative;">
                            <!-- Watermark Background -->
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
                                            OFFICIAL RECEIPT</h1>
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
                                            Total Paid Amount</p>
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
                                            Deposit Summary</h4>
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Payment Gateway</td>
                                                <td id="pdfGateway"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Base Amount</td>
                                                <td id="pdfAmount"
                                                    style="padding: 10px 0; text-align: right; font-weight: bold;"></td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Processing Charge</td>
                                                <td id="pdfCharge"
                                                    style="padding: 10px 0; text-align: right; color: #e1211b; font-weight: bold;">
                                                </td>
                                            </tr>
                                            <tr style="border-top: 2px solid #333;">
                                                <td style="padding: 15px 0; font-weight: 800; font-size: 18px;">Net Total
                                                </td>
                                                <td id="pdfTotal2"
                                                    style="padding: 15px 0; text-align: right; font-weight: 800; font-size: 20px; color: #e1211b;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div
                                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
                                        <!-- SITE STAMP (MOHAR) -->
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
                                        <p style="margin-top: 15px; font-size: 11px; color: #888;">System Generated Stamp
                                        </p>
                                    </div>
                                </div>

                                <div style="border-top: 1px solid #eee; padding-top: 30px; text-align: center;">
                                    <p style="color: #333; font-weight: bold; margin-bottom: 5px;">Thank you for your
                                        business!</p>
                                    <p style="color: #999; font-size: 11px; margin: 0;">If you have any questions about this
                                        receipt, please contact support at {{ $general->site_name }}.</p>
                                    <p style="color: #bbb; font-size: 10px; margin-top: 15px;">© {{ date('Y') }}
                                        {{ __($general->site_name) }}. All rights reserved.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
        (function ($) {
            "use strict";

            $('.detailBtn').on('click', function () {
                var modal = $('#detailModal');
                var btn = $(this);

                // Basic Info
                modal.find('#modalTrx').text(btn.data('trx'));
                modal.find('#modalGateway').text(btn.data('gateway'));
                modal.find('#modalDate').text(btn.data('date'));
                modal.find('#modalAmount').text(btn.data('amount'));
                modal.find('#modalCharge').text(btn.data('charge'));
                modal.find('#modalTotalAmount').text(btn.data('total'));

                // Status Icon & Badge
                var statusText = btn.data('status_text');
                var statusClass = btn.data('status_class');
                var iconHtml = '';

                if (statusClass == 'success') iconHtml = '<i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>';
                else if (statusClass == 'warning') iconHtml = '<i class="fas fa-history text-warning" style="font-size: 40px;"></i>';
                else iconHtml = '<i class="fas fa-times-circle text-danger" style="font-size: 40px;"></i>';

                modal.find('#modalStatusIcon').html(iconHtml);
                modal.find('#modalStatusBadge').html(`<span class="badge badge--${statusClass} text-uppercase px-3 py-2 font-weight-bold" style="letter-spacing: 1px;">${statusText}</span>`);

                // User Specific Info
                var userData = btn.data('info');
                var html = '';
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

                // Admin Feedback
                var adminFeedback = btn.data('admin_feedback');
                if (adminFeedback) {
                    modal.find('#feedbackText').text(adminFeedback);
                    modal.find('#feedbackSection').show();
                } else {
                    modal.find('#feedbackSection').hide();
                }

                // Sync with PDF Template
                modal.find('#pdfTrx').text(btn.data('trx'));
                modal.find('#pdfGateway').text(btn.data('gateway'));
                modal.find('#pdfDate').text(btn.data('date'));
                modal.find('#pdfAmount').text(btn.data('amount'));
                modal.find('#pdfCharge').text(btn.data('charge'));
                modal.find('#pdfTotal, #pdfTotal2').text(btn.data('total'));
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

                // Set generation options
                const opt = {
                    margin: 0.2,
                    filename: `Receipt_${trx}.pdf`,
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: {
                        scale: 3,
                        useCORS: true,
                        letterRendering: true,
                        logging: false
                    },
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                };

                // Generate without showing on main screen UI
                html2pdf().set(opt).from(element).save();
            };

            // Mobile search toggle
            $('.mobile-search-btn').on('click', function () {
                $('.search-form').toggleClass('active');
            });

        })(jQuery);

        // Global items to filter
        let allTableRows = [];
        let allMobileCards = [];
        let currentPage = 1;
        let itemsPerPage = 10;
        let totalItems = 0;

        function initPagination() {
            allTableRows = Array.from(document.querySelectorAll('.table-row-item'));
            allMobileCards = Array.from(document.querySelectorAll('.mobile-card-item'));

            applyFilters(); // Initial show
        }

        function applyFilters() {
            const trxQuery = document.getElementById('trxSearch').value.toLowerCase();
            const statusQuery = document.getElementById('statusFilter').value;

            // Reset to first page when filtering
            currentPage = 1;

            // Filter Table Rows
            allTableRows.forEach(row => {
                const trx = row.getAttribute('data-trx');
                const status = row.getAttribute('data-status');

                const matchTrx = trx.includes(trxQuery);
                const matchStatus = statusQuery === 'all' || status === statusQuery;

                if (matchTrx && matchStatus) {
                    row.classList.add('is-filtered');
                } else {
                    row.classList.remove('is-filtered');
                }
            });

            // Filter Mobile Cards
            allMobileCards.forEach(card => {
                const trx = card.getAttribute('data-trx');
                const status = card.getAttribute('data-status');

                const matchTrx = trx.includes(trxQuery);
                const matchStatus = statusQuery === 'all' || status === statusQuery;

                if (matchTrx && matchStatus) {
                    card.classList.add('is-filtered');
                } else {
                    card.classList.remove('is-filtered');
                }
            });

            updatePaginationUI();
        }

        function resetFilters() {
            document.getElementById('trxSearch').value = '';
            document.getElementById('statusFilter').value = 'all';
            applyFilters();
        }

        function updatePaginationUI() {
            const filteredTableRows = allTableRows.filter(row => row.classList.contains('is-filtered'));
            const filteredMobileCards = allMobileCards.filter(card => card.classList.contains('is-filtered'));

            const totalFiltered = filteredTableRows.length;
            totalItems = totalFiltered; // Update global total for pagination

            let startIndex = (currentPage - 1) * itemsPerPage;
            let endIndex = startIndex + itemsPerPage;

            // Hide all first
            allTableRows.forEach(row => row.style.display = 'none');
            allMobileCards.forEach(card => card.style.display = 'none');

            // Show only current page from filtered list
            filteredTableRows.forEach((row, index) => {
                if (index >= startIndex && index < endIndex) {
                    row.style.display = 'table-row';
                }
            });

            filteredMobileCards.forEach((card, index) => {
                if (index >= startIndex && index < endIndex) {
                    card.style.display = 'block';
                }
            });

            const pageInfo = document.getElementById('pageInfoText');
            if (pageInfo) {
                const statusText = document.getElementById('statusFilter').value;
                const displayStatus = statusText !== 'all' ? statusText.charAt(0).toUpperCase() + statusText.slice(1) : "";

                // Update No Results Messages
                const noResultsRow = document.getElementById('noResultsRow');
                const noResultsMobile = document.getElementById('noResultsMobile');

                if (totalFiltered > 0) {
                    if (noResultsRow) noResultsRow.style.display = 'none';
                    if (noResultsMobile) noResultsMobile.style.display = 'none';

                    let endDisplay = endIndex > totalFiltered ? totalFiltered : endIndex;
                    let startDisplay = startIndex + 1;
                    pageInfo.innerText = `${startDisplay}–${endDisplay} of ${totalFiltered}`;

                    document.getElementById('prevPageBtn').disabled = currentPage === 1;
                    document.getElementById('nextPageBtn').disabled = endIndex >= totalFiltered;

                    // Show pagination controls if results exist
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
                    document.getElementById('prevPageBtn').disabled = true;
                    document.getElementById('nextPageBtn').disabled = true;

                    // Hide pagination controls if no results
                    document.querySelector('.custom-pagination').style.display = 'none';
                }
            }
        }

        function changeItemsPerPage() {
            itemsPerPage = parseInt(document.getElementById('itemsPerPage').value);
            currentPage = 1;
            updatePaginationUI();
        }

        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePaginationUI();
            }
        }

        function nextPage() {
            let maxPage = Math.ceil(totalItems / itemsPerPage);
            if (currentPage < maxPage) {
                currentPage++;
                updatePaginationUI();
            }
        }

        document.addEventListener('DOMContentLoaded', initPagination);
    </script>
@endpush

@push('style')
    <style>
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
            filter: brightness(0.2) sepia(0.5) hue-rotate(-10deg);
            opacity: 0.4;
        }

        /* Dashboard Container */
        .dashboard-container {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
            animation: fadeIn 0.5s ease;
            position: relative;
            z-index: 1;
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

        /* Dashboard Header */
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

        .user-id {
            color: var(--text-muted);
            font-size: 14px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
        }

        .referral-box {
            background: rgba(20, 20, 20, 0.8);
            border: 1px solid var(--border-red);
            border-radius: 10px;
            padding: 15px;
            width: 100%;
        }

        .referral-label {
            color: var(--text-muted);
            font-size: 13px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stat-summary {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            color: var(--text-light);
            font-size: 14px;
        }

        .stat-summary strong {
            color: var(--light-red);
            margin-left: 5px;
        }

        .card-header {
            padding: 20px 25px;
            background: rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid var(--border-red);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card-actions-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: nowrap;
        }

        .filter-controls {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .filter-item {
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-item::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 12px;
            color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
            font-size: 12px;
        }

        .btn-reset-filters {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.2);
            color: var(--light-red);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .btn-reset-filters:hover {
            background: var(--light-red);
            color: white;
            transform: rotate(180deg);
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
        }

        .filter-select,
        .filter-input {
            background: #000 !important;
            border: 1px solid rgba(255, 0, 0, 0.2) !important;
            color: white !important;
            padding: 8px 30px 8px 15px;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: var(--transition);
            height: 40px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .filter-select option {
            background: #0d0d0d;
            color: #fff;
            padding: 10px;
            border: none !important;
        }

        .filter-select:focus,
        .filter-input:focus {
            border-color: var(--light-red) !important;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.2);
        }

        .search-group {
            position: relative;
            display: flex;
            align-items: center;
            width: 280px;
        }

        .search-input {
            background: #000 !important;
            border: 1px solid rgba(255, 0, 0, 0.3) !important;
            color: white !important;
            padding: 10px 15px 10px 45px !important;
            border-radius: 10px;
            font-size: 14px;
            width: 100%;
            outline: none;
            transition: all 0.3s ease;
            height: 45px;
        }

        .search-input:focus {
            border-color: var(--light-red) !important;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.2);
            background: rgba(255, 0, 0, 0.05) !important;
        }

        .search-icon-box {
            position: absolute;
            left: 15px;
            color: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-input:focus+.search-icon-box {
            color: var(--light-red);
        }

        /* Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--gradient-card);
            border-radius: 12px;
            border: 1px solid var(--border-red);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--light-red);
            box-shadow: var(--shadow-red);
        }

        .stat-icon {
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

        .stat-info h4 {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0 0 5px 0;
            font-weight: 500;
        }

        .stat-info h3 {
            color: var(--text-white);
            font-size: 20px;
            margin: 0;
            font-weight: 700;
        }

        .stat-trend {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            flex-shrink: 0;
        }

        .stat-trend.up {
            background: rgba(0, 255, 0, 0.1);
            color: var(--success-green);
        }

        .stat-trend.down {
            background: rgba(255, 0, 0, 0.1);
            color: var(--danger-red);
        }

        /* Deposit Card */
        .deposit-card {
            background: var(--gradient-card);
            border-radius: 15px;
            border: 1px solid var(--border-red);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            transition: var(--transition);
        }

        .deposit-card:hover {
            border-color: var(--light-red);
            box-shadow: var(--shadow-red);
        }

        .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-red);
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-header h3 {
            color: var(--text-white);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
        }

        .search-form {
            display: flex;
        }

        .search-group {
            display: flex;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border-red);
            border-radius: 8px;
            overflow: hidden;
        }

        .search-input {
            background: transparent;
            border: none;
            padding: 10px 15px;
            color: var(--text-white);
            min-width: 250px;
            font-size: 14px;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-btn {
            background: var(--gradient-red);
            border: none;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-btn:hover {
            background: var(--light-red);
        }

        /* Enhanced Desktop Table */
        .deposits-table.desktop-view {
            display: block;
            overflow-x: auto;
            padding: 5px;
        }

        .deposits-table.desktop-view::-webkit-scrollbar {
            height: 8px;
        }

        .deposits-table.desktop-view::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .deposits-table.desktop-view::-webkit-scrollbar-thumb {
            background: var(--gradient-red);
            border-radius: 4px;
        }

        .deposits-mobile-view {
            display: none;
        }

        .deposit-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 900px;
            border-radius: 12px;
            overflow: hidden;
        }

        .deposit-table thead {
            background: #8b0000;
            position: relative;
        }

        .deposit-table thead::after {
            display: none;
        }

        .deposit-table th {
            padding: 15px 15px;
            text-align: left;
            color: var(--text-white);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            border: none;
        }

        .deposit-table th:not(:last-child)::after {
            display: none;
        }

        .deposit-table tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.2s ease;
            background: transparent;
        }

        .deposit-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .deposit-table td {
            padding: 15px 15px;
            color: var(--text-light);
            font-size: 13px;
            vertical-align: middle;
            text-align: left;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .deposit-table td:not(:last-child)::after {
            display: none;
        }

        .deposit-table tr:last-child td {
            border-bottom: none;
        }

        .serial-number {
            display: inline-block;
            color: var(--text-light);
            font-weight: 500;
            font-size: 13px;
        }

        .date-time-cell {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }

        .date-time-cell .date {
            color: var(--text-white);
            font-size: 13px;
            font-weight: 500;
        }

        .date-time-cell .time {
            color: var(--text-muted);
            font-size: 11px;
        }

        .gateway-info {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: flex-start;
        }

        .gateway-icon {
            display: none;
            /* Hide icon for cleaner look */
        }

        .gateway-name {
            color: var(--text-white);
            font-weight: 500;
            font-size: 13px;
        }

        .trx-code {
            color: var(--text-white);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            background: none;
            padding: 0;
            border: none;
            box-shadow: none;
        }

        .amount-cell {
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: flex-start;
        }

        .amount-main {
            color: var(--text-white);
            font-weight: 500;
            font-size: 13px;
        }

        .currency {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }

        .charge-text {
            color: var(--danger-red);
            font-size: 13px;
            font-weight: 500;
        }

        .total-amount {
            color: var(--success-green);
            font-weight: 600;
            font-size: 13px;
        }

        .badge,
        [class*="badge--"] {
            padding: 5px 12px !important;
            border-radius: 4px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            background: transparent !important;
            border: 1px solid currentColor !important;
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

        .badge--dark {
            color: #888888 !important;
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
        }

        .action-btn:hover {
            background: #ff0000;
            transform: translateY(-2px);
        }

        .action-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .deposit-table td:nth-child(8) {
            text-align: left;
        }

        /* Enhanced Mobile Cards View */
        /* Premium Mobile Card Design */
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
            gap: 12px;
            margin-bottom: 12px;
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

        .total-business-value {
            color: #00ff00 !important;
        }

        .card-mobile-actions {
            margin-top: 10px;
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

        .view-details-btn-mobile.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Pagination */
        .pagination-container {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination .page-item {
            margin: 0;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }

        .pagination .page-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-red);
            color: var(--text-light);
            padding: 10px 16px;
            border-radius: 8px;
            transition: var(--transition);
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }

        .pagination .page-link:hover {
            background: var(--gradient-red);
            color: white;
            border-color: var(--light-red);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
        }

        .pagination .page-item.active .page-link {
            background: var(--gradient-red);
            color: white;
            border-color: var(--light-red);
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5);
        }

        /* Empty State */
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

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
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
        }

        /* Modal Logic & Fixes */
        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        .modal-backdrop.show {
            backdrop-filter: blur(8px);
            background-color: rgba(0, 0, 0, 0.8) !important;
            opacity: 1 !important;
        }

        /* Modal Styles - Glassmorphism */
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

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 0, 0, 0.2);
            padding: 15px 20px;
            background: linear-gradient(135deg, rgba(139, 0, 0, 0.3) 0%, transparent 100%);
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
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .transaction-summary-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: var(--gradient-red);
        }

        .status-icon-wrapper i {
            filter: drop-shadow(0 0 15px currentColor);
            animation: pulseIcon 2s infinite;
        }

        @keyframes pulseIcon {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .final-amount {
            font-size: 24px;
            letter-spacing: -0.5px;
        }

        .info-grid-modern {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item-modern {
            background: rgba(255, 255, 255, 0.03);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .info-item-modern:hover {
            background: rgba(255, 0, 0, 0.05);
            border-color: rgba(255, 0, 0, 0.2);
        }

        .info-item-modern .label {
            margin-bottom: 4px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item-modern .value {
            font-size: 14px;
        }

        .modal-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            margin: 0 20px;
        }

        .bg-dark-accent {
            background: rgba(255, 0, 0, 0.05);
            border-top: 1px solid rgba(255, 0, 0, 0.1);
        }

        .btn-download {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-white);
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .btn-download:hover {
            background: var(--gradient-red);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
        }

        .close-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 25px;
        }

        .details-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            animation: slideInRight 0.5s ease forwards;
            opacity: 0;
        }

        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
            min-width: 150px;
        }

        .detail-value {
            color: var(--text-white);
            font-size: 14px;
            font-weight: 600;
            max-width: 60%;
            text-align: right;
            word-break: break-word;
            background: rgba(255, 255, 255, 0.03);
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid var(--light-red);
        }

        .feedback-box {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255, 0, 0, 0.08);
            border-radius: 10px;
            border-left: 4px solid var(--light-red);
            animation: fadeIn 0.6s ease;
        }

        .feedback-box h6 {
            color: var(--light-red);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
        }

        .feedback-content {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            padding: 10px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modal-footer {
            border-top: 1px solid var(--border-red);
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
        }

        .btn-close-modal {
            background: var(--gradient-red);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-close-modal:hover {
            background: var(--light-red);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.4);
        }

        /* Responsive Design */
        @media screen and (max-width: 1024px) {
            .dashboard-container {
                margin-left: 0;
                padding: 20px 15px;
                padding-bottom: 80px;
            }

            .nav {
                display: flex;
            }

            .quick-stats {
                grid-template-columns: 1fr;
                gap: 15px;
                margin-bottom: 30px !important;
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
        }

        @media screen and (max-width: 768px) {
            .deposits-table.desktop-view {
                display: none;
            }

            .deposits-mobile-view {
                display: block;
            }

            .card-header {
                padding: 15px !important;
                gap: 15px !important;
            }

            .card-actions-wrapper {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .filter-controls {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr auto;
                gap: 10px;
            }

            .filter-item {
                width: 100%;
            }

            .filter-select {
                width: 100% !important;
            }

            .search-group {
                width: 100% !important;
            }

            .deposit-card-mobile {
                margin-bottom: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            .dashboard-container {
                padding: 15px 12px;
                padding-bottom: 80px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .stat-info h3 {
                font-size: 18px;
            }

            .deposit-card-mobile {
                padding: 15px;
            }

            .deposit-amount-mobile {
                font-size: 16px;
            }

            .detail-label,
            .detail-value {
                font-size: 12px;
            }
        }

        footer {
            display: none !important;
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
@endpush