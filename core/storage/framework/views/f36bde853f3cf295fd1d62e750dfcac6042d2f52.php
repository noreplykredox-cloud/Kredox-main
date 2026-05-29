
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Trx'); ?></th>
                                    <th><?php echo app('translator')->get('User By'); ?></th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Post Balance'); ?></th>
                                    <th><?php echo app('translator')->get('Detail'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span><?php echo e($commission->user->fullname); ?></span>
                                            <br>
                                            <span class="small"> <a
                                                    href="<?php echo e(route('admin.users.detail', $commission->user_id)); ?>"><span>@</span><?php echo e($commission->user->username); ?></a>
                                            </span>
                                        </td>

                                        <td>
                                            <strong><?php echo e($commission->trx); ?></strong>
                                        </td>


                                        <td>
                                            <span><?php echo e($commission->fromUser->fullname); ?></span>
                                            <br>
                                            <span class="small"> <a
                                                    href="<?php echo e(route('admin.users.detail', $commission->from_user_id)); ?>"><span>@</span><?php echo e($commission->fromUser->username); ?></a>
                                            </span>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($commission->created_at)); ?><br><?php echo e(diffForHumans($commission->created_at)); ?>

                                        </td>

                                        <td class="budget">
                                            <span class="text--success">
                                                + <?php echo e(showAmount($commission->amount)); ?> <?php echo e(__($general->cur_text)); ?>

                                            </span>
                                        </td>

                                        <td class="budget">
                                            <?php echo e(showAmount($commission->post_balance)); ?> <?php echo e(__($general->cur_text)); ?>

                                        </td>


                                        <td><?php echo e(__($commission->details)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($commissions->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($commissions) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if(request()->routeIs('admin.users.referral.commission') || request()->routeIs('admin.users.level.commission')): ?>
        <form action="" method="GET" class="form-inline float-sm-right bg--white">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('TRX.....'); ?>"
                    value="<?php echo e($search ?? ''); ?>">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    <?php else: ?>
        <form action="<?php echo e(route('admin.report.commissions.search')); ?>" method="GET"
            class="form-inline float-sm-right bg--white b-2 ml-0 ml-xl-2 ml-lg-0">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('TRX / Username'); ?>"
                    value="<?php echo e($search ?? ''); ?>">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <form action="<?php echo e(route('admin.report.commissions.log')); ?>" method="GET"
            class="form-inline float-sm-right bg--white">
            <div class="input-group">
                <select class="form-control" name="commissions">
                    <?php if(@$commi == 1): ?>
                        <option value="2"><?php echo app('translator')->get('Level Commissions'); ?></option>
                        <option value="1" selected=""><?php echo app('translator')->get('Referrals Commissions'); ?></option>
                    <?php elseif(@$commi == 2): ?>
                        <option value="2" selected><?php echo app('translator')->get('Level Commissions'); ?></option>
                        <option value="1"><?php echo app('translator')->get('Referrals Commissions'); ?></option>
                    <?php else: ?>
                        <option><?php echo app('translator')->get('Select One'); ?></option>
                        <option value="2"><?php echo app('translator')->get('Level Commissions'); ?></option>
                        <option value="1"><?php echo app('translator')->get('Referrals Commissions'); ?></option>
                    <?php endif; ?>
                </select>
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/admin/reports/commissions.blade.php ENDPATH**/ ?>