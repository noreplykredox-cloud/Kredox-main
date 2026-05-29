@php
    $referrals = $user->referrals ?? [];
@endphp

@if($user->allReferrals->count())
    <ul style="display: flex">
        @foreach($user->allReferrals as $child)
            <li>
                <div class="node" onclick="toggleChildren(this)">
                    {{ $child->fullname }} ({{ $child->username }}) - ${{ $child->plan->price ?? 0 }}
                    <div class="user-count">{{ $child->allReferrals->count() }} users under</div>
                </div>
                @include($activeTemplate . 'partials.under_tree_graph', ['user' => $child])
            </li>
        @endforeach
    </ul>
@endif