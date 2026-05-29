
    <?php $__currentLoopData = $user->allReferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $under): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first): ?>
            <?php $layer++ ?>
        <?php endif; ?>
         <?php $__currentLoopData = $user->transallReferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $underr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    <?php
         $total = 0;
         //$total += $underr->amount;

         $total= [$underr->amount,];
         $sumofelements = array_sum($total); 

         $sum=$sum+$sumofelements;
     ?>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <?php if(($under->allReferrals->count()) > 0 && ($layer < $general->matrix_height)): ?>
                <?php echo $__env->make($activeTemplate.'partials.total_price',['user'=>$under,'layer'=>$layer,'isFirst'=>false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?> 
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <h4 class="amount childaount">$<?php echo e($sum); ?></h4>



<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/partials/total_price.blade.php ENDPATH**/ ?>