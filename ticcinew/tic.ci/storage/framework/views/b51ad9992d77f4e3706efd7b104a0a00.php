<?php if(($attributes = $attributes->where('attribute_set_id', $set->id)) && $attributes->isNotEmpty()): ?>
    <div class="bb-product-filter-attribute-item">
        <h4 class="bb-product-filter-title"><?php echo e($set->title); ?></h4>

        <div class="bb-product-filter-content">
            <div
                data-type="text"
                data-id="<?php echo e($set->id); ?>"
                data-categories="<?php echo e($set->categories->pluck('id')->toJson()); ?>"
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'text-swatches-wrapper widget-filter-item',
                    'd-none' =>
                        !empty($categoryId) &&
                        $set->categories->count() &&
                        !$set->categories->contains('id', $categoryId),
                ]); ?>"
            >
                <div class="widget-content">
                    <div class="attribute-values">
                        <ul class="text-swatch">
                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li data-slug="<?php echo e($attribute->slug); ?>">
                                    <div>
                                        <label>
                                            <input
                                                class="product-filter-item"
                                                name="attributes[<?php echo e($set->slug); ?>][]"
                                                type="checkbox"
                                                value="<?php echo e($attribute->id); ?>"
                                                <?php if(in_array($attribute->id, $selected)): echo 'checked'; endif; ?>
                                            >
                                            <span><?php echo e($attribute->title); ?></span>
                                        </label>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/attributes/_layouts-filter/text.blade.php ENDPATH**/ ?>