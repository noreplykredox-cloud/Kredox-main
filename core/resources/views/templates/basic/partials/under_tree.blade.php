<?php 
$totalAmount = 0;

/*foreach($user->transallReferrals as $underr) {
    $totalAmount += $underr->amount;
}*/
?>

<ul @if($isFirst) class="firstList" @endif>
    @foreach($user->allReferrals as $under)
        @if($loop->first)
            @php $layer++ @endphp
        @endif
        <?php 
        $transactions = DB::table('transactions')
            ->where('remark', 'LIKE', '%plan_purchase%')
            ->where('user_id', $under->id)
            ->sum('amount'); 

        $transactions = number_format($transactions, 2, '.', ''); // Format to 2 decimal places
        ?>
        <li>{{ $under->fullname }} ( {{ $under->username }} ) -  {{ $transactions }} USDT  
           
            @if(($under->allReferrals->count()) > 0 && ($layer < $general->matrix_height))
                @include($activeTemplate.'partials.under_tree',['user'=>$under,'layer'=>$layer,'isFirst'=>false])
            @endif
        </li>
    @endforeach
</ul>
