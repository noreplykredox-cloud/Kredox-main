<?php
    $content = getContent('plan.content', true);
    $plans = App\Models\Plan::where('status', Status::ENABLE)
        ->orderBy('id', 'ASC')
        ->limit(3)
        ->get();
?>
<section class="plan-section padding-top padding-bottom oh">
    <div class="container">
        <div class="section-header">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="row justify-content-center">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="plan-item">
                        <div class="plan-header">
                            <span class="plan-badge">
                                <?php echo e(__($plan->name)); ?>

                            </span>
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <h3 class="title"><?php echo e(__($general->cur_sym)); ?><?php echo e(getAmount($plan->price)); ?></h3>
                        </div>
                        <ul class="plan-info">
                            <li>
                                <h6 class="direct"><?php echo app('translator')->get('Direct Referral Bonus'); ?> :
                                    <?php echo e($general->cur_sym); ?><?php echo e(getAmount($plan->referral_bonus)); ?></h6>
                            </li>

                            <?php
                                $sumCommission = 0;
                            ?>

                            <?php $__currentLoopData = $plan->totalLevel($plan->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $matrixCal = pow($general->matrix_width, $loop->iteration);
                                    $commission = getAmount($value->amount * $matrixCal);
                                    $sumCommission += $commission;
                                ?>
                                <!--

                                <li>
                                    <?php echo app('translator')->get('L'); ?><?php echo e($loop->iteration); ?> :
                                    <?php echo e($general->cur_sym); ?><?php echo e(getAmount($value->amount)); ?> X <?php echo e($matrixCal); ?> <i
                                        class="fa fa-users"></i> = <strong
                                        class="profit"><?php echo e(__($general->cur_sym)); ?><?php echo e($commission); ?></strong>
                                </li>
                                -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                         <!--
                        <div class="total-return">
                            <h6 class="title"><?php echo app('translator')->get('Total Level Commission'); ?> : <?php echo e(showAmount($sumCommission)); ?>

                                <?php echo e(__($general->cur_text)); ?></h6>
                            <span class="return-remainders">
                                <?php echo app('translator')->get('Returns'); ?> <span
                                    class="remainder"><?php echo e(getAmount(($sumCommission / $plan->price) * 100)); ?>%</span>
                                <?php echo app('translator')->get('of Invest'); ?>
                            </span>
                        </div>
                        -->

                        <div class="invest-now py-3">
                            <button type="button" class="btn btn--base btn-lg confirmationBtn"
                                data-question="<?php echo app('translator')->get('Are you sure you want to subscribe this plan'); ?>"
                                data-action="<?php echo e(route('user.plan.order',$plan->id)); ?>"><?php echo app('translator')->get('Invest Now'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $component->withAttributes(['is_custom' => 'yes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>

</section>
<?php /**PATH C:\xampp\htdocs\MLM-LAB\core\resources\views/templates/basic/sections/plan.blade.php ENDPATH**/ ?>