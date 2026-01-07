<div class="bb-ecommerce-filter-hidden-fields">
    <?php $__currentLoopData = [
        'layout',
        'page',
        'per-page',
        'num',
        'sort-by',
        'collection',
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <input
            name="<?php echo e($item); ?>"
            type="hidden"
            class="product-filter-item"
            value="<?php echo e(BaseHelper::stringify(request()->input($item))); ?>"
        >
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(request()->has('collections')): ?>
        <?php
            $collections = EcommerceHelper::parseFilterParams(request(), 'collections');
        ?>
        <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input
                name="collections[]"
                type="hidden"
                class="product-filter-item"
                value="<?php echo e($collection); ?>"
            >
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(request()->has('categories') && ! isset($category)): ?>
        <?php
            $categories = EcommerceHelper::parseFilterParams(request(), 'categories');
        ?>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input
                name="categories[]"
                type="hidden"
                class="product-filter-item"
                value="<?php echo e($category); ?>"
            >
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters/filter-hidden-fields.blade.php ENDPATH**/ ?>