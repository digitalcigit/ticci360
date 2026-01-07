<?php
   Theme::set('pageDescription', $category->description);
?>

<?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.products'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/product-category.blade.php ENDPATH**/ ?>