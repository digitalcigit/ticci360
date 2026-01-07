<?php if(is_plugin_active('newsletter')): ?>
    <div class="col-xl-3">
        <div class="widget mb-5">
            <p class="h4 fw-bold widget-title mb-4"><?php echo e($config['title']); ?></p>
            <div class="widget-description pb-3 mb-4"><?php echo e($config['subtitle']); ?></div>
            <div class="form-widget">
                <?php echo \Botble\Newsletter\Forms\Fronts\NewsletterForm::create()
                        ->modify('wrapper_before', 'html', [
                            'html' => '<div class="form-fields"><div class="input-group">
                            <div class="input-group-text">
                                <span class="svg-icon">
                                    <svg>
                                        <use
                                            href="#svg-icon-mail"
                                            xlink:href="#svg-icon-mail"
                                        ></use>
                                    </svg>
                                </span>
                            </div>'
                        ])
                        ->modify('wrapper_after', 'html', [
                            'html' => '</div></div>',
                        ])
                        ->setFormInputClass('form-control shadow-none')
                        ->modify('email', 'email', [
                            'attr' => ['placeholder' => __('Your email...')],
                        ])
                        ->modify('submit', 'submit', [
                            'attr' => ['class' => 'btn btn-primary'],
                        ])
                        ->renderForm(); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/////widgets/newsletter/templates/frontend.blade.php ENDPATH**/ ?>