<?php
    $content = getContent('breadcrumb.content', true);
?>
<section class="hero-section primary-overlay oh bg_img"
    data-background="<?php echo e(getImage('assets/images/frontend/breadcrumb/' . @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="hero-content">
            <h1 class="title"><?php echo e($pageTitle); ?></h1>
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                </li>
                <li>
                    <?php echo e($pageTitle); ?>

                </li>
            </ul>
        </div>
    </div>
</section>
<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/partials/breadcrumb.blade.php ENDPATH**/ ?>