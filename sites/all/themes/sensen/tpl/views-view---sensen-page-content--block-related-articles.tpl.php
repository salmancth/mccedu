<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>

<div class="related-box">
    <h3>
        <?php if ($title): ?>
            <?php print $title; ?>
        <?php endif; ?>
    </h3>
    <div class="bk-related-posts">
        <ul class="related-posts row clearfix">
            <?php if ($rows): ?>
                <?php print $rows; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
