<?php if (! $__env->hasRenderedOnce('3d7e2260-c215-4734-85c4-3232b47eff93')): $__env->markAsRenderedOnce('3d7e2260-c215-4734-85c4-3232b47eff93'); ?>
    <div id="fb-root"></div>

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <?php if(theme_option('facebook_chat_enabled', 'yes') == 'yes' && theme_option('facebook_page_id')): ?>
        <div id="fb-customer-chat" class="fb-customerchat"></div>

        <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "<?php echo e(theme_option('facebook_page_id')); ?>");
            chatbox.setAttribute("attribution", "biz_inbox");
        </script>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/packages/theme/resources/views/partials/facebook-integration.blade.php ENDPATH**/ ?>