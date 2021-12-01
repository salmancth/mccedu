<?php
global $base_root, $base_url;

//$user = ($node->uid); // Make sure the user object is fully loaded

if (isset($node->field_image) && !empty($node->field_image)) {
    $imageone = $node->field_image['und'][0]['uri'];
    $uri = $node->field_image['und'][0]['uri'];
    $url_image = file_create_url($uri);
} else {
    $imageone = '';
}


if (isset($node->field_sidebar['und'][0]['value'])) {
    $sidebar = $node->field_sidebar['und'][0]['value'];
} else {
    $sidebar = theme_get_setting('sidebar_style', 'sensen');
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


if (isset($node->field_categories['und'][0]['value'])) {
    $categories = $node->field_categories['und'][0]['value'];
} else {
    $categories = '';
}

//$url = file_create_url($node->field_image['und'][0]['uri']);
//$node_type = $node->type;

?>

<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/mobilemenu.tpl.php'); ?>

<div id="page-inner-wrap">
    <div class="page-cover mobile-menu-close"></div>
    <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/header.tpl.php'); ?>
    <?php if ($breadcrumb): ?>
        <?php print $breadcrumb; ?>
    <?php endif; ?>

    <!-- backtop open -->
    <div id="back-top"><i class="fa fa-long-arrow-up"></i></div>

    <!-- backtop close -->

    <?php

    if (arg(0) == "node") {
//        print $sidebar;
        ?>
        <div class="single-page" itemscope itemtype="http://schema.org/Article">
            <?php
            if ($header_style == "fullwidth") {
                if ((isset($node->field_youtube) && !empty($node->field_youtube)) || (isset($node->field_vimeo) && !empty($node->field_vimeo)) || (isset($node->field_audio) && !empty($node->field_audio))) {
                    ?>
                    <header id="bk-parallax-feat" class="clearfix">
                        <?php if ($audio_video_style == "popup") {
                            ?>
                            <div class="s-feat-img"  style="background-image: url(<?php print $url_image; ?>)"></div>
                            <?php if (isset($node->field_youtube) && !empty($node->field_youtube)) { ?>
                                <?php //print_r($node->field_youtube)."<pre/>";      ?>
                                <div class="icon-play"><a class="video-popup-link" href=" <?php print $node->field_youtube["und"][0]["video_url"]; ?>"><i class="fa fa-play-circle"></i></a></div>
                            <?php } elseif (isset($node->field_vimeo) && !empty($node->field_vimeo)) { ?>
                                <div class="icon-play"><a class="video-popup-link" href=" <?php print $node->field_vimeo["und"][0]["video_url"]; ?>"><i class="fa fa-play-circle"></i></a></div>
                            <?php } elseif (isset($node->field_audio) && !empty($node->field_audio)) { ?>
                                <?php $audio_url = $node->field_audio['und'][0]['url']; ?>
                                <div class="icon-play"><a class="img-popup-link mfp-iframe audio" href="<?php print 'https://w.soundcloud.com/player/?visual=true&url=' . $audio_url . '&show_artwork=true&maxwidth=1200&maxheight=1000' ?>"><i class="fa fa-volume-up"></i></a></div>
                                <?php
                            }
                            ?>
                            <!-- End embed-video -->
                        <?php } else { ?>

                            <?php // $url = file_create_url($node->field_image['und'][0]['uri']); ?>
                                                            <div class="s-feat-img"  style="background-image: url(<?php print $url_image; ?>)"></div>                                                                                                                      <!--<iframe width="1050" height="591" src="http://www.youtube.com/embed/Z9a4PvzlqoQ"  ></iframe>-->
                            <?php

                            if (isset($node->field_youtube) && !empty($node->field_youtube)) {

                                $youtube = field_view_field('node', $node, 'field_youtube');

                                ?>

                                <div class="bk-embed-video"><div class="bk-frame-wrap"> <?php print render($youtube); ?></div></div>

                                <?php

                            } elseif (isset($node->field_vimeo) && !empty($node->field_vimeo)) {

                                $vimeo = field_view_field('node', $node, 'field_vimeo');

                                ?>

                                <div class="bk-embed-video"><div class="bk-frame-wrap">    <?php print render($vimeo); ?></div></div>



                            <?php } elseif (isset($node->field_audio) && !empty($node->field_audio)) { ?>

                                <div class="bk-embed-audio">

                                    <div class="bk-frame-wrap">

                                        <!--<iframe width="1200" height="400" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?visual=true&url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F176335781&show_artwork=true&maxwidth=1200&maxheight=1000"></iframe>-->

                                        <?php

                                        $audio_url = $node->field_audio['und'][0]['url'];

                                        // $video = field_view_field('node', $node, 'field_audio');

                                        print '<iframe width="1200" height="400" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?visual=true&url=' . $audio_url . '&show_artwork=true&maxwidth=1200&maxheight=1000"></iframe>';

                                        ?>

                                    </div>

                                </div>

                                <?php

                                //print render($video);

                            }

                            ?>





                            <!-- End embed-video -->



                            <?php

                        }

                    } else {

                        if (($image_style == "parallax") || ($image_style == "gallery")) {

                            ?>

                            <header id="bk-fw-feat" class="clearfix">

                                <div class="s-feat-img"  style="background-image: url(<?php print $url_image; ?>)"></div>

                                <div class="icon-play zoomer"><a class="img-popup-link" href="<?php print $url_image; ?>"><i class="fa fa-camera"></i></a></div>



                            <?php } else {

                                ?>

                                <header id="bk-fw-feat" class="clearfix">

                                    <div class="s-feat-img" style="background-image: url(<?php print $url_image; ?>)"></div>

                                    <?php

                                }

                            }

                            ?>

                            <div class="s_header_wraper">

                                <div class="s-post-header container">

                                    <h1 itemprop="headline"><?php print $title; ?></h1>

                                    <div class="meta">

                                        <div class="post-category"><a href="<?php  //print $node_url ?>"><?php print ($node->field_categories['und'][0]['taxonomy_term']->name);?></a></div>

                                        <div class="post-date" itemprop="datePublished"><?php print format_date($node->created, 'custom', 'M d Y'); ?></div>

                                        <div class="post-author" itemprop="author"><?php print t("by") ?> <?php print $node->name; ?></div>

                                    </div>

                                </div>

                            </div>

                        </header>

                        <?php

                    }

                    ?>

                    <!--*         * *********************************        end full width  ************************************-->



                    <?php if ($sidebar == 'right') { ?>

                        <div class="article-wrap bkwrapper container">

                            <div class="row bk-in-single-page bksection">

                                <div class="main col-md-8">



                                    <?php if ($page['content']): ?>

                                        <?php

                                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                            print render($tabs);

                                        endif;

                                        print $messages;

                                        ?>

                                        <?php print render($page['content']) ?>

                                    <?php endif; ?>

                                </div>

                                <?php

                                if (theme_get_setting('disable_recommend_box', 'sensen') == "on") {

                                    print views_embed_view('_sensen_page_content', 'block_recommend_box');

                                }

                                ?>

                                <!--recommend-box --> <!-- Sidebar -->



                                <div class='sidebar col-md-4'>

                                    <aside class="sidebar-wrap stick" id="bk_sidebar_2">

                                        <?php if ($page['sidebar']): ?>

                                            <?php print render($page['sidebar']) ?>

                                        <?php endif; ?>

                                    </aside>

                                </div>

                            </div>

                        </div>





                    <?php }elseif ($sidebar == 'left') { ?>

                        <div class="article-wrap bkwrapper container">

                            <div class="row bk-in-single-page bksection">



                                        <?php if ($page['sidebar']): ?>

                                <div class='sidebar col-md-4'>

                                    <aside class="sidebar-wrap stick" id="bk_sidebar_2">

                                            <?php print render($page['sidebar']) ?>

                                         </aside>

                                </div>

                                        <?php endif; ?>



                                <?php

                                if (theme_get_setting('disable_recommend_box', 'sensen') == "on") {

                                    print views_embed_view('_sensen_page_content', 'block_recommend_box');

                                }

                                ?>

                                <!--recommend-box --> <!-- Sidebar -->





                                    <?php if ($page['content']): ?>

                                <div class="main col-md-8">

                                        <?php

                                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                            print render($tabs);

                                        endif;

                                        print $messages;

                                        ?>

                                        <?php print render($page['content']) ?>

                                    <?php endif; ?>

                                </div>





                            </div>

                        </div>





                    <?php }else { ?>

                      <div class="article-wrap bkwrapper container">

                            <div class="row bk-in-single-page bksection">



                                    <?php if ($page['content']): ?>

                                <div class="main col-md-12">

                                        <?php

                                        if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                            print render($tabs);

                                        endif;

                                        print $messages;

                                        ?>

                                        <?php print render($page['content']) ?>

                                    </div>

                                    <?php endif; ?>



 <?php

                                if (theme_get_setting('disable_recommend_box', 'sensen') == "on") {

                                    print views_embed_view('_sensen_page_content', 'block_recommend_box');

                                }

                                ?>



                            </div>

                        </div>

                    <?php } ?>

                    </div>

                <?php } else { ?>      <!--blog list-->



                    <?php

                    if (theme_get_setting('blog_style', 'sensen') == "masonryblog") {

                        $adddclassdiv = "bk-masonry";

                        $adddclassul = "bk-masonry-content";

                    } else {





                        if (theme_get_setting('blog_style', 'sensen') == "largeblog") {

                            $adddclassdiv = "module-large-blog module-blog";

                        } elseif (theme_get_setting('blog_style', 'sensen') == "classblog") {

                            $adddclassdiv = "module-classic-blog module-blog";

                        } elseif (theme_get_setting('blog_style', 'sensen') == "squaregridblog") {

                            $adddclassdiv = "module-large-blog module-blog";

                        } else {

                            $adddclassdiv = "module-large-blog module-blog";

                        }

                        $adddclassul = "bk-blog-content";

                    }

                    ?>

                    <div id="body-wrapper" class="wp-page">

                        <div class="module-title bkwrapper container">

                            <h2 class="heading"><span><?php print $title ?></span></h2>



                        </div>





                        <?php if ($page['header']): ?>

                            <?php print render($page['header']) ?>

                        <?php endif; ?>



                        <div class="bkwrapper container">



                            <?php

                            if (theme_get_setting('sidebar_style', 'sensen') == "right") {// chu y

                                ?>

                                <div class="row bksection">

                                    <div class="bk-category-content bkpage-content col-md-8 has-sb">

                                        <div class="row">

                                            <div id="main-content" class="clear-fix" role="main">

                                                <div class="content-wrap <?php print $adddclassdiv ?>">

                                                    <ul class="<?php print $adddclassul ?> clearfix">



                                                        <?php if ($page['content']): ?>



                                                            <?php

                                                            if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                                                print render($tabs);

                                                            endif;

                                                            print $messages;

                                                            ?>

                                                            <?php print render($page['content']) ?>



                                                        <?php endif; ?>

                                                    </ul>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div class='sidebar col-md-4'>



                                        <aside class="sidebar-wrap stick" id="bk_sidebar_2">

                                            <!--        sidebar right-->

                                            <?php if ($page['sidebar']): ?>

                                                <?php print render($page['sidebar']) ?>

                                            <?php endif; ?>

                                        </aside>

                                    </div>



                                </div>

                                <?php

                            } elseif (theme_get_setting('sidebar_style', 'sensen') == "left") {

                                ?>

                                <div class="row bksection">

                                    <div class='sidebar col-md-4'>



                                        <aside class="sidebar-wrap stick" id="bk_sidebar_2">

                                            <!--        sidebar right-->

                                            <?php if ($page['sidebar']): ?>

                                                <?php print render($page['sidebar']) ?>

                                            <?php endif; ?>

                                        </aside>

                                    </div>

                                    <div class="bk-category-content bkpage-content col-md-8 has-sb">

                                        <div class="row">

                                            <div id="main-content" class="clear-fix" role="main">

                                                <div class="content-wrap <?php print $adddclassdiv ?>">

                                                    <ul class="<?php print $adddclassul ?> clearfix">



                                                        <?php if ($page['content']): ?>



                                                            <?php

                                                            if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                                                print render($tabs);

                                                            endif;

                                                            print $messages;

                                                            ?>

                                                            <?php print render($page['content']) ?>



                                                        <?php endif; ?>

                                                    </ul>

                                                </div>

                                            </div>

                                        </div>

                                    </div>





                                </div>

                            <?php }else {

                                ?>

                                <div class="row bksection">

                                    <div class="bk-category-content bkpage-content col-md-12 fullwidth">

                                        <div class="row">

                                            <div id="main-content" class="clear-fix" role="main">

                                                <div class="content-wrap <?php print $adddclassdiv ?>">

                                                    <ul class="<?php print $adddclassul ?> clearfix">



                                                        <?php if ($page['content']): ?>



                                                            <?php

                                                            if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):

                                                                print render($tabs);

                                                            endif;

                                                            print $messages;

                                                            ?>

                                                            <?php print render($page['content']) ?>



                                                        <?php endif; ?>

                                                    </ul>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                </div> <?php } ?>

                        </div>

                    </div>



                <?php } ?>

                <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/footer.tpl.php'); ?>

                </div>

                <!-- Close Page inner Wrap -->

