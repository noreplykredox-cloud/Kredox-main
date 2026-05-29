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
     
    <div class="container padding-top padding-bottom">
        <section>
        <div class="video-background">
        <div class="video-foreground">
        <video autoplay muted loop id="myVideo">
        <source src="https://yukotrader.com/video1001.mp4" type="video/mp4">
        </video>
        </div>
        </div>
        </section>
<style>
    #myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
  opacity: 5.70;
  filter: blur(5px);
}
</style>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card primary-bg">
                    <div class="card-header card-header-bg">
                        <h5 class="card-title"><?php echo e(__($pageTitle)); ?></h5>
                    </div>
                    <div class="card-body  ">
                        <form action="<?php echo e(route('user.deposit.manual.update')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p class="text-center mt-2"><?php echo app('translator')->get('You have requested'); ?> <b
                                            class="text--success"><?php echo e(showAmount($data['amount'])); ?>

                                            <?php echo e(__($general->cur_text)); ?></b> , <?php echo app('translator')->get('Please pay'); ?>
                                        <b class="text--success"><?php echo e(showAmount($data['final_amo']) . ' ' . $data['method_currency']); ?>

                                        </b> <?php echo app('translator')->get('for successful payment'); ?>
                                    </p>
                                    <h4 class="text-center mb-4 text-white"><?php echo app('translator')->get('Please follow the instruction below'); ?></h4>

                                    <p class="my-4 text-center"><?php echo  $data->gateway->description ?></p>

                                </div>

                                <?php if (isset($component)) { $__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0 = $component; } ?>
<?php $component = App\View\Components\ViserForm::resolve(['identifier' => 'id','identifierValue' => ''.e($gateway->form_id).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('viser-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ViserForm::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0)): ?>
<?php $component = $__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0; ?>
<?php unset($__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0); ?>
<?php endif; ?>

                                <div class="col-md-12">
                                    <div class="contact-form-group">
                                        <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Pay Now'); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/payment/manual.blade.php ENDPATH**/ ?>