<article class="post-item-wrapper">
    <div class="card my-3 pb-5 post-item__inner">
        <div class="row g-0">
            <div class="col-md-4 post-item__image">
                <a
                    class="img-fluid-eq"
                    href="<?php echo e($post->url); ?>"
                >
                    <div class="img-fluid-eq__dummy"></div>
                    <div class="img-fluid-eq__wrap">
                        <img
                            class="lazyload img-cover"
                            data-src="<?php echo e(RvMedia::getImageUrl($post->image, null, false, RvMedia::getDefaultImage())); ?>"
                            src="<?php echo e(image_placeholder($post->image)); ?>"
                        >
                    </div>
                </a>
            </div>
            <div class="col-md-8 post-item__content ps-md-4">
                <div>
                    <div class="entry-title">
                        <h4><a href="<?php echo e($post->url); ?>"><?php echo e($post->name); ?></a></h4>
                    </div>

                    <div class="entry-meta mb-2">
                        <?php if($post->author && theme_option('blog_show_author_name', 'yes') == 'yes'): ?>
                            <div class="entry-meta-author">
                                <span class="d-inline-block"><?php echo e(__('By')); ?></span> <span
                                    class="d-inline-block author-name"
                                ><?php echo e($post->author->name); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($post->categories->isNotEmpty()): ?>
                            <div class="entry-meta-categories">
                                <span class="d-inline-block"><?php echo e(($post->author && theme_option('blog_show_author_name', 'yes') == 'yes') ? __('in') : ucfirst(__('in'))); ?></span>
                                <?php $__currentLoopData = $post->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($category->url); ?>"><?php echo e($category->name); ?></a>
                                    <?php if(!$loop->last): ?>
                                        ,
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="entry-meta-date">
                            <span class="d-inline-block"><?php echo e(__('on')); ?></span>
                            <time><?php echo e(Theme::formatDate($post->created_at)); ?></time>
                        </div>
                    </div>
                    <div class="entry-description">
                        <p><?php echo e(Str::limit($post->description, 120)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/partials/post-item.blade.php ENDPATH**/ ?>