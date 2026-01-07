<?php if($sortParams = EcommerceHelper::getSortParams()): ?>
    <?php
        $sortBy = request()->input('sort-by');
        if ($sortBy && Arr::has($sortParams, $sortBy)) {
            $sortByLabel = Arr::get($sortParams, $sortBy);
        } else {
            $sortBy = array_key_first($sortParams);
            $sortByLabel = Arr::first($sortParams);
        }
    ?>
    <div class="col-auto">
        <div class="catalog-toolbar__ordering d-flex align-items-center me-md-4">
            <input
                name="sort-by"
                type="hidden"
                value="<?php echo e($sortBy); ?>"
            >
            <div class="text d-none d-lg-block"><?php echo e(__('Sort by')); ?></div>
            <div class="dropdown">
                <a
                    class="btn btn-secondary dropdown-toggle"
                    id="dropdown-toolbar__ordering"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                >
                    <span><?php echo e($sortByLabel); ?></span>
                </a>
                <ul
                    class="dropdown-menu"
                    aria-labelledby="dropdown-toolbar__ordering"
                >
                    <?php $__currentLoopData = $sortParams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $sortBy == $key]); ?>">
                            <a
                                class="dropdown-item"
                                data-value="<?php echo e($key); ?>"
                                href="#"
                            ><?php echo e($name); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/includes/sort.blade.php ENDPATH**/ ?>