<?php
    Theme::asset()->container('footer')->add('range-slider-js', 'vendor/core/plugins/ecommerce/libraries/range-slider.js', ['jquery']);
?>

<div class="bb-product-filter">
    <h4 class="bb-product-filter-title border-0 mb-3"><?php echo e(__('Price')); ?></h4>

    <div class="bb-product-filter-content">
        <div class="bb-product-price-filter">
            <div class="price-slider mb-20" data-min="0" data-max="<?php echo e($maxFilterPrice); ?>"></div>
            <div class="bb-product-price-filter-info d-flex align-items-center justify-content-between">
                <span class="input-range">
                    <input name="min_price" type="hidden" value="<?php echo e(BaseHelper::stringify(request()->query('min_price'))); ?>" />
                    <input name="max_price" type="hidden" value="<?php echo e(BaseHelper::stringify(request()->query('max_price'))); ?>" />
                    <span class="input-range-label">
                        <span class="from"></span> &mdash; <span class="to"></span>
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters/price.blade.php ENDPATH**/ ?>