<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>

<div class="widget recommend-box"><a class="close" href="#" title="Close"><i class="fa fa-long-arrow-right"></i></a><h3>
        <?php if ($title): ?>
            <?php print $title; ?>
        <?php endif; ?>
    </h3>


    <div class="entries">
        <ul class="list-small-post">

            <?php if ($rows): ?>
                <?php print $rows; ?>
            <?php endif; ?>

        </ul>
    </div>
</div>

