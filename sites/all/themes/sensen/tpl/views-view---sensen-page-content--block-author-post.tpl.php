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
<ul class="row clearfix">

    <?php if ($rows): ?>
        <?php print $rows; ?>
    <?php endif; ?>

</ul>

<?php if ($pager): ?>
    <div class="col-md-12">
           <?php print $pager; ?>
    </div>
<?php endif; ?>
