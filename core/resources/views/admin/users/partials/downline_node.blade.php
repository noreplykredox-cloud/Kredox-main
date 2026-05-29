@foreach($nodes as $node)
    <li>
        <div class="tree-card-wrapper" style="position: relative; display: inline-block;">
            <!-- Tree Card -->
            <div class="tree-card" onclick="showSchedulesModal(this)" 
                 data-username="{{ $node['username'] }}"
                 data-fullname="{{ $node['fullname'] }}"
                 data-email="{{ $node['email'] }}"
                 data-plan="{{ $node['plan_name'] }}"
                 data-invest="{{ $general->cur_sym }}{{ showAmount($node['invest_amount']) }}"
                 data-schedules="{{ json_encode($node['schedules']) }}"
                 style="background-color: #111827; border-radius: 12px; width: 220px; text-align: center; border: 2px solid #ef4444; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4); cursor: pointer; transition: all 0.3s; position: relative;">
                
                <!-- Hover Click Overlay -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5;" title="Click to view assigned income schedules"></div>

                <div class="p-3">
                    <!-- Avatar with glowing red border -->
                    <div class="mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #ef4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.5); overflow: hidden; background-color: #1f2937;">
                        <i class="las la-user-circle text--primary" style="font-size: 3rem;"></i>
                    </div>
                    
                    <!-- Name & Username -->
                    <h6 class="text-white mb-0 text-truncate" style="font-size: 0.95rem;">{{ $node['fullname'] }}</h6>
                    <small class="text-muted d-block text-truncate" style="font-size: 0.8rem; color: #9ca3af !important;">@`{{ $node['username'] }}`</small>
                    
                    <!-- Level Badge -->
                    <span class="badge mt-1 text-white" style="font-size: 0.7rem; background-color: #ef4444 !important; border-radius: 4px; padding: 3px 8px;">Level {{ $node['level'] }}</span>
                </div>
                
                <!-- Bottom Panel (TEAM & INVESTMENT) -->
                <div class="d-flex text-center py-2" style="border-top: 1px solid #1f2937; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; background-color: #1f2937 !important;">
                    <div class="w-50" style="border-right: 1px solid #374151;">
                        <small class="text-muted d-block" style="font-size: 0.65rem; text-transform: uppercase;">TEAM</small>
                        <span class="text-white fw-bold" style="font-size: 0.85rem;"><i class="las la-users text--danger me-1"></i>{{ $node['team_count'] }}</span>
                    </div>
                    <div class="w-50">
                        <small class="text-muted d-block" style="font-size: 0.65rem; text-transform: uppercase;">INVESTMENT</small>
                        <span class="text-white fw-bold" style="font-size: 0.85rem;">{{ $general->cur_sym }}{{ showAmount($node['invest_amount']) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Expand/Collapse Button floated on the line -->
            @if(!empty($node['children']))
                <button class="tree-toggle-btn" onclick="toggleChildren(this)">
                    <i class="las la-minus"></i>
                </button>
            @endif
        </div>

        <!-- Children recursive tree -->
        @if(!empty($node['children']))
            <ul>
                @include('admin.users.partials.downline_node', ['nodes' => $node['children']])
            </ul>
        @endif
    </li>
@endforeach
