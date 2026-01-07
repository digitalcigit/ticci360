<?php
    $key = mt_rand();
?>

<div
    class="product-attributes product-attribute-swatches"
    id="product-attributes-<?php echo e($product->id); ?>"
    data-target="<?php echo e(route('public.web.get-variation-by-attributes', $product->getKey())); ?>"
>
    <?php
        $variationInfo = $productVariationsInfo;
        $variationNextIds = [];
    ?>

    <?php $__currentLoopData = $attributeSets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $set): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(! $loop->first): ?>
            <?php
                $variationInfo = $productVariationsInfo->where('attribute_set_id', $set->id)->whereIn('variation_id', $variationNextIds);
            ?>
        <?php endif; ?>

        <?php if(view()->exists($layout = "plugins/ecommerce::themes.attributes._layouts.$set->display_layout")): ?>
            <?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make(EcommerceHelper::viewPath('attributes._layouts.dropdown'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        <?php
            [$variationNextIds] = handle_next_attributes_in_product($attributes->where('attribute_set_id', $set->id), $productVariationsInfo, $set->id, $selected->pluck('id')->toArray(), $loop->index, $variationNextIds);
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/attributes/swatches-renderer.blade.php ENDPATH**/ ?>