
    @foreach($user->allReferrals as $under)
        @if($loop->first)
            @php $layer++ @endphp
        @endif
         @foreach($user->transallReferrals as $underr)    <?php
         $total = 0;
         //$total += $underr->amount;

         $total= [$underr->amount,];
         $sumofelements = array_sum($total); 

         $sum=$sum+$sumofelements;
     ?>
        
        @endforeach
           @if(($under->allReferrals->count()) > 0 && ($layer < $general->matrix_height))
                @include($activeTemplate.'partials.total_price',['user'=>$under,'layer'=>$layer,'isFirst'=>false])
            @endif 
        
    @endforeach

    <h4 class="amount childaount">${{$sum}}</h4>



