<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Referral Bonus'); ?></th>
                                    <th><?php echo app('translator')->get('Benefit / Loss'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $totalAmount = $plan->sumLevelOfCommission($plan->id) + $plan->referral_bonus;
                                        $finalAmount = $plan->price - $totalAmount;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo e(__($plan->name)); ?>

                                        </td>

                                        <td>
                                            <span><?php echo e(showAmount($plan->price)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span>
                                        </td>

                                        <td>
                                            <span><?php echo e(showAmount($plan->referral_bonus)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span>
                                        </td>

                                        <td>
                                            <?php if($plan->price > $totalAmount): ?>
                                                <span class="text--success"><?php echo app('translator')->get('Admin Benefit'); ?> <?php echo e(showAmount($finalAmount)); ?>

                                                    <?php echo e(__($general->cur_text)); ?></span>
                                            <?php else: ?>
                                                <span class="text--danger"><?php echo app('translator')->get('Admin Loss'); ?>
                                                    <?php echo e(abs(showAmount($finalAmount))); ?> <?php echo e(__($general->cur_text)); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php
                                                echo $plan->statusBadge;
                                            ?>
                                        </td>

                                        <td>

                                            <a href="<?php echo e(route('admin.plan.edit', $plan->id)); ?>"
                                                class="btn btn-sm btn-outline--primary editGatewayBtn">
                                                <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?>
                                            </a>

                                            <?php if($plan->status == Status::DISABLE): ?>
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn"
                                                    data-question="<?php echo app('translator')->get('Are you sure to enable this plan?'); ?>"
                                                    data-action="<?php echo e(route('admin.plan.status', $plan->id)); ?>">
                                                    <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn"
                                                    data-question="<?php echo app('translator')->get('Are you sure to disable this plan?'); ?>"
                                                    data-action="<?php echo e(route('admin.plan.status', $plan->id)); ?>">
                                                    <i class="la la-eye-slash"></i> <?php echo app('translator')->get('Disable'); ?>
                                                </button>
                                            <?php endif; ?>

                                        </td>
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
                <?php if($plans->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($plans) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="matrixSettingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Matrix Setting Update'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.plan.matrix.setting')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Matrix Height'); ?></label>
                            <input type="number" class="form-control form-control-lg" name="matrix_height"
                                value="<?php echo e($general->matrix_height); ?>" required="">
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Matrix Width'); ?></label>
                            <input type="number" class="form-control form-control-lg" name="matrix_width"
                                value="<?php echo e($general->matrix_width); ?>" required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <button type="button" class="btn btn-sm btn-outline--info matrixSetting"><i class="las la-paper-plane"></i><?php echo app('translator')->get('Matrix Setting'); ?></button>

    <a href="<?php echo e(route('admin.plan.create')); ?>" class="btn btn-sm btn-outline--primary addPlan"><i
            class="las la-plus"></i><?php echo app('translator')->get('Add Plan'); ?></a>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            $('.matrixSetting').click(function() {
                $('#matrixSettingModal').modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/admin/plan/index.blade.php ENDPATH**/ ?>