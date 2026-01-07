<?php if(! empty($product->video)): ?>
    <?php $__currentLoopData = $product->video; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(! $video['url']) continue; ?>

        <div class="bb-product-video">
            <?php if($video['provider'] === 'video'): ?>
                <?php
                    $fileExtension = File::extension($video['url']);

                    if (! $fileExtension || $fileExtension === 'mov') {
                        $fileExtension = 'mp4';
                    }
                ?>

                <video
                    id="<?php echo e(md5($video['url'])); ?>"
                    playsinline="playsinline"
                    muted
                    preload="auto"
                    class="media-video"
                    aria-label="<?php echo e($product->name); ?>"
                    poster="<?php echo e($video['thumbnail']); ?>"
                    style="max-width: 100%;"
                >
                    <source src="<?php echo e($video['url']); ?>" type="video/<?php echo e($fileExtension); ?>">
                    <img src="<?php echo e($video['thumbnail']); ?>" alt="<?php echo e($video['url']); ?>">
                </video>
                <button class="bb-button-trigger-play-video" data-target="<?php echo e(md5($video['url'])); ?>">
                    <?php if (isset($component)) { $__componentOriginal73995948b3bd877b76251b40caf28170 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal73995948b3bd877b76251b40caf28170 = $attributes; } ?>
<?php $component = Botble\Icon\View\Components\Icon::resolve(['name' => 'ti ti-player-play-filled'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                </button>
            <?php else: ?>
                <iframe
                    data-provider="<?php echo e($video['provider']); ?>"
                    src="<?php echo e($video['url']); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/plugins/ecommerce/resources/views/themes/includes/product-gallery-video.blade.php ENDPATH**/ ?>