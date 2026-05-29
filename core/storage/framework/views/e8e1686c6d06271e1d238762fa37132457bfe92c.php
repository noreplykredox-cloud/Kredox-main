<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12">
        <form action="<?php echo e(route('admin.plan.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="planTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="settings-tab" data-bs-toggle="tab" href="#settings"
                                role="tab"><?php echo app('translator')->get('Plan Settings'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="levels-tab" data-bs-toggle="tab" href="#levels"
                                role="tab"><?php echo app('translator')->get('Level Commissions'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="daily-tab" data-bs-toggle="tab" href="#daily"
                                role="tab"><?php echo app('translator')->get('Daily Referral'); ?></a>
                        </li>
                    </ul>

                    <div class="tab-content" id="planTabsContent">
                        
                        <div class="tab-pane fade show active" id="settings" role="tabpanel">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Name'); ?></label>
                                    <input type="text" class="form-control form-control-lg" name="name"
                                        value="<?php echo e(old('name')); ?>" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Price'); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" name="price"
                                            value="<?php echo e(old('price')); ?>" id="planAmount" required step="any">
                                        <div class="input-group-text">
                                            <?php echo e(__($general->cur_text)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Referral Bonus'); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control form-control-lg" id="referralBonus"
                                            name="referral_bonus" value="<?php echo e(old('referral_bonus')); ?>" required
                                            step="any">
                                        <div class="input-group-text">
                                            <?php echo e(__($general->cur_text)); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Enable Daily Referral Payout'); ?></label>
                                    <select name="daily_referral_enabled" class="form-control">
                                        <option value="1" <?php echo e(old('daily_referral_enabled') == '1' ? 'selected' : ''); ?>>Yes</option>
                                        <option value="0" <?php echo e(old('daily_referral_enabled') != '1' ? 'selected' : ''); ?>>No</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                      <label><?php echo app('translator')->get('Enable Level Commission'); ?></label>
                                      <select name="daily_referral_enabled" class="form-control">
                                          <option value="1" <?php echo e(old('is_level_commission') == '1' ? 'selected' : ''); ?>>Yes</option>
                                          <option value="0" <?php echo e(old('is_level_commission') != '1' ? 'selected' : ''); ?>>No</option>
                                      </select>
                                  </div>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="levels" role="tabpanel">
                            <div class="row mt-4">
                                <?php for($i = 0; $i < $general->matrix_height; $i++): ?>
                                    <div class="form-group col-lg-3">
                                        <label><?php echo app('translator')->get('Level '); ?><?php echo e($i + 1); ?> <small>(0 allowed)</small></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg commissionAmount"
                                                name="level[<?php echo e($i + 1); ?>]" step="any" min="0" value="0" required>
                                            <div class="input-group-text">
                                                <?php echo e(__($general->cur_text)); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="daily" role="tabpanel">
                            <div class="row mt-4">
                                <?php for($i = 1; $i <= $general->matrix_height; $i++): ?>
                                    <div class="form-group col-lg-3">
                                        <label><?php echo app('translator')->get('Level '); ?><?php echo e($i); ?></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control form-control-lg payoutPercent"
                                                name="daily_referral_levels[<?php echo e($i); ?>]"
                                                value="<?php echo e(old("daily_referral_levels.$i", 0)); ?>"
                                                step="any" min="0">
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="adminGain"></div>
                        <div class="adminLoss"></div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Create Plan'); ?></button>
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
            let levelAmount = 0;
            const planAmount = parseFloat($('#planAmount').val()) || 0;
            const referralBonus = parseFloat($('#referralBonus').val()) || 0;

            $('.commissionAmount').each(function() {
                const val = parseFloat($(this).val()) || 0;
                levelAmount += val;
            });

            const totalAmount = levelAmount + referralBonus;
            const currency = "<?php echo e(__($general->cur_text)); ?>";
            const finalAmount = planAmount - totalAmount;

            if (planAmount > totalAmount) {
                $('.adminGain').html('<strong class="text--success"><?php echo app('translator')->get('Admin Benefit'); ?> : ' + finalAmount.toFixed(2) + ' ' + currency + '</strong>');
                $('.adminLoss').empty();
            } else {
                $('.adminLoss').html('<strong class="text--danger"><?php echo app('translator')->get('Admin Loss'); ?> : ' + finalAmount.toFixed(2) + ' ' + currency + '</strong>');
                $('.adminGain').empty();
            }
        }

        $(document).on('keyup change', '.commissionAmount, #planAmount, #referralBonus', function() {
            planPriceCommission();
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/admin/plan/create.blade.php ENDPATH**/ ?>