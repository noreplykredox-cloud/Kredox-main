<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12">
        
        <form action="<?php echo e(route('admin.plan.update', $plan->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-body">
                    
                    <ul class="nav nav-tabs mb-4" id="planTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic"
                                type="button" role="tab"><?php echo app('translator')->get('Plan Settings'); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="commission-tab" data-bs-toggle="tab" data-bs-target="#commission"
                                type="button" role="tab"><?php echo app('translator')->get('Commission Levels'); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily"
                                type="button" role="tab"><?php echo app('translator')->get('Daily Referral Levels'); ?></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual"
                                type="button" role="tab"><?php echo app('translator')->get('Manual Payments'); ?></button>
                        </li>
                    </ul>

                    <div class="tab-content" id="planTabContent">
                        
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Name'); ?></label>
                                    <input type="text" class="form-control" name="name" value="<?php echo e($plan->name); ?>" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Price'); ?></label>
                                    <input type="number" class="form-control" name="price" value="<?php echo e(getAmount($plan->price)); ?>" id="planAmount" step="any" required>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label><?php echo app('translator')->get('Referral Bonus'); ?></label>
                                    <input type="number" class="form-control" name="referral_bonus" id="referralBonus" value="<?php echo e(getAmount($plan->referral_bonus)); ?>" step="any" required>
                                </div>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="commission" role="tabpanel">
                            <div class="form-group col-lg-4">
                                <label><?php echo app('translator')->get('Active Level Commission'); ?></label>
                                <select class="form-control" name="is_level_commission">
                                    <option value="1" <?php echo e($plan->is_level_commission ? 'selected' : ''); ?>>Yes</option>
                                    <option value="0" <?php echo e(!$plan->is_level_commission ? 'selected' : ''); ?>>No</option>
                                </select>
                            </div>
                            <div class="row">
                                <?php for($i = 0; $i < $general->matrix_height; $i++): ?>
                                    <div class="form-group col-lg-3">
                                        <label><?php echo app('translator')->get('Level '); ?><?php echo e($i + 1); ?></label>
                                        <input type="number" class="form-control commissionAmount" name="level[<?php echo e($i + 1); ?>]" value="<?php echo e(getAmount(@$plan->level[$i]->amount)); ?>" step="any" required>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="daily" role="tabpanel">
                            <div class="form-group col-lg-4">
                                <label><?php echo app('translator')->get('Daily Referral Payout Active'); ?></label>
                                <select class="form-control" name="daily_referral_enabled">
                                    <option value="1" <?php echo e($plan->daily_referral_enabled ? 'selected' : ''); ?>>Yes</option>
                                    <option value="0" <?php echo e(!$plan->daily_referral_enabled ? 'selected' : ''); ?>>No</option>
                                </select>
                            </div>
                            <div class="row">
                                <?php for($i = 1; $i <= $general->matrix_height; $i++): ?>
                                    <div class="form-group col-lg-3">
                                        <label><?php echo app('translator')->get('Level '); ?><?php echo e($i); ?></label>
                                        <input type="number" class="form-control payoutPercent" name="level_payout[<?php echo e($i); ?>]" value="<?php echo e(@$plan->dailyReferralLevels->where('level', $i)->first()?->percentage ?? 0); ?>" step="any">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="manual" role="tabpanel">
                            <div class="row">
                                <?php $__currentLoopData = $manualPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3 border p-3">
                                        <input type="hidden" name="manual_payments[<?php echo e($index); ?>][id]" value="<?php echo e($payment->id); ?>">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" name="manual_payments[<?php echo e($index); ?>][amount]" value="<?php echo e($payment->amount); ?>" class="form-control" step="0.01" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="manual_payments[<?php echo e($index); ?>][description]" value="<?php echo e($payment->description); ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="datetime-local" name="manual_payments[<?php echo e($index); ?>][start_time]" value="<?php echo e(\Carbon\Carbon::parse($payment->start_time)->format('Y-m-d\\TH:i')); ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Frequency</label>
                                            <select name="manual_payments[<?php echo e($index); ?>][frequency]" class="form-control frequencySelect">
                                                <option value="daily" <?php echo e($payment->frequency == 'daily' ? 'selected' : ''); ?>>Daily</option>
                                                <option value="monthly" <?php echo e($payment->frequency == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                                            </select>
                                        </div>
                                        <div class="form-group monthly-day-wrapper <?php echo e($payment->frequency == 'monthly' ? '' : 'd-none'); ?>">
                                            <label>Day of Month</label>
                                            <select name="manual_payments[<?php echo e($index); ?>][monthly_day]" class="form-control">
                                                <?php for($i=1;$i<=30;$i++): ?>
                                                    <option value="<?php echo e($i); ?>" <?php echo e($payment->monthly_day == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        
                                        <form method="POST" action="<?php echo e(route('admin.plan.manual.payment.delete', $payment->id)); ?>" onsubmit="return confirm('Are you sure you want to delete this manual payment?')" class="mt-2">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                                <i class="las la-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                <div class="col-md-6 mb-3 border p-3">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" name="manual_payments[new_1][amount]" class="form-control" step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="manual_payments[new_1][description]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Start Time</label>
                                        <input type="datetime-local" name="manual_payments[new_1][start_time]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Frequency</label>
                                        <select name="manual_payments[new_1][frequency]" class="form-control frequencySelect">
                                            <option value="daily">Daily</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                    <div class="form-group monthly-day-wrapper d-none">
                                        <label>Day of Month</label>
                                        <select name="manual_payments[new_1][monthly_day]" class="form-control">
                                            <?php for($i=1;$i<=30;$i++): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100"><?php echo app('translator')->get('Plan Update'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    $(document).on('change', '.frequencySelect', function () {
        const wrapper = $(this).closest('div').siblings('.monthly-day-wrapper');
        if ($(this).val() === 'monthly') {
            wrapper.removeClass('d-none');
        } else {
            wrapper.addClass('d-none');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/admin/plan/edit.blade.php ENDPATH**/ ?>