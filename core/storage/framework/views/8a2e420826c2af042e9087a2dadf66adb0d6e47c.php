<?php $__env->startSection('content'); ?>
    <div class="dashboard-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-8">
                    <div class="contact-wrapper">
                        <form action="<?php echo e(route('user.balance.transfer.anotheruser')); ?>" method="POST"
                            class="contact-form row mb--25 align-items-center">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-12">
                                <div class="contact-form-group">
                                    <label><?php echo app('translator')->get('Username'); ?></label>
                                    <input type="text" placeholder="<?php echo app('translator')->get('Enter Username'); ?>" value="<?php echo e(old('username')); ?>"
                                        required name="username">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="contact-form-group">
                                    <label><?php echo app('translator')->get('Amount'); ?> <span class="text--success">(<?php echo app('translator')->get('Charge:'); ?>
                                            <?php echo e(showAmount($general->balance_transfer_fixed_charge)); ?>

                                            <?php echo e(__($general->cur_text)); ?> <?php echo app('translator')->get('+'); ?>
                                            <?php echo e($general->balance_transfer_percent_charge); ?> %)</span> </label>
                                    <input type="number" placeholder="<?php echo app('translator')->get('Enter Amount'); ?>" onkeyup="subtracted()"
                                        id="amount" value="<?php echo e(old('amount')); ?>" required name="amount">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="contact-form-group">
                                    <label><?php echo app('translator')->get('Amount Will Cut From Your Account'); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="calculation form-control"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                                        <div class="input-group-text">
                                            <?php echo e(__($general->cur_text)); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="contact-form-group">
                                    <button type="submit" class="mt-3 w-100"><?php echo app('translator')->get('Transfer Balance'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        function subtracted() {
            const userBalance = <?php echo e(auth()->user()->balance); ?>;
            var amount = Number($('input[name="amount"]').val());
            var charge = ((amount / 100) * <?php echo e($general->balance_transfer_percent_charge); ?>) +
                <?php echo e($general->balance_transfer_fixed_charge); ?>;
            var calculation = parseFloat(amount) + parseFloat(charge);
            if (userBalance < amount) {
                notify('warning',
                    "<?php echo app('translator')->get('Your Account Balance'); ?> <?php echo e(getAmount(auth()->user()->balance)); ?> <?php echo e(__($general->cur_text)); ?> <?php echo app('translator')->get('Not Enough! For Balance Transfer'); ?>"
                );
            } else if (isNaN(amount) || amount <= 0) {
                notify('warning', 'Please Enter Valid Amount')
            } else {
                $('.calculation').val(calculation);
            }
        };
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/balance_transfer.blade.php ENDPATH**/ ?>