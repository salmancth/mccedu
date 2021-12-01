<?php
/**
 * @file
 * Default theme implementation to display a node.
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */


//$statistics = statistics_get($node->nid);
hide($content['links']);

// echo '<pre>';
// print_r('$node:');
// // print_r($node);
// // print_r($content['links']);
// print_r($content['field_news_category']);
// echo '</pre>';
// exit;

$content['links']['comment']['#links']['comment-add']['title'] = t('Read / Add Comment');


global $base_root, $base_url;

$user = user_load($uid); // Make sure the user object is fully loaded
$display_name = field_get_items('user', $user, 'field_display_name');
$about = field_get_items('user', $user, 'field_about');

$comment_read_link = $base_url . '/comment/reply/' . $node->nid;

////////////////////////////////////////////////

if (isset($node->field_image) && !empty($node->field_image)) {
    $imageone = $node->field_image['und'][0]['uri'];
    $uri = $node->field_image['und'][0]['uri'];
    $images = $node->field_image['und'];
     $count = count($images);
} else {
    $imageone = '';
}
$i = 0;

if (isset($node->field_image_style['und'][0]['value'])) {
    $image_style = $node->field_image_style['und'][0]['value'];
} else {
    $image_style = 'standard';
}

if (isset($node->field_image['und'][0]['uri'])) $url = file_create_url($node->field_image['und'][0]['uri']);
$node_type = $node->type;
if (isset($node->field_audio['und'][0]['url'])) {
    $audio_url = $node->field_audio['und'][0]['url'];
}
if(isset($node->field_image['und'][0]["image_field_caption"]["value"])){
    $caption = $node->field_image['und'][0]["image_field_caption"]["value"];
}else{
    $caption="";
}

// echo '<pre>';
// $path_alias = drupal_get_path_alias();
// $query_param = drupal_get_query_parameters();
// print_r($path_alias);
// print_r($query_param);
// print_r(arg());
// echo '</pre>';
// print '$teaser = ' . $view_mode . '<br/>' ; 
// print 'type = ' . $node->type;
// NODE TEASER VIEW
if ($teaser) { ?>    
    <li class="item col-md-12">
        <div class="content_out clearfix">
            <div class="bk-mask">
                <div class="thumb hide-thumb"> <a href="<?php print $node_url; ?>"><?php print theme('image_style', array('path' => $imageone, 'style_name' => 'image90', 'attributes' => array('alt' => $title))); ?></a> <!-- close a tag --></div>
                <!-- close thumb --> </div>
            <div class="post-c-wrap">
                    <div class="meta">
                        <div class="post-category"> <i class="fa fa-sitemap"></i> <?php print strip_tags(render($content['field_news_category']), '<a>'); ?></div>
                        <div class="post-date" itemprop="datePublished"><i class="fa fa-clock-o"></i> <?php print format_date($node->changed, 'custom', 'M d Y h:i A'); ?></div>
                        <div class="post-author" itemprop="author"> <i class="fa fa-user"></i> <?php print $name ?></div>
                        <div class="post-comments" itemprop="postComments"> <a title="Total Comments Count" href="<?php print $comment_read_link; ?>"> <i class="fa fa-comments-o"></i> <?php print $node->comment_count; ?></a> </div>
                        
                    </div>
                <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                <div class="excerpt"><?php
                    hide($content['field_subtitle']);
                    print render($content['field_summary']);
                    ?> </div>
                <div class="readmore"><a href="<?php print $node_url; ?>"><?php print t('Read More') ?></a></div>
            </div>
            <div class="post-meta">
                <div class="post-meta-reads">
                    <div class="reads-label">Reads</div>
                </div>

                <div class="post-meta-comments">
                    <div class="comments-label"><a href="<?php print $comment_read_link; ?>">Comments</a></div>
                    <?php if ($node->comment == COMMENT_NODE_OPEN): ?>
                        <div class="comments-count"><a href="<?php print $comment_read_link; ?>"><?php print $node->comment_count; ?></a></div>
                    <?php else: ?>
                        <div class="comments-count">NA</div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </li>

<?php } // END NODE TEASER VIEW ?>


<?php if ($page) { // NODE FULL VIEW print 'NODE FULL VIEW';  ?>
        <div class="s_header_wraper">
            <div class="s-post-header container">
                <h1 itemprop="headline"><?php print $title ?></h1>                
                <?php if ( empty($node->field_hide_author_and_date_info[LANGUAGE_NONE][0]['value']) ): ?>
                <div class="meta">
                    <div class="post-category"> <i class="fa fa-sitemap"></i> <?php print strip_tags(render($content['field_news_category']), '<a>'); ?></div>
                    <div class="post-date" itemprop="datePublished"><i class="fa fa-clock-o"></i> <?php print format_date($node->changed, 'custom', 'M d Y h:i A'); ?></div>
                    <div class="post-author" itemprop="author"> <i class="fa fa-user"></i> <?php print t("by") ?><?php print $name ?></div>
                    <div class="post-comments" itemprop="postComments"> <a title="Total Comments Count | Read all comments" href="<?php print $comment_read_link; ?>"> <i class="fa fa-comments-o"></i> <?php print $node->comment_count . t(' Comments'); ?></a> </div>
                </div>
                <?php endif; ?>
            </div>
        </div>


        <!-- end single header -->
        <div class="article-content clearfix" itemprop="articleBody">
        <?php print render($content["body"]); ?>
        </div>
        <!-- end article content -->

        <!-- COMMENT BOX -->
        <?php if (empty($node->field_hide_page_meta_links[LANGUAGE_NONE][0]['value'])) : ?>

            <?php // print render($content['links']);
                $content['field_news_category']['0']['#title'] = t('See more articles like this');
            ?>
            <div class="comment-box clearfix">
                <?php if ($node->comment == COMMENT_NODE_OPEN): ?>
                    <div class="featured-box small-box icon-main-color box-none box-top-left">
                        <div class="box-icon"><i class="fa fa-comments"></i></div>
                        <h3 class="box-title"><?php print $comment_count; ?><?php print t(' Comments on this article. '); ?></h3>
                        <div class="box-link"> <a title="Read/Add Comments" href="<?php print $comment_read_link; ?>">Read/Add Comments</a> </div>
                    </div>                
                <?php endif; ?>                                      
            </div>
        <?php endif; ?>
        <!-- End Comment Box -->

<?php } // END NODE PAGE ?>
