<?php $__env->startSection('content'); ?>
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="primary-bg item-rounded">
                <table class="deposite-table">
                    <thead class="custom--table">
                        <tr>
                            <th><?php echo app('translator')->get('User'); ?></th>
                            <th><?php echo app('translator')->get('TRX'); ?></th>
                            <th><?php echo app('translator')->get('Amount'); ?></th>
                            <th><?php echo app('translator')->get('Post Balance'); ?></th>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                            <th><?php echo app('translator')->get('Detail'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($commission->fromUser->username); ?></td>
                                <td><?php echo e($commission->trx); ?></td>
                                <td class="budget">
                                    <strong class="text--success">+ <?php echo e(getAmount($commission->amount)); ?>

                                        <?php echo e(__($general->cur_text)); ?></strong>
                                </td>
                                <td><?php echo e(getAmount($commission->post_balance)); ?>

                                    <?php echo e(__($general->cur_text)); ?></td>
                                <td>
                                    <?php echo e(showDateTime($commission->created_at)); ?>

                                    <br>
                                    <?php echo e(diffForHumans($commission->created_at)); ?>

                                </td>
                                <td><?php echo e(__($commission->details)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e(paginateLinks($commissions)); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/commission.blade.php ENDPATH**/ ?>