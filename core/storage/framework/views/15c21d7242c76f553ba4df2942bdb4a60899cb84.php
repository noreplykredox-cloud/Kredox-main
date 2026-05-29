<?php
    $content = getContent('how_to_work.content', true);
    $elements = getContent('how_to_work.element');
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
<section class="how-section padding-top padding-bottom oh">
    <div class="container">
        <div class="section-header">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="how-wrapper">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="how-item">
                    <div class="how-thumb">
                        <?php echo $element->data_values->work_icon ?>
                    </div>
                    <div class="how-content">
                        <h5 class="title"><?php echo e(__($element->data_values->title)); ?></h5>
                        <p><?php echo e(__($element->data_values->sub_title)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\MLM-LAB\core\resources\views/templates/basic/sections/how_to_work.blade.php ENDPATH**/ ?>