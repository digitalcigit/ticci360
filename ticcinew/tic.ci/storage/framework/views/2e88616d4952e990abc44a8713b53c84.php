<div class="summary-meta">
    <?php if($product->isOutOfStock()): ?>
        <div class="product-stock out-of-stock d-inline-block">
            <label><?php echo e(__('Availability')); ?>:</label> <span class="number-items-available"><?php echo e(__('Out of stock')); ?></span>
        </div>
    <?php elseif(! $product->with_storehouse_management || $product->quantity < 1): ?>
        <div class="product-stock in-stock d-inline-block">
            <label><?php echo e(__('Availability')); ?>:</label> <span class="number-items-available"><?php echo BaseHelper::clean($product->stock_status_html); ?></span>
        </div>
    <?php elseif($product->quantity): ?>
        <?php if(EcommerceHelper::showNumberOfProductsInProductSingle()): ?>
            <div class="product-stock in-stock d-inline-block">
                <label><?php echo e(__('Availability')); ?>:</label>
                <span class="product-quantity-available number-items-available">
                    <?php if($product->quantity != 1): ?>
                        <?php echo e(__(':number products available', ['number' => $product->quantity])); ?>

                    <?php else: ?>
                        <?php echo e(__(':number product available', ['number' => $product->quantity])); ?>

                    <?php endif; ?>
                </span>
            </div>
        <?php else: ?>
            <div class="product-stock in-stock d-inline-block">
                <label><?php echo e(__('Availability')); ?>:</label> <span><?php echo e(__('In stock')); ?></span>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/ecommerce/product-availability.blade.php ENDPATH**/ ?>