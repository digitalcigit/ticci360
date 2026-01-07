<?php if($sharingButtons = \Botble\Theme\Supports\ThemeSupport::getSocialSharingButtons($product->url, $product->description, $product->image)): ?>
    <ul class="widget-socials-share widget-socials__text">
        <?php $__currentLoopData = $sharingButtons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php
                    $button['background_color'] = $button['background_color'] ?: (theme_option('primary_button_background_color') ?: theme_option('primary_color', '#fab528'));
                    $button['color'] = $button['color'] ?? '#fff';
                ?>
                <a
                    href="<?php echo e($button['url']); ?>"
                    title="<?php echo e($button['name']); ?>"
                    target="_blank"
                    style="<?php echo \Illuminate\Support\Arr::toCssStyles(["background-color: {$button['background_color']}" => $button['background_color'], "color: {$button['color']}" => $button['color']]) ?>"
                >
                    <?php echo $button['icon']; ?>


                    <span class="text"><?php echo e($button['name']); ?></span>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>

<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/share-socials.blade.php ENDPATH**/ ?>