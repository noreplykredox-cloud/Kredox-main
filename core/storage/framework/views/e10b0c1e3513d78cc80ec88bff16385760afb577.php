<?php
    $content = getContent('faq.content', true);
    $elements = getContent('faq.element', false);
?>
<section class="faq-section padding-bottom padding-top-half">
    <div class="container">
        <div class="section-header">
            <h2 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h2>
            <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
        </div>
        <div class="row flex-wrap-reverse justify-content-center mb--50">
            <?php $__currentLoopData = $elements->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $elements): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6">
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="faq-wrapper mb-20">
                        <div class="faq-item">
                            <div class="faq-title">
                                <h6 class="title"><?php echo e(__($element->data_values->question)); ?></h6>
                                <span class="right-icon"></span>
                            </div>
                            <div class="faq-content">
                                <p>
                                    <?php echo e(__($element->data_values->answers)); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\trade\core\resources\views/templates/basic/sections/faq.blade.php ENDPATH**/ ?>