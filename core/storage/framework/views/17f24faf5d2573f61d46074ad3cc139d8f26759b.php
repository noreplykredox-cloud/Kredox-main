<?php $__env->startSection('content'); ?>
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper primary-bg">
                    <div class="verification-area">
                        <h5 class="mb-3 pb-3 text-center border-bottom base--color"><?php echo app('translator')->get('Verify Email Address'); ?></h5>
                        <form action="<?php echo e(route('user.verify.email')); ?>" method="POST" class="submit-form">
                            <?php echo csrf_field(); ?>
                            <p class="verification-text text-white"><?php echo app('translator')->get('A 6 digit verification code sent to your email address'); ?>: <?php echo e(showEmailAddress(auth()->user()->email)); ?></p>

                            <?php echo $__env->make($activeTemplate . 'partials.verification_code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <div class="mb-3">
                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>

                            <div class="mb-3 text-white">
                                <p>
                                    <?php echo app('translator')->get('If you don\'t get any code'); ?>, <a href="<?php echo e(route('user.send.verify.code', 'email')); ?>">
                                        <?php echo app('translator')->get('Try again'); ?></a>
                                </p>

                                <?php if($errors->has('resend')): ?>
                                    <small class="text--danger d-block"><?php echo e($errors->first('resend')); ?></small>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .submit-form .mb-3 label {
        color: #ffffff;
        margin-bottom: 13px;
}
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/auth/authorization/email.blade.php ENDPATH**/ ?>