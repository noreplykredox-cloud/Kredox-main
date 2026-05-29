
<?php $__env->startSection('content'); ?>
<?php
$content = getContent('banner.content', true);
?>







        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/" class="nav__link">
    <i class="material-icons nav__icon">home</i>
    <span class="nav__text">Home</span>
  </a>
  <a href="https://yukotrader.com/about" class="nav__link nav__link">
    <i class="material-icons nav__icon">settings_accessibility</i>
    <span class="nav__text">About-Us</span>
  </a>
  <a href="https://yukotrader.com/how-it-works" class="nav__link">
    <i class="material-icons nav__icon">receipt_long</i>
    <span class="nav__text">how it works</span>
  </a>
  <a href="https://yukotrader.com/contact" class="nav__link">
    <i class="material-icons nav__icon">connect_without_contact</i>
    <span class="nav__text">Contact</span>
  </a>
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">input</i>
    <span class="nav__text">Login/Signup</span>
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

<section class="banner-section oh bg_img primary-overlay" data-background="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->background_image, '1200x798')); ?>">
    <section>
        <div class="video-background">
        <div class="video-foreground">
        <video autoplay muted loop id="myVideo">
        <source src="https://yukotrader.com/video.mp4" type="video/mp4">
        </video>
        </div>
        </div>
        </section>
<style>
    #myVideo {
  position: absolute;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
  opacity: 5.70;
  filter: blur(2px);
}
</style>
    <div class="banner-thumb d-none d-lg-block">
        
        <img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->main_image, '705x525')); ?>" alt="<?php echo app('translator')->get('banner'); ?>">
        <div>
            <div class="sub-thumb"><img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->image_1, '75x160')); ?>" alt="<?php echo app('translator')->get('banner'); ?>"></div>
            <div class="sub-thumb"><img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->image_2, '45x90')); ?>" alt="<?php echo app('translator')->get('banner'); ?>"></div>
            <div class="sub-thumb"><img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->image_3, '75x100')); ?>" alt="<?php echo app('translator')->get('banner'); ?>"></div>
            <div class="sub-thumb"><img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->image_4, '75x100')); ?>" alt="<?php echo app('translator')->get('banner'); ?>"></div>
            <div class="sub-thumb"><img src="<?php echo e(getImage('assets/images/frontend/banner/'. @$content->data_values->image_5, '120x165')); ?>" alt="<?php echo app('translator')->get('banner'); ?>"></div>
            
        </div>
    </div>

    <div class="container">
        
        
        <div class="banner-content">
            
            <h1 class="title"><?php echo e(__(@$content->data_values->first_heading)); ?><span class="d-block text-theme"><?php echo e(__(@$content->data_values->second_heading)); ?></span></h1>
            <h3 class="subtitle"><?php echo e(__(@$content->data_values->sub_heading)); ?></h3>
            <p><?php echo e(__(@$content->data_values->description)); ?></p>
            <div class="button-area">
                <a href="<?php echo e(url(@$content->data_values->first_button_url)); ?>" class="custom-button cl-light"><?php echo e(__(@$content->data_values->first_button_text)); ?></a>
                <a href="<?php echo e(url(@$content->data_values->second_button_url)); ?>" class="custom-button theme hover-cl-light"><?php echo e(__(@$content->data_values->second_button_text)); ?></a>
            </div>
        </div>
    </div>
</section>

<?php if($sections->secs != null): ?>
    <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make($activeTemplate.'sections.'.$sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/home.blade.php ENDPATH**/ ?>