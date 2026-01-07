<?php if(is_plugin_active('blog')): ?>
    <?php
        $tags = get_popular_tags($config['number_display']);
    ?>
    <?php if($tags->isNotEmpty()): ?>
        <div class="widget-sidebar widget-blog-tag-cloud">
            <h2 class="widget-title"><?php echo e(BaseHelper::clean($config['name'] ?: __('Tags'))); ?></h2>
            <div class="widget__inner">
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        class="tag-cloud-link"
                        href="<?php echo e($tag->url); ?>"
                        title="<?php echo e($tag->name); ?>"
                        aria-label="<?php echo e($tag->name); ?>"
                    ><?php echo e($tag->name); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/blog-tags/templates/frontend.blade.php ENDPATH**/ ?>