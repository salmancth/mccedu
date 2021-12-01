<?php print render($title_prefix); ?>
<?php if (empty($title)): ?>
    <?php $title = $view->get_title(); ?>
<?php endif; ?>
<article class="product type-product status-publish has-post-thumbnail">
    <div class="page-title">
							<h2><span><?php print $title?></span></h2>
						</div>
<?php if($exposed): ?>
	<?php print $exposed; ?>
<?php endif; ?>
<ul class="products">
    <?php if ($rows): ?>
        <?php print $rows; ?>
    <?php endif; ?>
</ul>

    <?php if ($pager): ?>
        <?php print $pager; ?>
    <?php endif; ?>

</article>