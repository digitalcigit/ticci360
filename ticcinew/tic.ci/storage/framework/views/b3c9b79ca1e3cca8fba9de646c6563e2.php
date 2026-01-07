<?php if($categories->isNotEmpty()): ?>
    <div class="bb-product-filter">
        <h4 class="bb-product-filter-title"><?php echo e(__('Categories')); ?></h4>

        <div class="bb-product-filter-content">
            <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.categories-list'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters/categories.blade.php ENDPATH**/ ?>