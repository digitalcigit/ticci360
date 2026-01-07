<?php if($brands->isNotEmpty()): ?>
    <div class="bb-product-filter">
        <h4 class="bb-product-filter-title"><?php echo e(__('Brands')); ?></h4>

        <div class="bb-product-filter-content">
            <ul class="bb-product-filter-items filter-checkbox">
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="bb-product-filter-item">
                        <?php
                            $requestBrands = EcommerceHelper::parseFilterParams(request(), 'brands');
                        ?>
                        <input id="attribute-brand-<?php echo e($brand->id); ?>" type="checkbox" name="brands[]" value="<?php echo e($brand->id); ?>" <?php if(in_array($brand->id, $requestBrands)): echo 'checked'; endif; ?> />
                        <label for="attribute-brand-<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></label>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters/brands.blade.php ENDPATH**/ ?>