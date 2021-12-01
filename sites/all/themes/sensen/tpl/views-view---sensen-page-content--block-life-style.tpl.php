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
<div class="row clearfix">
    <ul>
        <?php if ($rows): ?>
            <?php print $rows; ?>
        <?php endif; ?>
    </ul>
    <div class="col-md-4 col-sm-12 clearfix">
        <ul class="list-small-post">
            <?php if ($attachment_after): ?>
                <?php print $attachment_after; ?>
            <?php endif; ?>
        </ul>
    </div>

</div>


