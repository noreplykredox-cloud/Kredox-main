<?php $__env->startSection('content'); ?>
<div class="container padding-bottom padding-top">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card custom--card primary-bg">
                <div class="card-body">
                    <h3 class="text-center text--danger mb-3"><?php echo app('translator')->get('You are banned'); ?></h3>
                    <p class="fw-bold mb-1"><?php echo app('translator')->get('Reason'); ?>:</p>
                    <p><?php echo e($user->ban_reason); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate .'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/auth/authorization/ban.blade.php ENDPATH**/ ?>