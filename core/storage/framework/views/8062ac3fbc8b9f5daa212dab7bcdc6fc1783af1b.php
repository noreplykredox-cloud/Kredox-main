<?php $__env->startSection('content'); ?>
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper primary-bg">
                            <div class="verification-area">
                                <h5 class="pb-3 mb-3 text-center border-bottom base--color"><?php echo app('translator')->get('Verify Email Address'); ?></h5>
                                <form action="<?php echo e(route('user.password.verify.code')); ?>" method="POST" class="submit-form">
                                    <?php echo csrf_field(); ?>
                                    <p class="verification-text text-white"><?php echo app('translator')->get('A 6 digit verification code sent to your email address'); ?> : <?php echo e(showEmailAddress($email)); ?></p>
                                    <input type="hidden" name="email" value="<?php echo e($email); ?>">

                                    <?php echo $__env->make($activeTemplate . 'partials.verification_code', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Submit'); ?></button>
                                    </div>

                                    <div class="form-group text-white">
                                        <?php echo app('translator')->get('Please check including your Junk/Spam Folder. if not found, you can'); ?>
                                        <a href="<?php echo e(route('user.password.request')); ?>"><?php echo app('translator')->get('Try to send again'); ?></a>
                                    </div>

                                </form>
                            </div>
                        </div>
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

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/auth/passwords/code_verify.blade.php ENDPATH**/ ?>