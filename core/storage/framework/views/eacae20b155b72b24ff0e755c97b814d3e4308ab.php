<?php
    $content = getContent('call.content', true);
?>
<section class="call-section padding-top padding-bottom bg_img bg_fixed primary-overlay"
         data-background="<?php echo e(getImage('assets/images/frontend/call/'. @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 xol-xl-8">
                <div class="section-header cl-white">
                    <h3 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h3>
                    <p><?php echo e(__(@$content->data_values->sub_heading)); ?></p>
                </div>
                <div class="text-center">
                    <a href="<?php echo e(url(@$content->data_values->button_url)); ?>" class="custom-button theme hover-cl-light"><?php echo e(__(@$content->data_values->button_name)); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/sections/call.blade.php ENDPATH**/ ?>