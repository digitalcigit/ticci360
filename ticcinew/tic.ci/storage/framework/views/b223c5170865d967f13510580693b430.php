<?php if(! EcommerceHelper::hideProductPrice() || EcommerceHelper::isCartEnabled()): ?>
    <span class="product-price">
        <span class="product-price-sale bb-product-price <?php if(!$product->isOnSale()): ?> d-none <?php endif; ?>">
            <ins>
                <span class="price-amount">
                    <bdi>
                        <span class="amount bb-product-price-text" data-bb-value="product-price"><?php echo e(format_price($product->front_sale_price_with_taxes)); ?></span>
                    </bdi>
                </span>
            </ins>
            &nbsp;
            <del aria-hidden="true">
                <span class="price-amount">
                    <bdi>
                        <span class="amount bb-product-price-text-old" data-bb-value="product-original-price"><?php echo e(format_price($product->price_with_taxes)); ?></span>
                    </bdi>
                </span>
            </del>
        </span>
        <span class="product-price-original bb-product-price <?php if($product->isOnSale()): ?> d-none <?php endif; ?>">
            <span class="price-amount">
                <bdi>
                    <span class="amount bb-product-price-text" data-bb-value="product-price"><?php echo e(format_price($product->front_sale_price_with_taxes)); ?></span>
                </bdi>
            </span>
        </span>
    </span>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/ecommerce/product-price.blade.php ENDPATH**/ ?>