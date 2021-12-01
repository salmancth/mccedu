<?php
$term = taxonomy_term_load(arg(2));

$taxonomy_sidebar = field_get_items("taxonomy_term", $term, "field_sidebar");
$taxonomy_blog_style = field_get_items("taxonomy_term", $term, "field_blog_style");
$taxonomy_blog_subtitle = field_get_items("taxonomy_term", $term, "field_subtitle");

?>

<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/mobilemenu.tpl.php'); ?>
<!-- ket thuc menu dinh trang mobile-menu-->

<div id="page-inner-wrap">
    <div class="page-cover mobile-menu-close"></div>
    <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/header.tpl.php'); ?>
    <!--backtop open -->
    <div id = "back-top"><i class = "fa fa-long-arrow-up"></i></div>
    <!--backtop close -->

        <?php if ($breadcrumb): ?>
           <?php print $breadcrumb; ?>
        <?php endif; ?>

    <?php
//    print taxonomy_get_term_name_by_id(arg(1));
    if(($term->vocabulary_machine_name)!="categories_products"){
        if ($taxonomy_blog_style[0]['value'] == "masonryblog") {
            $adddclassdiv = "bk-masonry";
            $adddclassul = "bk-masonry-content";
        } else {


            if ($taxonomy_blog_style[0]['value'] == "largeblog") {
                $adddclassdiv = "module-large-blog module-blog";
            } elseif ($taxonomy_blog_style[0]['value'] == "classblog") {
                $adddclassdiv = "module-classic-blog module-blog";
            } elseif ($taxonomy_blog_style[0]['value'] == "squaregridblog") {
                $adddclassdiv = "square-grid-2 module-square-grid";
            } else {
                $adddclassdiv = "module-large-blog module-blog";
            }
            $adddclassul = "bk-blog-content";
        }
   // if(isset($taxonomy_sidebar[0][])
    ?>
    <div id="body-wrapper" class="wp-page">
        <div class="module-title bkwrapper container">
            <h2 class="heading"><span><?php print $title ?></span></h2>
            <div class="sub-title">
                <p><?php print $taxonomy_blog_subtitle[0]['value']?></p>
            </div>
        </div>


        <?php if ($page['header']): ?>
            <?php print render($page['header']) ?>
        <?php endif; ?>

        <div class="bkwrapper container">

            <?php
            if ($taxonomy_sidebar[0]['value'] == "right") {// chu y
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
            } elseif ($taxonomy_sidebar[0]['value'] == "left") {
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
    <?php }else{?>
    <div class="page-wrap bkwrapper container">
        <div class="row bksection">
            <?php if ($page['content']): ?>
                <section class="shop-page col-md-8 col-sm-12 three-cols">
                    <ul class="products">
                    <?php
                    if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                        print render($tabs);
                    endif;
                    print $messages;
                    ?>
                    <?php print render($page['content']) ?>
                    </ul>
                </section>
            <?php endif; ?>
            <?php if ($page['sidebar']): ?>
                <div id="page-sidebar" class="sidebar col-md-4 col-sm-12">
                    <aside class="sidebar-wrap stick" id="bk-shop-sidebar">
                        <?php print render($page['sidebar']) ?>
                    </aside>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php }?>
</div>
<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/footer.tpl.php'); ?>


