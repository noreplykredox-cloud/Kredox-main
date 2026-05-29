
<?php $__env->startSection('content'); ?>
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="https://yukotrader.com/subscribe/plan" class="nav__link nav__link">
    <i class="material-icons nav__icon">travel_explore</i>
    <span class="nav__text">Plan</span>
  </a>
  <a href="https://yukotrader.com/user/deposit" class="nav__link">
    <i class="material-icons nav__icon">add_card</i>
    <span class="nav__text">Deposit</span>
  </a>
  <a href="https://yukotrader.com/user/withdraw" class="nav__link">
    <i class="material-icons nav__icon">request_quote</i>
    <span class="nav__text">Withdraw</span>
  </a>
  <a href="https://yukotrader.com/user/referral/users" class="nav__link">
    <i class="material-icons nav__icon">diversity_3</i>
    <span class="nav__text">My Team</span>
  </a>
   <a href="https://yukotrader.com/user/logout" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
  </a>
  
  
</nav>

        
  <style>
  body {
    margin: 0 0 55px 0;
}

.nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 55px;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    background: -webkit-linear-gradient(-90deg, #124656 0%, #063a4a 45%, #063b46 100%);
    display: flex;
    overflow-x: auto;
    z-index:2;
}

.nav__link {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-grow: 1;
    min-width: 50px;
    overflow: hidden;
    white-space: nowrap;
    font-family: sans-serif;
    font-size: 13px;
    color: #e1d4d4;
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
    transition: background-color 0.1s ease-in-out;
}

.nav__link:hover {
    background-color: #eeeeee;
}

.nav__link--active {
    color: #009578;
}

.nav__icon {
    font-size: 21px;
}
@media screen and (min-width: 600px) {
  .nav {
  display: none;
  }
}

  </style>
     
    <section class="plan-section padding-top padding-bottom oh">
        <div class="container">
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
                                <h3 class="title"><?php echo e($general->cur_sym); ?><?php echo e(getAmount($plan->price)); ?></h3>
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
                                        <?php echo e(__($general->cur_sym)); ?><?php echo e(getAmount($value->amount)); ?> X <?php echo e($matrixCal); ?> <i
                                            class="fa fa-users"></i> = <strong
                                            class="profit"><?php echo e(__($general->cur_sym)); ?><?php echo e($commission); ?></strong>
                                    </li>
                                    -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <!--
                            <div class="total-return">
                                <h6 class="title"><?php echo app('translator')->get('Total Level Commission'); ?> : <?php echo e(getAmount($sumCommission)); ?>

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
    </section>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/templates/basic/plan.blade.php ENDPATH**/ ?>