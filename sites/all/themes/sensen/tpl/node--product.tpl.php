<?php
$sale = trim(strip_tags(render($content['product:field_commerce_saleprice_on_sale'])));
$image_uri = $content['product:field_image_front']['#items'][0]['uri'];

$image_uri = file_create_url($image_uri);
$i = 0;

global $user;
$quantity = 0;
$order = commerce_cart_order_load($user->uid);
if ($order) {
    $wrapper = entity_metadata_wrapper('commerce_order', $order);
    $line_items = $wrapper->commerce_line_items;
    $quantity = commerce_line_items_quantity($line_items, commerce_product_line_item_types());
    $total = commerce_line_items_total($line_items);
    $currency = commerce_currency_load($total['currency_code']);
}
//print format_plural($quantity, '1 item', '@count items');
//echo"<pre>";print_r($content);echo "</pre>";
?>
<?php if (!$page) { ?>
    <li class="product type-product status-publish has-post-thumbnail"> <a href="<?php print $node_url; ?>"> <img width="550" height="550" src="<?php print $image_uri ?>"  alt="T_7_front" />
            <h3><?php print $title; ?></h3>
            <div class="star"> <?php print render($content['product:field_star']); ?></div>

            <span class="price">
    <?php
    if ($sale == '1') {
        print render($content['product:field_commerce_saleprice']);
    } else {
        print render($content['product:commerce_price']);
    }
    ?>
            </span> </a>  

        <a href="<?php print $node_url; ?>" class="readmore"><?php print t('Read more'); ?></a>
        </li>
<?php } else { ?>
    <article class="product type-product status-publish has-post-thumbnail">
        <div itemscope itemtype="http://schema.org/Product" class="product type-product status-publish has-post-thumbnail">
            <div class="images"> <a href="<?php print $image_uri ?>" itemprop="image" class="woocommerce-main-image zoom" title="" data-rel="prettyPhoto[product-gallery]"><img width="550" height="550" src="<?php print $image_uri ?>"   /></a>
                <div class="thumbnails product flexslider">
                    <ul class="slides">
                         <?php
                        if (!empty($content['product:field_image_back']['#items'])) {
                            foreach ($content['product:field_image_back']['#items'] as $key => $value) {
                                $image_back_uri = $content['product:field_image_back']['#items'][$key]['uri'];
                                $image_back_uri = file_create_url($image_back_uri);
                                if ($key == 0 || $key == 3 || $key == 6 || $key == 9 || $key == 12) {
                                    ?>

                                    <li><a href="<?php print $image_back_uri ?>" class="zoom first" title="hoodie_3_back" data-rel="prettyPhoto[product-gallery]"><img width="1000" height="1000" src="<?php print $image_back_uri ?>" class="attachment-full"  /></a></li>
                                    <?php } else if($key==2||$key==5||$key==8||$key==11||$key==14||$key==17){
                                    ?>
                                    <li><a href="<?php print $image_back_uri ?>" class="zoom last" title="hoodie_3_back" data-rel="prettyPhoto[product-gallery]"><img width="1000" height="1000" src="<?php print $image_back_uri ?>" class="attachment-full"  /></a></li>   
                                <?php } else { ?>
                                    <li><a href="<?php print $image_back_uri ?>" class="zoom " title="hoodie_3_back" data-rel="prettyPhoto[product-gallery]"><img width="1000" height="1000" src="<?php print $image_back_uri ?>" class="attachment-full"  /></a></li>
                                <?php
                                }
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div class="summary entry-summary">
                <h1 itemprop="name" class="product_title entry-title clearfix"><span><?php print $title; ?></span></h1>
                <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    <div class=""> <?php print render($content['product:field_star']); ?></div>

                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <p class="price"><span class="amount">
                                <?php
                                if ($sale == '1') {
                                    print render($content['product:field_commerce_saleprice']);
                                } else {
                                    print render($content['product:commerce_price']);
                                }
                                ?>
                            </span></p>
                        <meta itemprop="price" content="35" />
                        <meta itemprop="priceCurrency" content="GBP" />
                        <link itemprop="availability" href="http://schema.org/InStock" />
                    </div>
                    <div itemprop="description">

                        <?php print render($content['product:field_product_description']); ?>
                    </div>
                    <?php
                    hide($content['product:field_star']);
                    hide($content['product:field_image_back']);
                    hide($content['product:field_image_front']);
                    hide($content['product:commerce_price']);
                    hide($content['field_categories_product']);
                    hide($content['field_tags']);
                    hide($content['comments']);
                    hide($content['product:field_commerce_saleprice']);
                    hide($content['product:field_product_details']);
                    print render($content);
                    ?>
                    <div class="product_meta">
                        <div class="post-tags clearfix"><span class="post-tags-title posted_in">Categories:</span> <?php print strip_tags(render($content['field_categories_product']), '<a>'); ?></div>
                        <div class="post-tags clearfix"> </div>
                    </div>
                </div>
            </div>
            <!-- .summary -->

            <div class="woocommerce-tabs wc-tabs-wrapper">
                <ul class="tabs wc-tabs">
                    <li class="description_tab"> <a rel="tab-description" href="#tab-description"><?php print t('Description') ?></a> </li>
                    <li class="reviews_tab"> <a href="#tab-reviews" rel="tab-reviews"><?php print t('Reviews') ?> (<?php print $comment_count; ?>)</a> </li>
                </ul>
                <div class="panel entry-content wc-tab" id="tab-description">
                    <h2><?php print t('Product Description') ?></h2>
                    <?php print render($content['product:field_product_details']); ?>
                </div>
                <div class="panel entry-content wc-tab" id="tab-reviews">
                    <div id="reviews">
                        <?php print render($content['comments']); ?>
                    </div>
                </div>
            </div>
            <?php
            print views_embed_view('_sensen_shop', 'block_related_products', " $node->nid");
            ?>
            <meta itemprop="url" content="" />
        </div>
        <!-- #product-50 --> 

    </article>
    <!-- #post-50 --> 
<?php } ?>
