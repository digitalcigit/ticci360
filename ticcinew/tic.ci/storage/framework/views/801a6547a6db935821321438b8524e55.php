<?php if($posts->isNotEmpty()): ?>
    <?php echo $__env->make(Theme::getThemeNamespace() . '::views.loop', compact('posts'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/templates/posts.blade.php ENDPATH**/ ?>