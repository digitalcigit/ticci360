<?php if(EcommerceHelper::hasAnyProductFilters()): ?>
    <?php
        $dataForFilter = EcommerceHelper::dataForFilter($category ?? null, $request ?? null);
        [$categories, $brands, $tags, $rand, $categoriesRequest, $urlCurrent, $categoryId, $maxFilterPrice] = $dataForFilter;
    ?>

    <div class="bb-shop-sidebar">
        <form action="<?php echo e(URL::current()); ?>" data-action="<?php echo e(route('public.products')); ?>" method="GET" class="bb-product-form-filter">
            <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.filter-hidden-fields'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php echo apply_filters('theme_ecommerce_products_filter_before', null, $dataForFilter); ?>


            <?php if(EcommerceHelper::isEnabledFilterProductsByCategories()): ?>
                <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.categories'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php if(EcommerceHelper::isEnabledFilterProductsByBrands()): ?>
                <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.brands'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php if(EcommerceHelper::isEnabledFilterProductsByTags()): ?>
                <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.tags'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php if(EcommerceHelper::isEnabledFilterProductsByPrice() && (! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled())): ?>
                <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.price'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php if(EcommerceHelper::isEnabledFilterProductsByAttributes()): ?>
                <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters.attributes', ['view' => $view ?? null]), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>

            <?php echo apply_filters('theme_ecommerce_products_filter_after', null, $dataForFilter); ?>

        </form>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters.blade.php ENDPATH**/ ?>