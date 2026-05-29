<?php
    $content = getContent('counter.content', true);
    $elements = getContent('counter.element', false, null, true);
?>
<section class="counter-section padding-bottom padding-top primary-overlay bg_fixed bg_img"
         data-background="<?php echo e(getImage('assets/images/frontend/counter/'. @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="row justify-content-center mb-40-none">

        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-3 col-sm-6">
                <div class="counter-item">
                    <div class="counter-thumb">
                        <?php echo $element->data_values->counter_icon ?>
                    </div>
                    <div class="counter-content">
                        <h5 class="title"><?php echo e(__($element->data_values->title)); ?></h5>
                        <div class="counter-header">
                            <h5 class="subtitle"><?php echo e(__($element->data_values->counter_digit)); ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/sections/counter.blade.php ENDPATH**/ ?>