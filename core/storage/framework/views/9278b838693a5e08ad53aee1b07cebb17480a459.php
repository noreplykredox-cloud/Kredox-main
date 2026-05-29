<?php $__env->startSection('content'); ?>
<section class="blog-section padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-xl-4 col-sm-10">
                    <div class="post-item">
                        <div class="post-thumb c-thumb">
                            <a href="<?php echo e(route('blog.details', [$element->id, slug($element->data_values->title)])); ?>">
                                <img src="<?php echo e(getImage('assets/images/frontend/blog/thumb_'. @$element->data_values->blog_image, '370x275')); ?>" alt="blog">
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="blog-header">
                                <h6 class="title">
                                    <a href="<?php echo e(route('blog.details', [$element->id, slug($element->data_values->title)])); ?>"><?php echo e(__(@$element->data_values->title)); ?></a>
                                </h6>
                            </div>
                            <div class="meta-post">
                                <div class="date">
                                    <a href="javascript:void(0)">
                                        <i class="flaticon-calendar"></i>
                                        <?php echo e(showDateTime($element->created_at, 'd M Y')); ?>

                                    </a>
                                </div>
                            </div>
                            <div class="entry-content">
                                <p><?php echo e(strlimit(strip_tags(@$element->data_values->description_nic), 100)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php echo e(paginateLinks($blogs)); ?>

    </div>
</section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/blog.blade.php ENDPATH**/ ?>