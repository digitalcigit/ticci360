<?php if($paginator->hasPages()): ?>
    <div class="pagination-numeric-short">
        <?php if($paginator->onFirstPage()): ?>
            <a
                class="disabled"
                href="#"
                aria-disabled="true"
            >
                <span class="svg-icon">
                    <svg>
                        <use
                            href="#svg-icon-chevron-left"
                            xlink:href="#svg-icon-chevron-left"
                        ></use>
                    </svg>
                </span>
            </a>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>">
                <span class="svg-icon">
                    <svg>
                        <use
                            href="#svg-icon-chevron-left"
                            xlink:href="#svg-icon-chevron-left"
                        ></use>
                    </svg>
                </span>
            </a>
        <?php endif; ?>

        <form
            class="toolbar-pagination"
            action="<?php echo e($paginator->path()); ?>"
            method="GET"
        >
            <?php $__currentLoopData = request()->input(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key != $paginator->getPageName() && is_string($item)): ?>
                    <input
                        name="<?php echo e($key); ?>"
                        type="hidden"
                        value="<?php echo e($item); ?>"
                    >
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input
                class="catalog-page-number"
                name="<?php echo e($paginator->getPageName()); ?>"
                type="number"
                value="<?php echo e($paginator->currentPage()); ?>"
                min="1"
                max="<?php echo e($paginator->lastPage()); ?>"
                step="1"
            >
        </form>/ <?php echo e($paginator->lastPage()); ?>


        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>">
                <span class="svg-icon">
                    <svg>
                        <use
                            href="#svg-icon-chevron-right"
                            xlink:href="#svg-icon-chevron-right"
                        ></use>
                    </svg>
                </span>
            </a>
        <?php else: ?>
            <a
                class="disabled"
                href="#"
                aria-disabled="true"
            >
                <span class="svg-icon">
                    <svg>
                        <use
                            href="#svg-icon-chevron-right"
                            xlink:href="#svg-icon-chevron-right"
                        ></use>
                    </svg>
                </span>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/pagination-numeric.blade.php ENDPATH**/ ?>