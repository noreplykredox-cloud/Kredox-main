<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'is_custom' => 'no',
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'is_custom' => 'no',
]); ?>
<?php foreach (array_filter(([
    'is_custom' => 'no',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<div id="confirmationModal" class="modal fade <?php if($is_custom == 'yes'): ?> custom--modal <?php endif; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Confirmation Alert!'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn <?php if($is_custom == 'yes'): ?> btn--sm btn--danger <?php else: ?> btn--dark <?php endif; ?>" data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                    <button type="submit" class="btn btn--primary <?php if($is_custom == 'yes'): ?> btn--sm bg--base <?php endif; ?>"><?php echo app('translator')->get('Yes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>

<script>
    (function ($) {
        "use strict";
        $(document).on('click','.confirmationBtn', function () {
            var modal   = $('#confirmationModal');
            let data    = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            modal.modal('show');
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\trade\core\resources\views/components/confirmation-modal.blade.php ENDPATH**/ ?>