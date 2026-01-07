<?php if(is_plugin_active('blog') && $categories->isNotEmpty()): ?>
    <div class="widget-sidebar widget-blog-categories">
        <h2 class="widget-title"><?php echo BaseHelper::clean($config['name'] ?: __('Categories')); ?></h2>
        <div class="widget__inner">
            <ul>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="cat-item">
                        <a
                            href="<?php echo e($category->url); ?>"
                            title="<?php echo e($category->name); ?>"
                        ><?php echo e($category->name); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/blog-categories/templates/frontend.blade.php ENDPATH**/ ?>