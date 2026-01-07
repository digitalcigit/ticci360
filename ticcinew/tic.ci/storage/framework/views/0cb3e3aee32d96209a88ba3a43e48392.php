<?php $__currentLoopData = $attributeSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attributeSet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php ($selected = Arr::get($selectedAttrs, $attributeSet->slug, $selectedAttrs)); ?>

    <?php if(view()->exists(Theme::getThemeNamespace('views.ecommerce.attributes._layouts-filter.' . $attributeSet->display_layout))): ?>
        <?php echo $__env->make(Theme::getThemeNamespace(
                'views.ecommerce.attributes._layouts-filter.' . $attributeSet->display_layout),
            [
                'set' => $attributeSet,
                'attributes' => $attributeSet->attributes,
            ]
        , array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.attributes._layouts-filter.dropdown'), [
            'set' => $attributeSet,
            'attributes' => $attributeSet->attributes,
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/attributes/attributes-filter-renderer.blade.php ENDPATH**/ ?>