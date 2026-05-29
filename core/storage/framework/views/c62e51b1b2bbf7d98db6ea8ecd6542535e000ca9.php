<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-lg-12">
            <form action="<?php echo e(route('admin.plan.update', $plan->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label><?php echo app('translator')->get('Name'); ?></label>
                                <input type="text" class="form-control form-control-lg" name="name"
                                    value="<?php echo e($plan->name); ?>" required="">
                            </div>

                            <div class="form-group col-lg-4">
                                <label><?php echo app('translator')->get('Price'); ?></label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control form-control-lg" name="price"
                                        value="<?php echo e(getAmount($plan->price)); ?>" id="planAmount"
                                        aria-describedby="basic-addon2" step="any" required>
                                    <div class="input-group-text">
                                        <?php echo e(__($general->cur_text)); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-4">
                                <label><?php echo app('translator')->get('Referral Bonus'); ?></label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control form-control-lg" id="referralBonus"
                                        name="referral_bonus" value="<?php echo e(getAmount($plan->referral_bonus)); ?>"
                                        aria-describedby="basic-addon2" step="any" required="">
                                    <div class="input-group-text">
                                        <?php echo e(__($general->cur_text)); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-center my-4"><?php echo app('translator')->get('Level Commissions'); ?></h4>

                        <div class="row">
                            <?php for($i = 0; $i < $general->matrix_height; $i++): ?>
                                <div class="form-group col-lg-3">
                                    <label><?php echo app('translator')->get('Level '); ?><?php echo e($i + 1); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg commissionAmount"
                                            name="level[<?php echo e($i + 1); ?>]"
                                            value="<?php echo e(getAmount(@$plan->level[$i]->amount)); ?>"
                                            aria-describedby="basic-addon2" step="any" required="">
                                        <div class="input-group-text">
                                            <?php echo e(__($general->cur_text)); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="text-center mb-4">
                            <div id="adminProfit">
                                <?php if($plan->price > $totalAmount): ?>
                                    <strong class="text--success"><?php echo app('translator')->get('Admin Benefit'); ?> : <?php echo e(showAmount($finalAmount)); ?>

                                        <?php echo e(__($general->cur_text)); ?></strong>
                                <?php else: ?>
                                    <strong class="text--danger"><?php echo app('translator')->get('Admin Loss'); ?> : <?php echo e(showAmount($finalAmount)); ?>

                                        <?php echo e(__($general->cur_text)); ?></strong>
                                <?php endif; ?>
                            </div>
                            <div class="adminGain"></div>
                            <div class="adminLoss"></div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Plan Update'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('admin.plan.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('admin.plan.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            function planPriceCommission() {
                $("#adminProfit").hide();
                var levelAmount = 0;
                var planAmount = $('#planAmount').val();
                var referralBonus = $('#referralBonus').val();

                $('.commissionAmount').each(function() {
                    if ($(this).val() != '') {
                        levelAmount += +$(this).val();
                    }
                })

                var totalAmount = Number(levelAmount) + Number(referralBonus);
                var currency = "<?php echo e(__($general->cur_text)); ?>";
                var finalAmount = planAmount - totalAmount;
                if (planAmount > totalAmount) {
                    $('.adminGain').html('<strong class="text--success"><?php echo app('translator')->get('Admin Benefit'); ?> : ' + parseFloat(finalAmount)
                        .toFixed(2) +
                        ' ' + currency + '</strong>');
                    $('.adminLoss').empty();
                } else {
                    $('.adminLoss').html('<strong class="text--danger"><?php echo app('translator')->get('Admin Loss'); ?> : ' + parseFloat(finalAmount)
                        .toFixed(2) +
                        ' ' + currency + '</strong>');
                    $('.adminGain').empty();
                }
            };

            $(document).on('keyup', '.commissionAmount, #planAmount, #referralBonus', function() {

                planPriceCommission();

            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/admin/plan/edit.blade.php ENDPATH**/ ?>