<?php
    Theme::set('pageTitle', $page->name);
?>

<?php echo apply_filters(
    PAGE_FILTER_FRONT_PAGE_CONTENT,
    Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content'])->toHtml(),
    $page,
); ?>

<?php /**PATH /home/dcidev/CascadeProjects/tic.ci/platform/themes/farmart/views/page.blade.php ENDPATH**/ ?>