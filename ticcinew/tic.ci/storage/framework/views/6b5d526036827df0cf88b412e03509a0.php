<div class="quantity">
    <label class="label-quantity"><?php echo e(__('Quantity')); ?>:</label>
    <div class="qty-box">
        <span class="svg-icon decrease">
            <svg>
                <use
                    href="#svg-icon-decrease"
                    xlink:href="#svg-icon-decrease"
                ></use>
            </svg>
        </span>
        <input
            class="input-text qty"
            name="<?php echo e($name ?? 'qty'); ?>"
            type="number"
            value="<?php echo e($value ?? $product->min_cart_quantity); ?>"
            min="<?php echo e($product->min_cart_quantity); ?>"
            max="<?php echo e($product->max_cart_quantity); ?>"
            title="Qty"
            tabindex="0"
            step="1"
            required
        >
        <span class="svg-icon increase">
            <svg>
                <use
                    href="#svg-icon-increase"
                    xlink:href="#svg-icon-increase"
                ></use>
            </svg>
        </span>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/ecommerce/product-quantity.blade.php ENDPATH**/ ?>