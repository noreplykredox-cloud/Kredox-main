<?php $__env->startSection('content'); ?>
    <!-- <Message> Section -->
    <div class="message__chatbox-section padding-top padding-bottom">
        <div class="container">
            <div class="message__chatbox ">
                <div class="message__chatbox__header">
                    <h5 class="title text-white"><?php echo e(__($pageTitle)); ?></h5>
                    <a href="<?php echo e(route('ticket.index')); ?>" class="custom-button theme btn-sm"><?php echo app('translator')->get('Support Ticket'); ?></a>
                </div>
                <div class="message__chatbox__body">
                    <form action="<?php echo e(route('ticket.store')); ?>" method="post" enctype="multipart/form-data"
                        onsubmit="return submitUserForm();" class="message__chatbox__form row g-4">
                        <?php echo csrf_field(); ?>
                        <div class="contact-form-group col-sm-6">
                            <label class="form--label"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" name="name" id="fname"
                                value="<?php echo e(@$user->firstname . ' ' . @$user->lastname); ?>" readonly>
                        </div>
                        <div class="contact-form-group col-sm-6">
                            <label class="form--label"><?php echo app('translator')->get('Email Address'); ?></label>
                            <input type="text" name="email" id="email" value="<?php echo e(@$user->email); ?>" readonly>
                        </div>
                        <div class="contact-form-group col-sm-6">
                            <label class="form--label"><?php echo app('translator')->get('Subject'); ?></label>
                            <input type="text" id="subject" placeholder="<?php echo app('translator')->get('Enter Subject'); ?>" name="subject"
                                value="<?php echo e(old('subject')); ?>" required="">
                        </div>


                        <div class="contact-form-group col-sm-6">
                            <label><?php echo app('translator')->get('Priority'); ?></label>
                            <div class="select-item">
                                <select name="priority" id="priority" class="select-bar">
                                    <option value="3"><?php echo app('translator')->get('High'); ?></option>
                                    <option value="2"><?php echo app('translator')->get('Medium'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('Low'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="contact-form-group col-sm-12">
                            <label class="form--label"><?php echo app('translator')->get('Message'); ?></label>
                            <textarea id="message" placeholder="<?php echo app('translator')->get('Enter Message'); ?>" name="message" required=""><?php echo e(old('message')); ?></textarea>
                        </div>

                        <div class="contact-form-group col-sm-12">
                            <div class="d-block">
                                <label><?php echo app('translator')->get('Attachments'); ?></label>
                                <small class="text--danger"><?php echo app('translator')->get('Max 5 files can be uploaded'); ?>. <?php echo app('translator')->get('Maximum upload size is'); ?>
                                    <?php echo e(ini_get('upload_max_filesize')); ?></small>
                                <div class="input-group w-100">
                                    <input type="file" class="form-control form--control" name="attachments[]"
                                        id="file2">
                                    <button class="cmn--btn btn--sm bg--primary cmn--form--control addFile"
                                        type="button"><i class="fas fa-plus"></i></button>
                                </div>

                            </div>
                            <div id="fileUploadsContainer"></div>
                            <span class="info text-white fs--14"><?php echo app('translator')->get('Allowed File Extensions'); ?>: .<?php echo app('translator')->get('jpg'); ?>,
                                .<?php echo app('translator')->get('jpeg'); ?>, .<?php echo app('translator')->get('png'); ?>, .<?php echo app('translator')->get('pdf'); ?>, .<?php echo app('translator')->get('doc'); ?>,
                                .<?php echo app('translator')->get('docx'); ?></span>
                        </div>
                        <div class="contact-form-group col-sm-12 mb-0">
                            <button type="submit" class="cmn--btn"><?php echo app('translator')->get('Send Message'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(
                    `<div class="removeFile mt-3">
                            <div class="input-group col p-0">
                                <input type="file" class="form-control form--control" name="attachments[]" id="file2" required>
                                <button class="btn--sm bg--danger ml-md-4 cmn--form--control remove-btn" type="button"><i class="fas fa-times-circle"></i></button>
                            </div>

                        </div>`
                )
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/support/create.blade.php ENDPATH**/ ?>