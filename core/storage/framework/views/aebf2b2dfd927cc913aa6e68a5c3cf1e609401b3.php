
<?php
    $content = getContent('deposit_withdraw.content', true);
    $deposits = App\Models\Deposit::where('status', Status::PAYMENT_SUCCESS)->with('user', 'gateway')->orderBy('id', 'DESC')->limit(10)->get();
    $withdrwals = App\Models\Withdrawal::where('status', Status::PAYMENT_SUCCESS)->with('user', 'method')->orderBy('id', 'DESC')->limit(10)->get();
?>
<section class="deposit-withdraw padding-bottom padding-top">
    <div class="container">
        <div class="row mb--50">
            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title"><?php echo e(__(@$content->data_values->deposit_heading)); ?></h3>
                    <p><?php echo e(__(@$content->data_values->deposit_sub_heading)); ?></p>
                </div>
                <table class="deposit-table">
                    <thead>
                    <tr>
                        <th><?php echo app('translator')->get('Name'); ?></th>
                        <th><?php echo app('translator')->get('Amount'); ?></th>
                        <th><?php echo app('translator')->get('Date'); ?></th>
                        <th><?php echo app('translator')->get('Gateway'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__(@$deposit->user->fullname)); ?></td>
                                <td><?php echo e(showAmount($deposit->amount)); ?> <?php echo e(__($general->cur_text)); ?></td>
                                <td><?php echo e(showdateTime($deposit->created_at, 'd M Y')); ?></td>
                                <td>
                                    <?php if($deposit->method_code != 0): ?>
                                        <?php echo e(__(@$deposit->gateway->name)); ?>

                                    <?php else: ?>
                                        <?php echo app('translator')->get('E-pin'); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="100%" class="text-center"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6 mb-50">
                <div class="section-header margin-olpo left-style text-center">
                    <h3 class="title"><?php echo e(__(@$content->data_values->withdraw_heading)); ?></h3>
                    <p><?php echo e(__(@$content->data_values->withdraw_sub_heading)); ?></p>
                </div>

                <table class="deposit-table">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Amount'); ?></th>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                            <th><?php echo app('translator')->get('Method'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $withdrwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__($withdrwal->user->fullname)); ?></td>
                                <td><?php echo e(showAmount($withdrwal->amount)); ?> <?php echo e(__($general->cur_text)); ?></td>
                                <td><?php echo e(showdateTime($withdrwal->created_at, 'd M Y')); ?></td>
                                <td>
                                    <?php if($withdrwal->method_id != 0): ?>
                                        <?php echo e(__($withdrwal->method->name)); ?>

                                    <?php else: ?>
                                        <?php echo app('translator')->get('E-pin'); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="100%" class="text-center"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/sections/deposit_withdraw.blade.php ENDPATH**/ ?>