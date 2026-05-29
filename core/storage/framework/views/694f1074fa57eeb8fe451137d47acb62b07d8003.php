<?php $__env->startSection('content'); ?>
<div class="transaction-section padding-top padding-bottom">
    
    
    
    
    <div class="container">
        <div class="primary-bg item-rounded">
            <div class="text-end p-3">
                <a href="<?php echo e(route('ticket.open')); ?>" class="custom-button theme btn-sm text-white"><i class="fas fa-plus"></i> <?php echo app('translator')->get('New Ticket'); ?></a>
            </div>
            <table class="deposite-table">
                <thead class="custom--table">
                    <tr>
                        <th><?php echo app('translator')->get('Subject'); ?></th>
                        <th><?php echo app('translator')->get('Status'); ?></th>
                        <th><?php echo app('translator')->get('Priority'); ?></th>
                        <th><?php echo app('translator')->get('Last Reply'); ?></th>
                        <th><?php echo app('translator')->get('Action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td> <a href="<?php echo e(route('ticket.view', $support->ticket)); ?>" class="text-white"> [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?> </a></td>
                            <td>
                                <?php if($support->status == 0): ?>
                                    <span class="badge badge--success py-2 px-3"><?php echo app('translator')->get('Open'); ?></span>
                                <?php elseif($support->status == 1): ?>
                                    <span class="badge badge--primary py-2 px-3"><?php echo app('translator')->get('Answered'); ?></span>
                                <?php elseif($support->status == 2): ?>
                                    <span class="badge badge--warning py-2 px-3"><?php echo app('translator')->get('Customer Reply'); ?></span>
                                <?php elseif($support->status == 3): ?>
                                    <span class="badge badge--dark py-2 px-3"><?php echo app('translator')->get('Closed'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($support->priority == 1): ?>
                                    <span class="badge badge--dark py-2 px-3"><?php echo app('translator')->get('Low'); ?></span>
                                <?php elseif($support->priority == 2): ?>
                                    <span class="badge badge--success py-2 px-3"><?php echo app('translator')->get('Medium'); ?></span>
                                <?php elseif($support->priority == 3): ?>
                                    <span class="badge badge--primary py-2 px-3"><?php echo app('translator')->get('High'); ?></span>
                                <?php else: ?>
                                     <span class="badge badge--info py-2 px-3"><?php echo app('translator')->get('N/A'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($support->last_reply)->diffForHumans()); ?> </td>
                            <td>
                                <a href="<?php echo e(route('ticket.view', $support->ticket)); ?>" class="btn btn--primary btn-sm">
                                    <i class="fa fa-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e(paginateLinks($supports)); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/support/index.blade.php ENDPATH**/ ?>