<article class="product type-product status-publish has-post-thumbnail">
<?php if($exposed): ?>
	<?php print $exposed; ?>
<?php endif; ?>
<ul class="products">
    <?php if ($rows): ?>
        <?php print $rows; ?>
    <?php endif; ?>
</ul>
<nav id="pagination" class="woocommerce-pagination header-font clearfix">
    <?php if ($pager): ?>
        <?php print $pager; ?>
    <?php endif; ?>
</nav>
</article>