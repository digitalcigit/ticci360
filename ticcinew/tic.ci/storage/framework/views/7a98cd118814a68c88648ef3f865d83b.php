<?php
    $products->loadMissing(['defaultVariation', 'options', 'options.values']);
?>
<div class="loading loading-container">
    <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
</div>
<!--products list-->
<input
    name="page"
    data-value="<?php echo e($products->currentPage()); ?>"
    type="hidden"
>
<input
    name="q"
    type="hidden"
    value="<?php echo e(BaseHelper::stringify(request()->query('q'))); ?>"
>
<div
    class="row <?php if(request()->input('layout') == 'list'): ?> row-cols-1 shop-products-listing__list <?php else: ?> row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 <?php endif; ?> shop-products-listing g-0 <?php if($products->isEmpty()): ?> border-0 <?php endif; ?>">
    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col">
            <div class="product-inner">
                <?php echo Theme::partial('ecommerce.product-item', compact('product')); ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12 w-100">
            <div
                class="alert alert-warning mt-4 w-100"
                role="alert"
            >
                <?php echo e(__(':total Product(s) found', ['total' => 0])); ?>

            </div>
        </div>
    <?php endif; ?>
</div>

<div class="row mt-2 mb-3">
    <?php
       if (Route::currentRouteName() !== 'public.products') {
           request()->merge(['categories' => null]);
       }
    ?>
    <?php echo $products->withQueryString()->links(Theme::getThemeNamespace('partials.pagination-numeric')); ?>

</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/includes/product-items.blade.php ENDPATH**/ ?>