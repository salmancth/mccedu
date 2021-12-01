<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>
<ul class="product_list_widget">
        <?php if ($rows): ?>
            <?php print $rows; ?>
        <?php endif; ?>
</ul>