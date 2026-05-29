<?php 
$totalAmount = 0;

/*foreach($user->transallReferrals as $underr) {
    $totalAmount += $underr->amount;
}*/
?>

<ul <?php if($isFirst): ?> class="firstList" <?php endif; ?>>
    <?php $__currentLoopData = $user->allReferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $under): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first): ?>
            <?php $layer++ ?>
        <?php endif; ?>
        <?php 
        $transactions = DB::table('transactions')
            ->where('remark', 'LIKE', '%plan_purchase%')
            ->where('user_id', $under->id)
            ->sum('amount'); 

        $transactions = number_format($transactions, 2, '.', ''); // Format to 2 decimal places
        ?>
        <li><?php echo e($under->fullname); ?> ( <?php echo e($under->username); ?> ) -  <?php echo e($transactions); ?> USDT  
           
            <?php if(($under->allReferrals->count()) > 0 && ($layer < $general->matrix_height)): ?>
                <?php echo $__env->make($activeTemplate.'partials.under_tree',['user'=>$under,'layer'=>$layer,'isFirst'=>false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/templates/basic/partials/under_tree.blade.php ENDPATH**/ ?>