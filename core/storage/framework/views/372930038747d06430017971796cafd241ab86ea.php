<?php $__env->startSection('content'); ?>
    <div class="padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card custom--card primary-bg profile-wrapper">
                        <div class="card-body">
                            <form class="register" action="" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="contact-form-group col-sm-6 contact-form-group">
                                        <label class="form-label"><?php echo app('translator')->get('First Name'); ?></label>
                                        <input type="text"  name="firstname"
                                            value="<?php echo e($user->firstname); ?>" required>
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label"><?php echo app('translator')->get('Last Name'); ?></label>
                                        <input type="text"  name="lastname"
                                            value="<?php echo e($user->lastname); ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label"><?php echo app('translator')->get('E-mail Address'); ?></label>
                                        <input  value="<?php echo e($user->email); ?>" readonly>
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label"><?php echo app('translator')->get('Mobile Number'); ?></label>
                                        <input  value="<?php echo e($user->mobile); ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label"><?php echo app('translator')->get('Address'); ?></label>
                                        <input type="text"  name="address"
                                            value="<?php echo e(@$user->address->address); ?>">
                                    </div>
                                    <div class="contact-form-group contact-form-group col-sm-6">
                                        <label class="form-label"><?php echo app('translator')->get('State'); ?></label>
                                        <input type="text"  name="state"
                                            value="<?php echo e(@$user->address->state); ?>">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="contact-form-group col-sm-4 contact-form-group">
                                        <label class="form-label"><?php echo app('translator')->get('Zip Code'); ?></label>
                                        <input type="text"  name="zip"
                                            value="<?php echo e(@$user->address->zip); ?>">
                                    </div>

                                    <div class="contact-form-group contact-form-group col-sm-4">
                                        <label class="form-label"><?php echo app('translator')->get('City'); ?></label>
                                        <input type="text"  name="city"
                                            value="<?php echo e(@$user->address->city); ?>">
                                    </div>

                                    <div class="contact-form-group contact-form-group col-sm-4">
                                        <label class="form-label"><?php echo app('translator')->get('Country'); ?></label>
                                        <input  value="<?php echo e(@$user->address->country); ?>"
                                            disabled>
                                    </div>

                                </div>

                                <div class="contact-form-group contact-form-group">
                                    <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Submit'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/profile_setting.blade.php ENDPATH**/ ?>