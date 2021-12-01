<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>
	<div class="s-tags"><span>
            <?php if ($title): ?>
                <?php print $title; ?>
            <?php endif; ?>
            </span>
 <?php if ($rows): ?>
            <?php print $rows; ?>
        <?php endif; ?>
        </div>
