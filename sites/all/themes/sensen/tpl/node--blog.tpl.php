<?php
/**

 * @file

 * Default theme implementation to display a node.
/**
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


$statistics = statistics_get($node->nid);

// echo '<pre>';
// print_r('$node:');
// print_r($node);
// print_r($content['links']);
// echo '</pre>';
// exit;

$content['links']['comment']['#links']['comment-add']['title'] = t('Read / Add Comment');
// $content['field_categories']['0']['#title'] = t('See more articles like this');

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

if (isset($node->field_sidebar['und'][0]['value'])) {
    $sidebar = $node->field_sidebar['und'][0]['value'];
} else {
    $sidebar = 'right';
}
if (isset($node->field_header_style['und'][0]['value'])) {
    $header_style = $node->field_header_style['und'][0]['value'];
} else {
    $header_style = 'standard';
}
if (isset($node->field_audio_and_video_style['und'][0]['value'])) {
    $audio_video_style = $node->field_audio_and_video_style['und'][0]['value'];
} else {
    $audio_video_style = 'standard';
}
if (isset($node->field_image_style['und'][0]['value'])) {
    $image_style = $node->field_image_style['und'][0]['value'];
} else {
    $image_style = 'standard';
}

$url = file_create_url($node->field_image['und'][0]['uri']);
$node_type = $node->type;
if (isset($node->field_audio['und'][0]['url'])) {
    $audio_url = $node->field_audio['und'][0]['url'];
}
if(isset($node->field_image['und'][0]["image_field_caption"]["value"])){
    $caption = $node->field_image['und'][0]["image_field_caption"]["value"];
}else{
    $caption="";
}

// NODE TEASER VIEW
if (!$page) {
    ?>

    <?php
    if (((arg(0) == "taxonomy") && (arg(1) == "term")) || (arg(0) == 'blog')) {

        if (arg(0) == "taxonomy") {
            $term = taxonomy_term_load(arg(2));
            $taxonomy_sidebar = field_get_items("taxonomy_term", $term, "field_sidebar");
            $taxonomy_blog_style = field_get_items("taxonomy_term", $term, "field_blog_style");
            if (isset($taxonomy_blog_style[0]['value'])) {
                $blog_style = $taxonomy_blog_style[0]['value'];
            } else {
                $blog_style = theme_get_setting('blog_style', 'sensen');
            }
            if (isset($taxonomy_sidebar[0]['value'])) {
                $sidebar_style = $taxonomy_sidebar[0]['value'];
            } else {
                $sidebar_style = theme_get_setting('sidebar_style', 'sensen');
            }
        } else {
            $blog_style = theme_get_setting('blog_style', 'sensen');
            $sidebar_style = theme_get_setting('sidebar_style', 'sensen');
        }

        //print $term;
        if ($blog_style == "largeblog" || $blog_style == "classblog") {
            ?>

            <li class="item col-md-12">
                <div class="content_out clearfix">
                    <div class="bk-mask">
                        <div class="thumb hide-thumb"> <a href="<?php print $node_url; ?>"><?php print theme('image_style', array('path' => $imageone, 'style_name' => 'image90', 'attributes' => array('alt' => $title))); ?></a> <!-- close a tag --></div>
                        <!-- close thumb --> </div>
                    <div class="post-c-wrap">
                            <div class="meta">
                                <div class="post-category"> <i class="fa fa-sitemap"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                <div class="post-date" itemprop="datePublished"><i class="fa fa-clock-o"></i> <?php print format_date($node->changed, 'custom', 'M d Y'); ?></div>
                                <div class="post-author" itemprop="author"> <i class="fa fa-user"></i> <?php print $name ?></div>
                                <div class="post-comments" itemprop="postComments"> <a title="Total Comments Count" href="<?php print $node_url; ?>"> <i class="fa fa-comments-o"></i> <?php print $node->comment_count; ?></a> </div>
                                <div class="post-reads bg-primary p5 " itemprop="postTotalReaders"><i class="fa fa-book"></i> <?php print intval($statistics['totalcount']); ?></div>
                            </div>
                        <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                        <div class="excerpt"><?php
                            hide($content['field_subtitle']);
                            print render($content['body']);
                            ?> </div>
                        <div class="readmore"><a href="<?php print $node_url; ?>"><?php print t('Read More') ?></a></div>
                    </div>
                    <div class="post-meta">
                        <div class="post-meta-reads">
                            <div class="reads-label"><i class="fa fa-book"></i> Reads</div>
                            <div class="reads-count"><?php print intval($statistics['totalcount']); ?></div>
                        </div>

                        <div class="post-meta-comments">
                            <div class="comments-label"><a href="<?php print $node_url; ?>"><i class="fa fa-comments"></i> Comments</a></div>
                            <div class="comments-count"><a href="<?php print $node_url; ?>"><?php print $node->comment_count; ?></a></div>
                        </div>
                    </div>
                </div>
            </li>

            <?php
            // print "xinchao";
        } elseif ($blog_style == "masonryblog") {
            if ($sidebar_style == "left" || $sidebar_style == 'right') {
                ?>

                <li class="col-md-6 col-sm-6 item">
                    <div class="row-type content_out">
                        <div class="bk-mask">
                            <div class="thumb hide-thumb"><a href="<?php print $node_url; ?>"><img src="<?php print file_create_url($node->field_image['und'][0]['uri']); ?>" alt="<?php print $title ?>"></a> <!-- close a tag --></div>
                            <!-- close thumb -->
                        </div>
                        <div class="post-c-wrap sink">
                            <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                            <div class="meta">
                                <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'd F Y'); ?></div>
                                <div class="post-author" itemprop="author">by <?php print $name; ?></div>
                            </div>
                            <div class="excerpt"><?php
                                hide($content['field_subtitle']);
                                print render($content['body']);
                                ?> </div>
                        </div>
                        <div class="readmore"><a href="<?php print $node_url; ?>"><?php print t('Read More') ?></a></div>
                    </div>
                </li>

            <?php } else {
                ?>
                <li class="col-md-4 col-sm-6 item">
                    <div class="row-type content_out">
                        <div class="bk-mask">
                            <div class="thumb hide-thumb"><a href="<?php print $node_url; ?>"><img src="<?php print file_create_url($node->field_image['und'][0]['uri']); ?>" alt="<?php print $title ?>"></a> <!-- close a tag --></div>
                            <!-- close thumb -->
                        </div>
                        <div class="post-c-wrap sink">
                            <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                            <div class="meta">
                                <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'd F Y'); ?></div>
                                <div class="post-author" itemprop="author"><?php print t('by') ?> <?php print $name; ?></div>
                            </div>
                            <div class="excerpt"><?php
                hide($content['field_subtitle']);
                print render($content['body']);
                ?> </div>
                        </div>
                        <div class="readmore"><a href="<?php print $node_url; ?>"><?php print t('Read More') ?></a></div>
                    </div>
                </li>
                <?php
            } // print "xinchao";
        } elseif ($blog_style == "squaregridblog") {
            if ($sidebar_style == "left" || $sidebar_style == "right") {
                ?>
                <li class="content_in col-md-6 col-sm-6">
                    <div class="content_in_wrapper">
                        <div class="thumb"  style="background-image: url(<?php print file_create_url($node->field_image['und'][0]['uri']); ?>)"></div>
                        <div class="post-c-wrap">
                            <div class="inner">
                                <div class="inner-cell">
                                    <div class="innerwrap">
                                        <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                                        <div class="meta">
                                            <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                            <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'd F Y'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } else {
                ?>
                <li class="content_in col-md-4 col-sm-6">
                    <div class="content_in_wrapper">
                        <div class="thumb"  style="background-image: url(<?php print file_create_url($node->field_image['und'][0]['uri']); ?>)"></div>
                        <div class="post-c-wrap">
                            <div class="inner">
                                <div class="inner-cell">
                                    <div class="innerwrap">
                                        <h4 class="title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h4>
                                        <div class="meta">
                                            <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                            <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'd F Y'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <?php
            }
        }
    } else {

    }
} else {
    // NODE FULL VIEW
    ?>

    <?php if ($node_type != 'page' && $node_type != 'homepage' && $node_type != 'special_pages') { ?>

        <?php
        if ($header_style != "fullwidth") {
            if ((isset($node->field_youtube) && !empty($node->field_youtube)) || (isset($node->field_vimeo) && !empty($node->field_vimeo)) || (isset($node->field_audio) && !empty($node->field_audio))) {
                ?>
                    <?php if ($audio_video_style == "popup") { ?>
                    <header id="bk-normal-feat" class="clearfix">
                        <div class="s-feat-img"><img width="620" height="420" src="<?php print $url; ?>"  alt="<?php print $title; ?>" /></div>
                        <?php if (isset($node->field_youtube) && !empty($node->field_youtube)) { ?>
                            <div class="icon-play"><a class="video-popup-link" href="<?php print $node->field_youtube["und"][0]["video_url"]; ?>"><i class="fa fa-play-circle"></i></a></div>
                        <?php } elseif (isset($node->field_vimeo) && !empty($node->field_vimeo)) {
                            ?>
                            <div class="icon-play"><a class="video-popup-link" href="<?php print $node->field_vimeo["und"][0]["video_url"]; ?>"><i class="fa fa-play-circle"></i></a></div>
                    <?php } else { ?>
                            <div class="icon-play"><a class="img-popup-link mfp-iframe audio" href="<?php print 'https://w.soundcloud.com/player/?visual=true&url=' . $audio_url . '&show_artwork=true&#038;maxwidth=1200&#038;maxheight=1000' ?>"><i class="fa fa-volume-up"></i></a></div>
                    <?php }
                    ?>
                    </header>
                            <?php } else {
                                ?>
                    <?php if (isset($node->field_youtube) && !empty($node->field_youtube)) { ?>
                        <header id="bk-normal-feat" class="clearfix">
                            <div class="bk-embed-video">
                                <div class="bk-frame-wrap">
                        <?php print render($content["field_youtube"]); ?>
                                </div>
                            </div>
                        </header>
                    <?php } elseif (isset($node->field_vimeo) && !empty($node->field_vimeo)) { ?>
                        <header id="bk-normal-feat" class="clearfix">
                            <div class="bk-embed-video">
                                <div class="bk-frame-wrap">
                        <?php print render($content["field_vimeo"]); ?>
                                </div>
                            </div>
                        </header>
                    <?php } else { ?>
                        <header id="bk-normal-feat" class="clearfix">
                            <div class="bk-embed-video">
                                <div class="bk-frame-wrap">
                        <?php print render($content["field_audio"]); ?>
                                </div>
                            </div>
                        </header>
                        <?php
                    }
                }
                ?>
                <div class="s_header_wraper">
                    <div class="s-post-header container">
                        <h1 itemprop="headline"><?php print $title; ?></h1>
                        <div class="meta">
                            <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                            <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'M d Y'); ?></div>
                            <div class="post-author" itemprop="author"><?php print t("by") ?> <?php print $name ?></div>
                        </div>
                    </div>
                </div>

                <?php
            } else {
                if ((!empty($node->field_image)) && ($count > 1)) {
                    ?>
                    <header id="bk-normal-feat" class="clearfix">
                        <div class="gallery-wrap">
                            <div id="bk-gallery-slider" class="flexslider">
                                <ul class="slides">
                    <?php
                    foreach ($images as $image) :
                        $url = $node->field_image['und'][$i]['uri'];  //full url
                        ?>
                                        <li class="bk-gallery-item"><a class="zoomer" title="<?php print $title ?>" data-source="<?php print file_create_url($url) ?>" href="<?php print file_create_url($url) ?>"><?php print theme('image_style', array('path' => $url, 'style_name' => 'image730x383', 'attributes' => array('alt' => $title))); ?></a>
                                            <div class="caption"><?php print $caption;?></div>
                                        </li>
                        <?php
                        $i++;
                    endforeach;
                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="s_header_wraper">
                            <div class="s-post-header container">
                                <h1 itemprop="headline"><?php print $title ?></h1>

                                <div class="meta">
                                    <div class="post-category"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                    <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'M d Y'); ?></div>
                                    <div class="post-author" itemprop="author"><?php print t('by') ?> <?php print $name ?></div>
                                </div>
                            </div>
                        </div>
                    </header>
                <?php } else {
                    ?>
                    <header id="bk-normal-feat" class="clearfix">
                        <div class="s-feat-img"><?php print theme('image_style', array('path' => $imageone, 'style_name' => 'image730x495', 'attributes' => array('alt' => $title))); ?></div>
                    </header>
                    <div class="s_header_wraper">
                        <div class="s-post-header container">
                            <h1 itemprop="headline"><?php print $title ?></h1>
                            <div class="meta">
                                <div class="post-category"> <i class="fa fa-sitemap"></i> <?php print strip_tags(render($content['field_categories']), '<a>'); ?></div>
                                <div class="post-date" itemprop="datePublished"><i class="fa fa-clock-o"></i> <?php print format_date($node->changed, 'custom', 'M d Y h:i A'); ?></div>
                                <div class="post-author" itemprop="author"> <i class="fa fa-user"></i> <?php print t("by") ?><?php print $name ?></div>
                                <div class="post-comments" itemprop="postComments"> <a title="Total Comments Count | Read all comments" href="<?php print $comment_read_link; ?>"> <i class="fa fa-comments-o"></i> <?php print $node->comment_count . t(' Comments'); ?></a> </div>
                                <div class="post-reads bg-primary p5 " itemprop="postTotalReaders"><i class="fa fa-book"></i> <?php print t('Reads ') . intval($statistics['totalcount']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

        <?php }
        ?>
        <!-- end single header -->
        <div class="article-content clearfix" itemprop="articleBody">
        <?php print render($content["body"]); ?>
        </div>
        <!-- end article content -->
        <!-- TAGS -->
        <?php
        print views_embed_view('_sensen_tags', 'block_tags', $node->nid);
        ?>

        <!-- NAV -->



        <div class="s-post-nav">
            <div class="nav-btn hide-nav nav-prev">
        <?php print single_navigation("blog", $node->nid, "prev") ?>
            </div>
            <div class="nav-btn hide-nav nav-next">
        <?php print single_navigation("blog", $node->nid, "next") ?>
            </div>
        </div>

        <div class="share-box-wrap">
            <div class="share-box">
                <div class="share-total-wrap">
                    <div class="share-total">
                        <!--                        <div class="share-total__value">0</div>-->
                        <div class="share-total__title">Shares</div>
                    </div>
                </div>
                <!-- End share-total-wrap -->
                <ul class="social-share">
                    <li id="facebook" class="bk-share bk_facebook_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="Like"></li>
                    <li id="twitte" class="bk-share bk_twitter_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="Tweet"></li>
                    <li id="gplus" class="bk-share bk_gplus_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="G+"></li>
                    <li id="pinterest" class="bk-share bk_pinterest_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="Pinterest"></li>
                    <li id="stumbleupon" class="bk-share bk_stumbleupon_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="Stumbleupon"></li>
                    <li id="linkedin" class="bk-share bk_linkedin_share" data-url="<?php print $node_url?>" data-text="Senectus elit vitae metus" data-title="Linkedin"></li>
                </ul>
            </div>
        </div>

        <div class="bk-author-box clearfix">
            <div class="bk-author-avatar"><?php if ($user_picture): ?>
            <?php print $user_picture; ?>
                    <?php else : ?>
                    <img alt='gravatar' src='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=75&#038;d=mm&#038;r=g' srcset='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=150&amp;d=mm&amp;r=g 2x' class='avatar avatar-75 photo' height='75' width='75' />
                    <?php endif; ?>
            </div>
            <div class="author-info" itemprop="author">
                <h3><?php
            if (!empty($display_name)) {
                print $display_name[0]['value'];
            } else
                print $name;
            ?></h3>
                <p class="bk-author-bio">
        <?php if (!empty($about)): ?>
                    <p><?php print $about[0]['value'] ?></p>
        <?php endif; ?></p>
                <div class="bk-author-page-contact"><a class="bk-tipper-bottom" data-title="Email" href="mailto:#"><i class="fa fa-envelope " title="Email"></i></a> <a class="bk-tipper-bottom" data-title="Website" href="" target="_blank"><i class="fa fa-globe " title="Website"></i></a> <a class="bk-tipper-bottom" data-title="Twitter" href="//www.twitter.com/#" target="_blank" ><i class="fa fa-twitter " title="Twitter"></i></a> <a class="bk-tipper-bottom" data-title="Google Plus" href="#" rel="publisher" target="_blank"><i title="Google+" class="fa fa-google-plus " ></i></a> <a class="bk-tipper-bottom" data-title="Facebook" href="#" target="_blank" ><i class="fa fa-facebook " title="Facebook"></i></a> <a class="bk-tipper-bottom" data-title="Youtube" href="http://www.youtube.com/user/#" target="_blank" ><i class="fa fa-youtube " title="Youtube"></i></a></div>
            </div>
        </div>

        <!-- close author-infor-->
        <meta itemprop="author" content="admin">
        <meta itemprop="headline " content="Gallery Post Format">
        <meta itemprop="datePublished" content="2015-01-22T07:34:31+00:00">
        <meta itemprop="image" content="images/16130335372_2c951756ec_k-.jpg">
        <meta itemprop="interactionCount" content="UserComments:0"/>
        <!-- RELATED POST -->

        <?php
            // print views_embed_view('_sensen_page_content', 'block_related_articles', $node->nid);
        ?>

        <!-- LINKS -->
        <?php // print render($content['links']); ?>

        <!-- COMMENT BOX -->
        <div class="comment-box clearfix">
            <div class="featured-box small-box icon-main-color box-none box-top-left">
                <div class="box-icon"><i class="fa fa-comments"></i></div>
                <h3 class="box-title"><?php print $comment_count; ?><?php print t(' Comments on this article. '); ?></h3>
                <div class="box-link"><?php print render($content['links']['comment']); ?></div>
            </div>

            <div class="featured-box small-box icon-main-color box-none box-top-left">
                <?php $content['field_categories']['0']['#title'] = t('See more articles like this'); ?>
                <div class="box-icon"><i class="fa fa-sitemap"></i></div>
                <p class="box-link"><?php print strip_tags(render($content['field_categories']), '<a>'); ?></p>
            </div>

            <div class="featured-box small-box icon-main-color box-none box-top-left">
                <div class="box-icon"><i class="fa fa-send"></i></div>
                <p class="box-link"><?php print strip_tags(render($content['links']['print_mail']), '<a>'); ?></p>
            </div>
        </div>

        <!-- End Comment Box -->

        <?php
    }
}
?>

