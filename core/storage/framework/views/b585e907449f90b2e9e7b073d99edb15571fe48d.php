<?php
    $content = getContent('subscribe.content', true);
?>
<section class="newsletter-section padding-top padding-bottom bg_img bg_fixed primary-overlay"
    data-background="<?php echo e(getImage('assets/images/frontend/subscribe/' . @$content->data_values->background_image, '1000x667')); ?>">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9 col-xl-8">
                <div class="section-header margin-olpo cl-white">
                    <h3 class="title"><?php echo e(__(@$content->data_values->heading)); ?></h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <form class="subscribe-form" method="POST">
                            <div class="subscribe-group">
                                <input type="email"  required id="emailSub" placeholder="<?php echo app('translator')->get('Your Email Address'); ?>">
                                <button type="submit" class="subscribe-btn"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startPush('script'); ?>
    <script>
        'use strict';
        $(document).on('submit', '.subscribe-form', function(e) {
            e.preventDefault();
            var email = $("#emailSub").val();
            if (email) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                    },
                    url: "<?php echo e(route('subscribe')); ?>",
                    method: "POST",
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            notify('success', response.success);
                            $("#emailSub").val('');
                        } else {
                            $.each(response, function(i, val) {
                                notify('error', val);
                            });
                        }
                    }
                });
            } else {
                notify('error', "Please Input Your Email");
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\trade\core\resources\views/templates/basic/sections/subscribe.blade.php ENDPATH**/ ?>