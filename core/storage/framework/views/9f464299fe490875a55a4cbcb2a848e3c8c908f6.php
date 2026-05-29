<?php
    $content = getContent('testimonial.content', true);
    $elements = getContent('testimonial.element');
?>
<section class="client-section primary-overlay bg_img bg_fixed padding-bottom padding-top"
    data-background="<?php echo e(getImage('assets/images/frontend/testimonial/' . @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="client-slider owl-theme owl-carousel">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="client-item mt-55">
                    <div class="client-thumb">
                        <img src="<?php echo e(getImage('assets/images/frontend/testimonial/' . $element->data_values->image, '200x200')); ?>"
                            alt="client">
                    </div>
                    <div class="client-content">
                        <div class="header">
                            <h5 class="title"><?php echo e(__($element->data_values->name)); ?></h5>
                            <span class="info"><?php echo e(__($element->data_values->designation)); ?></span>
                        </div>
                        <p><?php echo e(__($element->data_values->description)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/sections/testimonial.blade.php ENDPATH**/ ?>