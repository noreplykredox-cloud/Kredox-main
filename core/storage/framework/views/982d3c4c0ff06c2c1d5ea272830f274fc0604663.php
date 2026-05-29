<?php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', false, null, true);
?>
<section class="feature-section padding-top padding-bottom primary-overlay bg_img bg_fixed"
         data-background="<?php echo e(getImage('assets/images/frontend/feature/'. @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="section-header cl-white">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="row justify-content-center">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-10 col-md-6 col-lg-4">
                    <div class="feature-item">
                        <div class="feature-thumb">
                            <?php echo $element->data_values->feature_icon ?>
                        </div>
                        <div class="feature-content">
                            <h5 class="title"><?php echo e(__($element->data_values->title)); ?></h5>
                            <p><?php echo e(__($element->data_values->sub_title)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\MLM-LAB\core\resources\views/templates/basic/sections/feature.blade.php ENDPATH**/ ?>