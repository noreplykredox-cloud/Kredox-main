<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('User|Admin'); ?></th>
                                    <?php if(request()->routeIs('admin.pin.used')): ?>
                                        <th><?php echo app('translator')->get('Username'); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Pin'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Creations Date'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if($pin->generate_user_id): ?>
                                                <?php echo e(__($pin->details)); ?>

                                                <br>
                                                <span class="small text-center">
                                                    <a
                                                        href="<?php echo e(route('admin.users.detail', $pin->generate_user_id)); ?>"><span>@</span><span><?php echo e($pin->createUser->username); ?></span></a>
                                                </span>
                                            <?php else: ?>
                                                <?php echo e(__($pin->details)); ?>

                                                <br>
                                                <span class="small">
                                                    <span><?php echo app('translator')->get('admin'); ?></span>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if(request()->routeIs('admin.pin.used')): ?>
                                            <td>
                                                <span><?php echo e(__($pin->user->fullname)); ?></span>
                                                <br>
                                                <span class="small">
                                                    <a
                                                        href="<?php echo e(route('admin.users.detail', $pin->user_id)); ?>"><span>@</span><?php echo e(__($pin->user->username)); ?></a>
                                                </span>
                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <span><?php echo e(getAmount($pin->amount)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span>
                                        </td>
                                        <td>
                                            <?php echo e(__($pin->pin)); ?>

                                        </td>
                                        <td>
                                            <?php if($pin->status == 1): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Used'); ?></span>
                                                <br>
                                                <?php echo e(diffForHumans($pin->updated_at)); ?>

                                            <?php elseif($pin->status == 0): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Unused'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($pin->created_at)); ?> <br>
                                            <?php echo e(diffForHumans($pin->created_at)); ?>

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
                <?php if($pins->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($pins) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div id="addModalPin" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Created Pin'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.pin.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Amount'); ?></label>
                            <div class="input-group mb-3">
                                <input type="number" id="amount" class="form-control" placeholder="<?php echo app('translator')->get('Enter Amount'); ?>"
                                    name="amount" aria-label="Recipient's username" aria-describedby="basic-addon2" step="any" required="">
                                <div class="input-group-text">
                                    <?php echo e(__($general->cur_text)); ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Total Number of Pin'); ?></label>
                            <input type="number" class="form-control" name="number" placeholder="<?php echo app('translator')->get('Enter Number'); ?>"
                                required="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Created'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <button class="btn btn-outline--primary addPin"><i class="las la-paper-plane"></i><?php echo app('translator')->get('Created Pin'); ?></button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.addPin').on('click', function() {
                $('#addModalPin').modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/admin/pin/index.blade.php ENDPATH**/ ?>