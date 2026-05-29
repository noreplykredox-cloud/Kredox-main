<?php
    $content = getContent('footer.content', true);
    $footerMenu = getContent('policy_pages.element', false);
    $socialIcons = getContent('social_icon.element', false, false, true);
?>

<footer class="padding-top primary-overlay bg_img"
    data-background="<?php echo e(getImage('assets/images/frontend/footer/' . @$content->data_values->background_image, '1000x421')); ?>">
    <div class="footer-top padding-bottom">
        <div class="container">
            <div class="footer-wrapper cl-white">
                <div class="footer-logo">
                    <a href="">
                        <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="images">
                    </a>
                </div>
                <p><?php echo e(__(@$content->data_values->heading)); ?></p>
                <ul class="social__icons">
                    <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(@$element->data_values->url); ?>" target="_blank"
                                class="facebook"><?php echo $element->data_values->icon ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <ul class="footer-menu">
                <?php $__currentLoopData = $footerMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>"><?php echo e(__($policy->data_values->title)); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo app('translator')->get('All Right Reserved By'); ?> <a href="<?php echo e(route('home')); ?>"><?php echo e(__($general->site_name)); ?></a></p>
        </div>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\trade\core\resources\views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>