<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>

<div class="module-title">
    <h2 class="main-title"><span>  
            <?php if ($title): ?>
                <?php print $title; ?>
            <?php endif; ?>
        </span></h2>

    <?php if ($header): ?>  
        <?php print $header; ?>
    <?php endif; ?>
</div>
<div class="bk-masonry-wrap">
    <div class="row clearfix">
        <ul class="bk-masonry-content clearfix">

            <?php if ($rows): ?>
                <?php print $rows; ?>
            <?php endif; ?>

        </ul>
    </div>
</div>

<?php if ($footer): ?>

    <?php print $footer; ?>

<?php endif; ?>
