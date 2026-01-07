<?php if($tags->isNotEmpty()): ?>
    <div class="bb-product-filter">
        <h4 class="bb-product-filter-title"><?php echo e(__('Tags')); ?></h4>

        <div class="bb-product-filter-content">
            <ul class="bb-product-filter-items filter-checkbox">
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="bb-product-filter-item">
                        <?php
                            $requestTags = EcommerceHelper::parseFilterParams(request(), 'tags');
                        ?>
                        <input id="attribute-tag-<?php echo e($tag->id); ?>" type="checkbox" name="tags[]" value="<?php echo e($tag->id); ?>" <?php if(in_array($tag->id, $requestTags)): echo 'checked'; endif; ?> />
                        <label for="attribute-tag-<?php echo e($tag->id); ?>"><?php echo e($tag->name); ?></label>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/filters/tags.blade.php ENDPATH**/ ?>