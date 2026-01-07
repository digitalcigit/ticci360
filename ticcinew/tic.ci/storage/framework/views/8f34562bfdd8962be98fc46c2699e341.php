<div
    class="row <?php echo e(in_array($sidebar, ['pre_footer_sidebar', 'footer_sidebar', 'bottom_footer_sidebar']) ? 'row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 justify-content-center my-4 g-2' : 'row-cols-1 bg-light mb-5 py-3 px-4 g-0'); ?>">
    <?php for($i = 1; $i <= 5; $i++): ?>
        <?php if($title = Arr::get(Arr::get($config['data'], $i), 'title')): ?>
            <div class="col py-2">
                <div class="site-info__item d-flex align-items-start">
                    <div class="site-info__image me-3 mt-1">
                        <img
                            class="lazyload"
                            data-src="<?php echo e(RvMedia::getImageUrl(Arr::get(Arr::get($config['data'], $i), 'icon'), null, false, RvMedia::getDefaultImage())); ?>"
                            alt="<?php echo e($title); ?>"
                        >
                    </div>
                    <div class="site-info__content">
                        <div class="site-info__title h4 fw-bold"><?php echo e($title); ?></div>
                        <div class="site-info__desc"><?php echo BaseHelper::clean(nl2br(Arr::get(Arr::get($config['data'], $i), 'subtitle'))); ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/site-features/templates/frontend.blade.php ENDPATH**/ ?>