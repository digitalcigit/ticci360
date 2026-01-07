<div class="vendor-info-box">
    <div class="vendor-info-summary-wrapper">
        <div class="vendor-info-summary">
            <?php $coverImage = $store->getMetaData('background', true); ?>
            <div
                class="vendor-info"
                <?php if($coverImage): ?> style="background-image: url(<?php echo e(RvMedia::getImageUrl($coverImage)); ?>); background-repeat: no-repeat;
                background-size: cover;
                background-position: center;" <?php endif; ?>
            >
                <div
                    class="py-3"
                    <?php if($coverImage): ?> style="background: rgba(0, 0, 0, 0.3)" <?php endif; ?>
                >
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="vendor-info-content px-3">
                                <div class="vendor-store-information row align-items-center">
                                    <div class="vendor-avatar col-3">
                                        <img
                                            class="rounded-circle"
                                            src="<?php echo e($store->logo_url); ?>"
                                            alt="avatar"
                                        >
                                    </div>
                                    <div class="vendor-store-info col">
                                        <h4 class="vendor-name"><?php echo e($store->name); ?></h4>
                                        <?php if(EcommerceHelper::isReviewEnabled()): ?>
                                            <div class="vendor-store-rating mb-3">
                                                <?php echo Theme::partial('star-rating', [
                                                    'avg' => $store->reviews()->avg('star'),
                                                    'count' => $store->reviews()->count(),
                                                ]); ?>

                                            </div>
                                        <?php endif; ?>

                                        <?php if(! MarketplaceHelper::hideStoreAddress() && $store->full_address): ?>
                                            <div class="vendor-store-address mb-1">
                                                <i class="icon icon-map-marker me-1"></i>&nbsp;<?php echo e($store->full_address); ?>

                                            </div>
                                        <?php endif; ?>
                                        <?php if(!MarketplaceHelper::hideStorePhoneNumber() && $store->phone): ?>
                                            <div class="vendor-store-phone mb-1">
                                                <i class="icon icon-telephone me-1"></i>&nbsp;<a
                                                    href="tel:<?php echo e($store->phone); ?>"
                                                ><?php echo e($store->phone); ?></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if(!MarketplaceHelper::hideStoreEmail() && $store->email): ?>
                                            <div class="vendor-store-email mb-1">
                                                <i class="icon icon-envelope me-1"></i>&nbsp;<a
                                                    href="mailto:<?php echo e($store->email); ?>"
                                                ><?php echo e($store->email); ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="store-social-wrapper mt-4 mt-md-0 px-3">
                                <?php if(!MarketplaceHelper::hideStoreSocialLinks()): ?>
                                    <?php if($socials = $store->getMetaData('social_links', true)): ?>)
                                        <ul class="store-social text-lg-end">
                                            <?php $__currentLoopData = MarketplaceHelper::getAllowedSocialLinks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(! Arr::get($socials, $key)) continue; ?>

                                                <li>
                                                    <a href="<?php echo e(Arr::get($social, 'url') . Arr::get($socials, $key)); ?>" target="_blank">
                                                        <?php if($icon = Arr::get($social, 'icon')): ?>
                                                            <?php if (isset($component)) { $__componentOriginal73995948b3bd877b76251b40caf28170 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73995948b3bd877b76251b40caf28170 = $attributes; } ?>
<?php $component = Botble\Icon\View\Components\Icon::resolve(['name' => 'ti ti-brand-' . $icon] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('core::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Botble\Icon\View\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal73995948b3bd877b76251b40caf28170)): ?>
<?php $attributes = $__attributesOriginal73995948b3bd877b76251b40caf28170; ?>
<?php unset($__attributesOriginal73995948b3bd877b76251b40caf28170); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal73995948b3bd877b76251b40caf28170)): ?>
<?php $component = $__componentOriginal73995948b3bd877b76251b40caf28170; ?>
<?php unset($__componentOriginal73995948b3bd877b76251b40caf28170); ?>
<?php endif; ?>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php elseif($socials = $store->getMetaData('socials', true)): ?>
                                        <ul class="store-social text-lg-end">
                                            <?php $__currentLoopData = (array) $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a
                                                        class="social-<?php echo e($k); ?>"
                                                        href="<?php echo e($link); ?>"
                                                        target="_blank"
                                                    >
                                                        <span class="svg-icon">
                                                            <svg>
                                                                <use
                                                                    href="#svg-icon-<?php echo e($k); ?>"
                                                                    xlink:href="#svg-icon-<?php echo e($k); ?>"
                                                                ></use>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <ul class="vendor-store-info mt-4 text-lg-end px-3">
                                <li class="vendor-store-register-date">
                                    <span><?php echo e(__('Started from')); ?>: </span>
                                    <?php echo e(Theme::formatDate($store->created_at)); ?>

                                </li>
                            </ul>
                        </div>
                        <?php if(!empty($showContactVendor)): ?>
                            <div class="col-12">
                                <div class="px-3">
                                    <a
                                        class="d-lg-none sidebar-filter-mobile text-white"
                                        data-toggle="contact-store-primary-sidebar"
                                        href="#"
                                    >
                                        <span class="svg-icon me-2">
                                            <svg>
                                                <use
                                                    href="#svg-icon-send"
                                                    xlink:href="#svg-icon-send"
                                                ></use>
                                            </svg>
                                        </span>
                                        <span><?php echo e(__('Contact Vendor')); ?></span>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
                $description = BaseHelper::clean($store->description);
                $content = BaseHelper::clean($store->content);
            ?>

            <?php if($description || $content): ?>
                <div class="py-3 mb-3 bg-light">
                    <div class="px-3">
                        <?php if($content): ?>
                            <div
                                id="store-content"
                                class="d-none"
                            >
                                <?php echo $content; ?>

                            </div>
                        <?php endif; ?>

                        <div id="store-short-description">
                            <?php echo $description ?: Str::limit($content, 250); ?>

                        </div>

                        <a
                            class="text-link toggle-show-more ms-1"
                            href="#"
                        ><?php echo e(__('show more')); ?></a>
                        <a
                            class="text-link toggle-show-less ms-1 d-none"
                            href="#"
                        ><?php echo e(__('show less')); ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/marketplace/includes/info-box.blade.php ENDPATH**/ ?>