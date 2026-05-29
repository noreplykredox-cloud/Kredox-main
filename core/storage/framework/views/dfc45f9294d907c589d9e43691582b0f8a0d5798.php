<?php
    $referrals = $user->referrals ?? [];
?>

<?php if($user->allReferrals->count()): ?>
    <ul style="display: flex">
        <?php $__currentLoopData = $user->allReferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <div class="node" onclick="toggleChildren(this)">
                    <?php echo e($child->fullname); ?> (<?php echo e($child->username); ?>) - $<?php echo e($child->plan->price ?? 0); ?>

                    <div class="user-count"><?php echo e($child->allReferrals->count()); ?> users under</div>
                </div>
                <?php echo $__env->make($activeTemplate . 'partials.under_tree_graph', ['user' => $child], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/templates/basic/partials/under_tree_graph.blade.php ENDPATH**/ ?>