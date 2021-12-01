<?php

if (isset($node->field_sidebar) && !empty($node->field_sidebar)) {
    $sidebar = $node->field_sidebar['und'][0]['value'];
} else $sidebar = 'right';


$sidebar_left = $sidebar_right = 'col col-md-3';
$main_content = 'col col-md-6';

if ($page['sidebar_left'] || $page['sidebar_right']) {
    $main_content = 'col col-md-9';
}

if (empty($page['sidebar_left']) && empty($page['sidebar_right'])) {
    $main_content = 'col col-md-12';
}

$term = taxonomy_term_load(arg(2));

$taxonomy_sidebar = field_get_items("taxonomy_term", $term, "field_sidebar");
$taxonomy_blog_style = field_get_items("taxonomy_term", $term, "field_blog_style");
$taxonomy_blog_subtitle = field_get_items("taxonomy_term", $term, "field_subtitle");
$sticky_sidebar = theme_get_setting('sidebar_sticky', 'sensen');
?>


<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/mobilemenu.tpl.php'); ?>
<!-- ket thuc menu dinh trang mobile-menu-->


<div id="page-inner-wrap">

    <div class="page-cover mobile-menu-close"></div>
    <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/header.tpl.php'); ?>
    <!--backtop open -->
    <div id = "back-top"><i class = "fa fa-long-arrow-up"></i></div>
    <!--backtop close -->


    <?php if ($page['before_content_full']): ?>
        <div class="before-content-full" id="before-content-full">
            <?php print render($page['before_content_full']); ?>           
        </div>
    <?php endif; ?>

    <?php if ($page['before_content']): ?>
        <div class="before-content" id="before-content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <?php print render($page['before_content']); ?>
                    </div>
                </div>
            </div>            
        </div>
    <?php endif; ?>


    <div id = "page-content-wrap">
        <div class="has-sb container bkwrapper bksection">
            <div class="row">
                <?php if ($page['sidebar_left']): ?>
                    <div class="sidebar sidebar-left <?php print $sidebar_left;?>">
                        <aside class="sidebar-wrap <?php if ($sticky_sidebar) {print ' stick';} ?>" id="bk_sidebar_1">
                            <?php print render($page['sidebar_left']); ?>
                        </aside>
                    </div>
                <?php endif; ?>

                <!-- main content -->
             
                <div class="content-wrap  module-classic-blog module-blog has-sb <?php print $main_content;?>">

                    <?php
                    if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                        print render($tabs);
                    endif;
                    print $messages;
                    ?>

                    <?php if ($page['content_top_left'] || $page['content_top_right']): ?>
                        <div class="content-top" id="content-top">
                                <div class="row">
                                    <div class="col <?php if ($page['content_top_right']) {print 'col-md-9 content-top-left';} else {print 'col-md-12';} ?>">
                                        <?php print render($page['content_top_left']); ?>
                                    </div>

                                    <?php if ($page['content_top_right']): ?>
                                    <div class="col col-md-3 col-top-right">
                                        <?php print render($page['content_top_right']); ?>
                                    </div>    
                                    <?php endif; ?>   
                                </div>           
                        </div>
                    <?php endif; ?>

                    <div class="module-title">
                        <h2 class="heading"><span><?php print $title ?></span></h2>
                        <div class="sub-title">
                            <p><?php print $taxonomy_blog_subtitle[0]['value']?></p>
                        </div>
                    </div>

                    <?php if ($page['content']): ?>
                        <div class="bk-category-content bkpage-content">
                            <div id="main-content" class="clear-fix" role="main">
                                <ul class="bk-blog-content row clearfix">
                                    <?php print render($page['content']); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>                    


                    <?php if ($page['content_bottom_left'] || $page['content_bottom_right']): ?>
                        <div class="content-bottom" id="content-bottom">
                                <div class="row">
                                    <div class="col <?php if ($page['content_bottom_right']) {print 'col-md-9 content-bottom-left';} else {print 'col-md-12';} ?>">
                                        <?php print render($page['content_bottom_left']); ?>
                                    </div>

                                    <?php if ($page['content_bottom_right']): ?>
                                    <div class="col col-md-3 col-bottom-right">
                                        <?php print render($page['content_bottom_right']); ?>
                                    </div> 
                                    <?php endif; ?>   
                                </div>          
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($page['sidebar_right']): ?>
                    <div class="sidebar sidebar-right <?php print $sidebar_right;?>">
                        <aside class="sidebar-wrap <?php if ($sticky_sidebar) {print ' stick';} ?>" id="bk_sidebar_2">
                            <?php print render($page['sidebar_right']); ?>
                        </aside>
                    </div>
                <?php endif; ?>
            </div> <!-- // row -->
        </div>
    </div>    

    <?php if ($page['after_content']): ?>
        <div class="after-content" id="after-content">
            <div class="container">
                <div class="row">
                    <div class="col col-md-12">
                        <?php print render($page['after_content']); ?>
                    </div>
                </div>
            </div>            
        </div>
    <?php endif; ?>

    <?php if ($page['after_content_full']): ?>
        <div class="after-content-full" id="after-content-full">
            <?php print render($page['after_content_full']); ?>           
        </div>
    <?php endif; ?>

</div> <!-- // page-inner-wrap -->

<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/footer.tpl.php'); ?>