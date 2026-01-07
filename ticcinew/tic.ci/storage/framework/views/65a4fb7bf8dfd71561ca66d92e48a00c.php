<?php if(($attributes = $attributes->where('attribute_set_id', $set->id)) && $attributes->isNotEmpty()): ?>
    <div
        class="bb-product-attribute-swatch visual-swatches-wrapper attribute-swatches-wrapper"
        data-type="visual"
        data-slug="<?php echo e($set->slug); ?>"
    >
        <h4 class="bb-product-attribute-swatch-title"><?php echo e($set->title); ?>:</h4>
        <ul class="bb-product-attribute-swatch-list visual-swatch color-swatch attribute-swatch">
            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li
                    data-slug="<?php echo e($attribute->slug); ?>"
                    data-id="<?php echo e($attribute->id); ?>"
                    data-bs-toggle="tooltip" data-bs-title="Disabled tooltip"
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'bb-product-attribute-swatch-item attribute-swatch-item',
                        'disabled' => $variationInfo->where('id', $attribute->id)->isEmpty(),
                    ]); ?>"
                >
                    <label>
                        <input
                            type="radio"
                            name="attribute_<?php echo e($set->slug); ?>_<?php echo e($key); ?>"
                            data-slug="<?php echo e($attribute->slug); ?>"
                            <?php if(! empty($referenceProduct)): ?> data-reference-product="<?php echo e($referenceProduct->slug); ?>" <?php endif; ?>
                            value="<?php echo e($attribute->id); ?>"
                            <?php if($selected->where('id', $attribute->id)->isNotEmpty()): echo 'checked'; endif; ?>
                            class="product-filter-item"
                        >
                        <span class="bb-product-attribute-swatch-display" style="<?php echo e($attribute->getAttributeStyle($set, $productVariations)); ?>"></span>
                        <span class="bb-product-attribute-swatch-item-tooltip"><?php echo e($attribute->title); ?></span>
                    </label>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/attributes/_layouts/visual.blade.php ENDPATH**/ ?>