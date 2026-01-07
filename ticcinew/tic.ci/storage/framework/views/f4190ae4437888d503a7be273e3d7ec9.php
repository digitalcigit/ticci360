<?php echo Theme::partial('page-header', ['withTitle' => true]); ?>


<div class="container">
    <div class="row">
        <div class="col-md-9 blog-page-content">
            <div class="mb-4 blog-page-content-wrapper">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo Theme::partial('post-item', compact('post')); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <?php echo $posts->withQueryString()->links(); ?>

            </div>
        </div>
        <div class="col-md-3">
            <div class="primary-sidebar">
                <aside
                    class="widget-area"
                    id="primary-sidebar"
                >
                    <?php echo dynamic_sidebar('primary_sidebar'); ?>

                </aside>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/loop.blade.php ENDPATH**/ ?>