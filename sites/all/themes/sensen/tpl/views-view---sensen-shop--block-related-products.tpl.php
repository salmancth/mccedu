<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>

<div class="related products">
    <h2><span> 
            <?php if ($title): ?>
                <?php print $title; ?>
            <?php endif; ?>
        </span></h2>
    <ul class="products">

        <?php if ($rows): ?>
            <?php print $rows; ?>
        <?php endif; ?>

    </ul>
</div>

