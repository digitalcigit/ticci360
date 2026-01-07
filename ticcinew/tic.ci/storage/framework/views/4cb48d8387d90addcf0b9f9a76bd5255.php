<?php
    Theme::layout('full-width');
    Theme::set('bodyClass', 'single-product');
?>
<?php echo Theme::partial('page-header', ['size' => 'xxxl']); ?>


<div class="product-detail-container">
    <div class="bg-light py-md-5 px-lg-3 px-2">
        <div class="container-xxxl rounded-7 bg-white py-lg-5 py-md-4 py-3 px-3 px-md-4 px-lg-5">
            <div class="row">
                <div class="col-lg-5 col-md-12 mb-md-5 pb-md-5 mb-3">
                    <?php echo $__env->make(EcommerceHelper::viewPath('includes.product-gallery'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <div class="col-lg-4 col-md-8 ps-4 product-details-content">
                    <div class="product-details js-product-content">
                        <div class="entry-product-header">
                            <div class="product-header-left">
                                <h1 class="fs-5 fw-normal product_title entry-title"><?php echo e($product->name); ?></h1>
                                <div class="product-entry-meta">
                                    <?php if($product->brand->name): ?>
                                        <p class="mb-0 me-2 pe-2 text-secondary"><?php echo e(__('Brand')); ?>: <a
                                                href="<?php echo e($product->brand->url); ?>"
                                            ><?php echo e($product->brand->name); ?></a></p>
                                    <?php endif; ?>

                                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                                        <a
                                            class="anchor-link"
                                            href="#product-reviews-tab"
                                        >
                                            <?php echo Theme::partial('star-rating', ['avg' => $product->reviews_avg, 'count' => $product->reviews_count]); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php echo Theme::partial('ecommerce.product-price', compact('product')); ?>


                        <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                            <div class="product-meta-sold-by my-2">
                                <span class="d-inline-block me-1"><?php echo e(__('Sold By')); ?>: </span>
                                <a href="<?php echo e($product->store->url); ?>">
                                    <?php echo e($product->store->name); ?>

                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="ps-list--dot">
                            <?php echo apply_filters('ecommerce_before_product_description', null, $product); ?>

                            <?php echo BaseHelper::clean($product->description); ?>

                            <?php echo apply_filters('ecommerce_after_product_description', null, $product); ?>

                        </div>

                        <?php echo Theme::partial('ecommerce.product-availability', compact('product', 'productVariation')); ?>

                        <?php if(Botble\Ecommerce\Facades\FlashSale::isEnabled() && ($flashSale = $product->latestFlashSales()->first())): ?>
                            <div class="deal-expire-date p-4 bg-light mb-2">
                                <div class="row">
                                    <div class="col-xxl-5 d-md-flex justify-content-center align-items-center">
                                        <div class="deal-expire-text mb-2">
                                            <div class="fw-bold text-uppercase"><?php echo e(__('Hurry up! Sale end in')); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-7">
                                        <div class="countdown-wrapper d-none">
                                            <div
                                                class="expire-countdown col-auto"
                                                data-expire="<?php echo e(Carbon\Carbon::now()->diffInSeconds($flashSale->end_date)); ?>"
                                            >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center my-3">
                                    <div class="deal-sold row mt-2">
                                        <?php if(Botble\Ecommerce\Facades\FlashSale::isShowSaleCountLeft()): ?>
                                            <div class="deal-text col-auto">
                                                <span class="sold fw-bold">
                                                    <span class="text"><?php echo e(__('Sold')); ?>: </span>
                                                    <span class="value"><?php echo e($flashSale->sale_count_left_label); ?></span>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="deal-progress col">
                                            <div class="progress">
                                                <div
                                                    class="progress-bar"
                                                    role="progressbar"
                                                    aria-valuenow="<?php echo e($flashSale->sale_count_left_percent); ?>"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"
                                                    style="width: <?php echo e($flashSale->sale_count_left_percent); ?>%;"
                                                >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php echo Theme::partial(
                            'ecommerce.product-cart-form',
                            compact('product', 'selectedAttrs', 'productVariation') + [
                                'withButtons' => true,
                                'withVariations' => true,
                                'withProductOptions' => true,
                                'wishlistIds' => \Theme\Farmart\Supports\Wishlist::getWishlistIds([$product->id]),
                                'withBuyNow' => true,
                            ],
                        ); ?>

                        <div class="meta-sku <?php if(!$product->sku): ?> d-none <?php endif; ?>">
                            <span class="meta-label d-inline-block me-1"><?php echo e(__('SKU')); ?>:</span>
                            <span class="meta-value" data-bb-value="product-sku"><?php echo e($product->sku); ?></span>
                        </div>
                        <?php if($product->categories->isNotEmpty()): ?>
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block me-1"><?php echo e(__('Categories')); ?>: </span>
                                <?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($category->url); ?>"><?php echo e($category->name); ?></a><?php if(!$loop->last): ?>,<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if($product->tags->isNotEmpty()): ?>
                            <div class="meta-categories">
                                <span class="meta-label d-inline-block me-1"><?php echo e(__('Tags')); ?>: </span>
                                <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($tag->url); ?>"><?php echo e($tag->name); ?></a><?php if(!$loop->last): ?>,<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if(theme_option('social_share_enabled', 'yes') == 'yes'): ?>
                            <div class="my-5">
                                <?php echo Theme::partial('share-socials', compact('product')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <?php echo dynamic_sidebar('product_detail_sidebar'); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="container-xxxl">
        <div class="row product-detail-tabs mt-3 mb-4">
            <div class="col-md-3">
                <div
                    class="nav flex-column nav-pills me-3"
                    id="product-detail-tabs"
                    role="tablist"
                    aria-orientation="vertical"
                >
                    <a
                        class="nav-link active"
                        id="product-description-tab"
                        data-bs-toggle="pill"
                        type="button"
                        href="#product-description"
                        role="tab"
                        aria-controls="product-description"
                        aria-selected="true"
                    >
                        <?php echo e(__('Description')); ?>

                    </a>
                    <?php if(EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty()): ?>
                        <a
                            class="nav-link"
                            id="tab-specification-tab"
                            data-bs-toggle="pill"
                            type="button"
                            href="#tab-specification"
                            role="tab"
                            aria-controls="tab-specification"
                            aria-selected="true"
                        >
                            <?php echo e(__('Specification')); ?>

                        </a>
                    <?php endif; ?>
                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                        <a
                            class="nav-link"
                            id="product-reviews-tab"
                            data-bs-toggle="pill"
                            type="button"
                            href="#product-reviews"
                            role="tab"
                            aria-controls="product-reviews"
                            aria-selected="false"
                        >
                            <?php echo e(__('Reviews')); ?> (<?php echo e($product->reviews_count); ?>)
                        </a>
                    <?php endif; ?>
                    <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                        <a
                            class="nav-link"
                            id="product-vendor-info-tab"
                            data-bs-toggle="pill"
                            type="button"
                            href="#product-vendor-info"
                            role="tab"
                            aria-controls="product-vendor-info"
                            aria-selected="false"
                        >
                            <?php echo e(__('Vendor Info')); ?>

                        </a>
                    <?php endif; ?>
                    <?php if(is_plugin_active('faq') && count($product->faq_items) > 0): ?>
                        <a
                            class="nav-link"
                            id="product-faqs-tab"
                            data-bs-toggle="pill"
                            type="button"
                            href="#product-faqs"
                            role="tab"
                            aria-controls="product-faqs"
                            aria-selected="false"
                        >
                            <?php echo e(__('Questions & Answers')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-9">
                <div
                    class="tab-content"
                    id="product-detail-tabs-content"
                >
                    <div
                        class="tab-pane fade show active"
                        id="product-description"
                        role="tabpanel"
                        aria-labelledby="product-description-tab"
                    >
                        <div class="ck-content">
                            <?php echo BaseHelper::clean($product->content); ?>

                        </div>

                        <?php echo apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $product); ?>

                    </div>

                    <?php if(EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty()): ?>
                        <div class="tab-pane fade" id="tab-specification" role="tabpanel"
                             aria-labelledby="tab-specification-tab">
                            <div class="tp-product-details-additional-info">
                                <?php echo $__env->make(EcommerceHelper::viewPath('includes.product-specification'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(EcommerceHelper::isReviewEnabled()): ?>
                        <div
                            class="tab-pane fade"
                            id="product-reviews"
                            role="tabpanel"
                            aria-labelledby="product-reviews-tab"
                        >
                            <?php echo $__env->make('plugins/ecommerce::themes.includes.reviews', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(is_plugin_active('marketplace') && $product->store_id): ?>
                        <div
                            class="tab-pane fade"
                            id="product-vendor-info"
                            role="tabpanel"
                            aria-labelledby="product-vendor-info-tab"
                        >
                            <?php echo $__env->make(Theme::getThemeNamespace() . '::views.marketplace.includes.info-box', [
                                'store' => $product->store,
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(is_plugin_active('faq') && count($product->faq_items) > 0): ?>
                        <div
                            class="tab-pane fade"
                            id="product-faqs"
                            role="tabpanel"
                            aria-labelledby="product-faqs-tab"
                        >
                            <?php echo $__env->make('plugins/ecommerce::themes.includes.product-faqs', ['faqs' => $product->faq_items], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(($relatedProducts = get_related_products($product, 6)) && $relatedProducts->isNotEmpty()): ?>
    <div class="widget-products-with-category py-5 bg-light">
    <div class="container-xxxl">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center mb-2 widget-header">
                    <h2 class="col-auto mb-0 py-2"><?php echo e(__('Related products')); ?></h2>
                </div>
                <div class="product-deals-day__body arrows-top-right">
                    <div
                        class="product-deals-day-body slick-slides-carousel"
                        data-slick="<?php echo e(json_encode([
                            'rtl' => BaseHelper::siteLanguageDirection() == 'rtl',
                            'appendArrows' => '.arrows-wrapper',
                            'arrows' => true,
                            'dots' => false,
                            'autoplay' => false,
                            'infinite' => false,
                            'autoplaySpeed' => 3000,
                            'speed' => 800,
                            'slidesToShow' => 6,
                            'slidesToScroll' => 1,
                            'swipeToSlide' => true,
                            'responsive' => [
                                [
                                    'breakpoint' => 1400,
                                    'settings' => [
                                        'slidesToShow' => 5,
                                    ],
                                ],
                                [
                                    'breakpoint' => 1199,
                                    'settings' => [
                                        'slidesToShow' => 4,
                                    ],
                                ],
                                [
                                    'breakpoint' => 1024,
                                    'settings' => [
                                        'slidesToShow' => 3,
                                    ],
                                ],
                                [
                                    'breakpoint' => 767,
                                    'settings' => [
                                        'arrows' => true,
                                        'dots' => false,
                                        'slidesToShow' => 2,
                                        'slidesToScroll' => 2,
                                    ],
                                ],
                            ],
                        ])); ?>"
                    >
                        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="product-inner">
                                <?php echo Theme::partial('ecommerce.product-item', ['product' => $relatedProduct]); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="arrows-wrapper"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div id="sticky-add-to-cart">
    <header class="header--product js-product-content">
        <nav class="navigation">
            <div class="container">
                <article class="ps-product--header-sticky">
                    <div class="ps-product__thumbnail">
                        <img
                            src="<?php echo e(RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage())); ?>"
                            alt="<?php echo e($product->name); ?>"
                        >
                    </div>
                    <div class="ps-product__wrapper">
                        <div class="ps-product__content">
                            <span class="ps-product__title"><?php echo BaseHelper::clean($product->name); ?></span>
                            <ul>
                                <li class="active"><a href="#product-description-tab"><?php echo e(__('Description')); ?></a>
                                </li>
                                <?php if(EcommerceHelper::isReviewEnabled()): ?>
                                    <li><a href="#product-reviews-tab"><?php echo e(__('Reviews')); ?>

                                            (<?php echo e($product->reviews_count); ?>)</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="ps-product__shopping">
                            <?php echo Theme::partial('ecommerce.product-price', compact('product')); ?>

                            <?php if(EcommerceHelper::isCartEnabled()): ?>
                                <button
                                    class="btn btn-primary ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>"
                                    name="add_to_cart"
                                    type="button"
                                    value="1"
                                    title="<?php echo e(__('Add to cart')); ?>"
                                    <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>
                                >
                                    <span class="svg-icon">
                                        <svg>
                                            <use
                                                href="#svg-icon-cart"
                                                xlink:href="#svg-icon-cart"
                                            ></use>
                                        </svg>
                                    </span>
                                    <span class="add-to-cart-text ms-1"><?php echo e(__('Add to cart')); ?></span>
                                </button>
                                <?php if(EcommerceHelper::isQuickBuyButtonEnabled()): ?>
                                    <button
                                        class="btn btn-primary btn-black ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>"
                                        name="checkout"
                                        type="button"
                                        value="1"
                                        title="<?php echo e(__('Buy Now')); ?>"
                                        <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>
                                    >
                                        <span class="add-to-cart-text"><?php echo e(__('Buy Now')); ?></span>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        </nav>
    </header>

    <div class="sticky-atc-wrap sticky-atc-shown">
        <div class="container">
            <div class="row">
                <div class="sticky-atc-btn product-button">
                    <?php if(EcommerceHelper::isCartEnabled()): ?>
                        <button
                            class="btn btn-primary mb-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>"
                            name="add_to_cart"
                            type="button"
                            value="1"
                            title="<?php echo e(__('Add to cart')); ?>"
                            <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>
                        >
                            <span class="svg-icon">
                                <svg>
                                    <use
                                        href="#svg-icon-cart"
                                        xlink:href="#svg-icon-cart"
                                    ></use>
                                </svg>
                            </span>
                            <span class="add-to-cart-text ms-1"><?php echo e(__('Add to cart')); ?></span>
                        </button>

                        <?php if(EcommerceHelper::isQuickBuyButtonEnabled()): ?>
                            <button
                                class="btn btn-primary btn-black mb-2 ms-2 add-to-cart-button <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>"
                                name="checkout"
                                type="button"
                                value="1"
                                title="<?php echo e(__('Buy Now')); ?>"
                                <?php if($product->isOutOfStock()): ?> disabled <?php endif; ?>
                            >
                                <span class="add-to-cart-text ms-2"><?php echo e(__('Buy Now')); ?></span>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/ecommerce/product.blade.php ENDPATH**/ ?>