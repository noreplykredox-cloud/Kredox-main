<?php $__env->startSection('content'); ?>
    <div class="message__chatbox-section padding-top-half padding-bottom">
        <div class="container">
            <div class="message__chatbox ">
                <div class="message__chatbox__header">
                    <h5 class="title text-white">
                        <?php if($myTicket->status == 0): ?>
                            <span class="badge badge--success"><?php echo app('translator')->get('Open'); ?></span>
                        <?php elseif($myTicket->status == 1): ?>
                            <span class="badge badge--primary"><?php echo app('translator')->get('Answered'); ?></span>
                        <?php elseif($myTicket->status == 2): ?>
                            <span class="badge badge--warning"><?php echo app('translator')->get('Replied'); ?></span>
                        <?php elseif($myTicket->status == 3): ?>
                            <span class="badge badge--dark"><?php echo app('translator')->get('Closed'); ?></span>
                        <?php endif; ?>
                        <?php echo app('translator')->get('Ticket ID'); ?>:<span class="cl-theme">[#<?php echo e($myTicket->ticket); ?>] <?php echo e($myTicket->subject); ?></span>
                    </h5>
                    <?php if($myTicket->status != Status::TICKET_CLOSE && $myTicket->user): ?>
                        <a href="javascript:void(0)" class="btn btn--sm d-block btn--danger text-center confirmationBtn" data-action="<?php echo e(route('ticket.close', $myTicket->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure you want to close this support ticket?'); ?>"><?php echo app('translator')->get('Close Ticket'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="message__chatbox__body">
                    <?php if($myTicket->status != 4): ?>
                        <form method="post" action="<?php echo e(route('ticket.reply', $myTicket->id)); ?>"
                            class="message__chatbox__form row" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="contact-form-group col-sm-12">
                                <label><?php echo app('translator')->get('Your Message'); ?></label>
                                <textarea id="message" name="message" placeholder="<?php echo app('translator')->get('Enter Message'); ?>" required=""></textarea>
                            </div>

                            <div class="contact-form-group col-sm-12">
                                <div class="d-block">
                                    <label><?php echo app('translator')->get('Attachments'); ?></label>
                                    <small class="text--danger"><?php echo app('translator')->get('Max 5 files can be uploaded'); ?>. <?php echo app('translator')->get('Maximum upload size is'); ?>
                                        <?php echo e(ini_get('upload_max_filesize')); ?></small>
                                    <div class="input-group w-100">
                                        <input type="file" class="form-control form--control" name="attachments[]"
                                            id="file2">
                                        <button class="btn--base btn--sm bg--primary cmn--form--control addFile"
                                            type="button"><i class="fas fa-plus"></i></button>
                                    </div>

                                </div>
                                <div id="fileUploadsContainer"></div>
                                <span class="info text-white fs--14"><?php echo app('translator')->get('Allowed File Extensions'); ?>: .<?php echo app('translator')->get('jpg'); ?>,
                                    .<?php echo app('translator')->get('jpeg'); ?>, .<?php echo app('translator')->get('png'); ?>, .<?php echo app('translator')->get('pdf'); ?>, .<?php echo app('translator')->get('doc'); ?>,
                                    .<?php echo app('translator')->get('docx'); ?></span>
                            </div>
                            <div class="contact-form-group col-sm-12">
                                <button type="submit" name="replayTicket" value="1"><?php echo app('translator')->get('Send Message'); ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <!-- <Message> Section -->
    <div class="message__chatbox-section padding-bottom">
        <div class="container">
            <div class="message__chatbox">
                <div class="message__chatbox__body">
                    <ul class="reply-message-area">
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php if($message->admin_id == 0): ?>
                                    <div class="reply-item">
                                        <div class="name-area">
                                            <h6 class="title"><?php echo e(__($message->ticket->name)); ?></h6>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                <?php echo app('translator')->get('Posted on'); ?> <span
                                                    class="cl-theme"><?php echo e($message->created_at->format('l, dS F Y @ H:i')); ?></span>
                                            </span>
                                            <p>
                                                <?php echo e(__($message->message)); ?>

                                            </p>
                                            <?php if($message->attachments->count() > 0): ?>
                                                <div class="mt-2">
                                                    <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(route('ticket.download', encrypt($image->id))); ?>"
                                                            class="mr-3"><i class="fa fa-file"></i> <?php echo app('translator')->get('Attachment'); ?>
                                                            <?php echo e(++$k); ?> </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <ul>
                                        <li>
                                            <div class="reply-item">
                                                <div class="name-area">
                                                    <div class="reply-thumb">
                                                        <img src="<?php echo e(getImage('assets/admin/images/profile/' . $message->admin->image, '400x400')); ?>"
                                                            alt="<?php echo app('translator')->get('Admin Image'); ?>">
                                                    </div>
                                                    <h6 class="title"><?php echo e(__($message->admin->name)); ?></h6>
                                                </div>
                                                <div class="content-area">
                                                    <span class="meta-date">
                                                        <?php echo app('translator')->get('Posted on'); ?>, <span
                                                            class="cl-theme"><?php echo e($message->created_at->format('l, dS F Y @ H:i')); ?></span>
                                                    </span>
                                                    <p>
                                                        <?php echo e(__($message->message)); ?>

                                                    </p>
                                                    <?php if($message->attachments->count() > 0): ?>
                                                        <div class="mt-2">
                                                            <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <a href="<?php echo e(route('ticket.download', encrypt($image->id))); ?>"
                                                                    class="mr-3"><i class="fa fa-file"></i>
                                                                    <?php echo app('translator')->get('Attachment'); ?> <?php echo e(++$k); ?> </a>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                            </li>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['is_custom' => 'yes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
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

<?php echo $__env->make($activeTemplate . 'layouts.' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/support/view.blade.php ENDPATH**/ ?>