<?php if(is_plugin_active('blog')): ?>
    <?php
        $posts = get_recent_posts($config['number_display']);
    ?>
    <?php if($posts->isNotEmpty()): ?>
        <div class="widget-sidebar widget-blog-latest-post">
            <h2 class="widget-title"><?php echo e($config['name'] ?: __('Recent Post')); ?></h2>
            <div class="widget__inner">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card border-0 post-item-small mb-3">
                        <div class="row g-2">
                            <div class="col-3">
                                <a
                                    class="img-fluid-eq"
                                    href="<?php echo e($post->url); ?>"
                                    title="<?php echo e($post->name); ?>"
                                >
                                    <div class="img-fluid-eq__dummy"></div>
                                    <div class="img-fluid-eq__wrap">
                                        <img
                                            class="post-item-image lazyload"
                                            data-src="<?php echo e(RvMedia::getImageUrl($post->image, 'thumb', false, RvMedia::getDefaultImage())); ?>"
                                            alt="<?php echo e($post->name); ?>"
                                        >
                                    </div>
                                </a>
                            </div>
                            <div class="col-9">
                                <div class="entry-meta">
                                    <div class="entry-meta-date">
                                        <time
                                            class="entry-date"
                                            datetime="<?php echo e($post->created_at); ?>"
                                        ><?php echo e(Theme::formatDate($post->created_at)); ?></time>
                                        <?php if($post->author && theme_option('blog_show_author_name', 'yes') == 'yes'): ?>
                                            <span class="d-inline-block ms-1"><?php echo e(__('by')); ?></span> <span
                                                class="d-inline-block author-name ms-1"
                                            ><?php echo e($post->author->name); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h6 class="entry-title">
                                    <a href="<?php echo e($post->url); ?>"><?php echo e($post->name); ?></a>
                                </h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/recent-posts/templates/frontend.blade.php ENDPATH**/ ?>