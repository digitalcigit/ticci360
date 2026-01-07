<?php if (! $__env->hasRenderedOnce('65c2b0c7-5cc4-4ed4-8184-c8e26549f784')): $__env->markAsRenderedOnce('65c2b0c7-5cc4-4ed4-8184-c8e26549f784'); ?>
    <div
        class="offcanvas offcanvas-end"
        tabindex="-1"
        id="notification-sidebar"
        aria-labelledby="notification-sidebar-label"
        data-url="<?php echo e(route('notifications.index')); ?>"
        data-count-url="<?php echo e(route('notifications.count-unread')); ?>"
    >
        <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

        <div class="notification-content"></div>
    </div>

    <script src="<?php echo e(asset('vendor/core/core/base/js/notification.js')); ?>"></script>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/core/base/resources/views/notification/notification.blade.php ENDPATH**/ ?>