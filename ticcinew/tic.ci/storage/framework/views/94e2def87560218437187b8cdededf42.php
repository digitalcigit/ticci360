<?php
    Theme::layout('full-width');
    $products->loadMissing('defaultVariation');
?>

<?php echo $widgets = dynamic_sidebar('products_list_sidebar'); ?>


<?php if(empty($widgets)): ?>
    <?php echo Theme::partial('page-header', ['size' => 'xxxl', 'withTitle' => false]); ?>

<?php endif; ?>

<div class="container-xxxl">
    <div class="row my-3 my-md-5">
        <div class="col-12">
            <div class="row catalog-header justify-content-between">
                <div class="col-auto catalog-header__left d-flex align-items-center">
                    <h1 class="h2 catalog-header__title d-none d-lg-block"><?php echo e(SeoHelper::getTitleOnly()); ?></h1>

                    <?php if(EcommerceHelper::hasAnyProductFilters()): ?>
                        <a
                            class="d-lg-none sidebar-filter-mobile"
                            href="#"
                        >
                            <span class="svg-icon me-2">
                                <svg>
                                    <use
                                        href="#svg-icon-filter"
                                        xlink:href="#svg-icon-filter"
                                    ></use>
                                </svg>
                            </span>
                            <span><?php echo e(__('Filter')); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-auto catalog-header__right">
                    <div class="catalog-toolbar row align-items-center">
                        <?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.includes.sort'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.includes.layout'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(Theme::get('pageDescription')): ?>
        <div class="ps-block__content">
            <div class="ps-section__content">
                <?php echo BaseHelper::clean(Theme::get('pageDescription')); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if(EcommerceHelper::hasAnyProductFilters()): ?>
            <div class="col-xxl-2 col-lg-3">
                <aside
                    class="catalog-primary-sidebar catalog-sidebar"
                    data-toggle-target="product-categories-primary-sidebar"
                >
                    <div class="backdrop"></div>

                    <div class="catalog-sidebar--inner side-left">
                        <?php echo $__env->make(EcommerceHelper::viewPath('includes.filters'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </aside>
            </div>
        <?php endif; ?>
        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['products-listing position-relative bb-product-items-wrapper col-12', 'col-xxl-10 col-lg-9' => EcommerceHelper::hasAnyProductFilters()]); ?>">
            <?php echo $__env->make(Theme::getThemeNamespace('views.ecommerce.includes.product-items'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/products.blade.php ENDPATH**/ ?>