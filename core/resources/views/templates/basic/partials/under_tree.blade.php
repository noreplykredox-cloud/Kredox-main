<style>
    /* Base Styles */
    .list-container {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 15px;
        margin: 20px 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.4);
        overflow: hidden;
    }

    .list-header {
        display: none; /* Hidden by default, shown only on desktop */
    }

    .list-row {
        display: flex;
        flex-direction: column;
        padding: 16px;
        margin-bottom: 12px;
        background: rgba(17, 34, 64, 0.9);
        border-radius: 10px;
        border-left: 4px solid var(--accent-color);
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .list-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,255,204,0.1);
    }

    .list-row-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(100, 255, 218, 0.1);
    }

    .list-row-item:last-child {
        border-bottom: none;
    }

    .list-row-label {
        font-weight: 600;
        color: var(--accent-color);
        font-size: 14px;
        min-width: 100px;
    }

    .list-row-value {
        text-align: right;
        color: var(--light-color);
        font-size: 14px;
        flex-grow: 1;
        padding-left: 10px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        width: 100%;
            text-align: center; !important 

    }

    .user-name {
        font-size: 16px;
        font-weight: 600;
        color: var(--lighter-color);
        margin-bottom: 4px;
    }

    .user-username {
        font-size: 13px;
        color: var(--accent-color);
    }

    .level-badge {
        background: rgba(0, 201, 167, 0.2);
        color: var(--accent-color);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Desktop Styles */
    @media (min-width: 768px) {
            .list-header {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                padding: 12px 20px;
                background: rgba(0, 201, 167, 0.1);
                border-radius: 8px;
                margin-bottom: 12px;
                font-weight: 600;
                color: var(--accent-color);
            }

            .list-row {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                align-items: center;
                padding: 12px 20px;
                border-left: 3px solid transparent;
            }

            .list-row:hover {
                border-left: 3px solid var(--accent-color);
                transform: translateX(5px);
            }

            .list-row-item {
                display: contents; /* Reset mobile styles */
                border-bottom: none;
            }

            .list-row-label {
                display: none;
            }

            .list-row-value {
                text-align: left;
                padding-left: 0;
                justify-content: flex-start;
            }

            .user-info {
                align-items: flex-start;
                text-align: left;
            }

            /* Add vertical separators */
            .list-row > div:not(:first-child) {
                position: relative;
                padding-left: 15px;
            }

            .list-row > div:not(:first-child)::before {
                content: "";
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                height: 60%;
                width: 1px;
                background: rgba(100, 255, 218, 0.3);
            }
        }

        /* Pagination Styles */
        .list-pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .list-pagination button {
            background: rgba(17, 34, 64, 0.7);
            border: 1px solid var(--accent-color);
            color: var(--light-color);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 40px;
        }

        .list-pagination button:hover {
            background: var(--accent-color);
            color: var(--darker-color);
        }

        .list-pagination button.active {
            background: var(--accent-color);
            color: var(--darker-color);
        }
</style>

<div class="transaction-section padding-top padding-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="list-controls">
                    <div class="list-search">
                        <input type="text" id="listSearch" placeholder="Search team members...">
                    </div>
                    <div class="level-filter">
                        <span>Filter Level:</span>
                        <select id="levelFilter">
                            <option value="all">All Levels</option>
                            @for($i = 1; $i <= ($general->matrix_height ?? 10); $i++)
                                <option value="{{ $i }}">Level {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="list-container">
                    <div class="list-header">
                        <div>Member</div>
                        <div>Level</div>
                        <div>Team Size</div>
                        <div>Investment</div>
                    </div>
                    
                    <!-- Main User -->
                    <div class="list-row">
                        <div class="list-row-item">
                            <span class="list-row-label">Member</span>
                            <div class="list-row-value">
                                <div class="user-info">
                                    <span class="user-name">{{ $user->fullname }}</span>
                                    <span class="user-username">{{ $user->username }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-row-item">
                            <span class="list-row-label">Level</span>
                            <div class="list-row-value"><span class="level-badge">Level 0</span></div>
                        </div>
                        <div class="list-row-item">
                            <span class="list-row-label">Team Size</span>
                            <div class="list-row-value stats-count">{{ $user->allReferrals->count() }} members</div>
                        </div>
                        <div class="list-row-item">
                            <span class="list-row-label">Investment</span>
                            <div class="list-row-value stats-value">
                                @php
                                    $transactions = DB::table('transactions')
                                        ->where('remark', 'LIKE', '%plan_purchase%')
                                        ->where('user_id', $user->id)
                                        ->sum('amount');
                                    echo number_format($transactions, 2) . ' USDT';
                                @endphp
                            </div>
                        </div>
                    </div>
                    
                    <!-- Referrals List -->
                    @foreach($allReferrals as $ref)
                        @php
                            $transactions = DB::table('transactions')
                                ->where('remark', 'LIKE', '%plan_purchase%')
                                ->where('user_id', $ref['user']->id)
                                ->sum('amount');
                        @endphp
                        
                        <div class="list-row" data-level="{{ $ref['level'] }}">
                            <div class="list-row-item">
                                <span class="list-row-label">Member</span>
                                <div class="list-row-value">
                                    <div class="user-info">
                                        <span class="user-name">{{ $ref['user']->fullname }}</span>
                                        <span class="user-username">{{ $ref['user']->username }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-row-item">
                                <span class="list-row-label">Level</span>
                                <div class="list-row-value"><span class="level-badge">Level {{ $ref['level'] }}</span></div>
                            </div>
                            <div class="list-row-item">
                                <span class="list-row-label">Team Size</span>
                                <div class="list-row-value stats-count">{{ $ref['user']->allReferrals->count() }} members</div>
                            </div>
                            <div class="list-row-item">
                                <span class="list-row-label">Investment</span>
                                <div class="list-row-value stats-value">{{ number_format($transactions, 2) }} USDT</div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if(count($allReferrals) == 0)
                        <div class="text-center py-4">
                            <p>No team members found</p>
                        </div>
                    @endif
                </div>
                
                <div class="list-pagination">
                    <button id="prevPage">Previous</button>
                    <div id="pageNumbers"></div>
                    <button id="nextPage">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>