<?php if(is_plugin_active('blog')): ?>
    <div class="widget-sidebar widget-search my-4">
        <form
            class="search-form"
            role="search"
            method="GET"
            action="<?php echo e(route('public.search')); ?>"
        >
            <label><span class="screen-reader-text"><?php echo e($config['name'] ?: __('Search for')); ?>:</span>
                <input
                    class="search-field"
                    name="q"
                    type="search"
                    value="<?php echo e(BaseHelper::stringify(request()->query('q'))); ?>"
                    placeholder="<?php echo e(__('Search...')); ?>"
                >
            </label>
            <input
                class="search-submit"
                type="submit"
                value="Search"
            >
        </form>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/blog-search/templates/frontend.blade.php ENDPATH**/ ?>