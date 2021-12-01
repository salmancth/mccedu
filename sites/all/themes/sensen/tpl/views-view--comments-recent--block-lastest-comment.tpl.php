<?php print render($title_prefix); ?>

<div class="widget_comment cm-flex flexslider">
    <ul class="list comment-list slides">
        <?php if ($rows): ?>
            <?php print $rows; ?>
        <?php endif; ?>
    </ul>
</div>