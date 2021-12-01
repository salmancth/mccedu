<?php
global $base_url;
if (theme_get_setting('logo_position', 'sensen') == "leftlogo")
    $adddclass = '';
else {
    $adddclass = 'header-center';
}
if (theme_get_setting('menu_scheme', 'sensen') == "darkmenu") {
    $addclass_menu = "";
} else {
    $addclass_menu = "bk-menu-light";
}
?>

<div class="bk-page-header">
    <div class="header-wrap">
        <div class="top-bar <?php print $addclass_menu; ?>">
            <div class="bkwrapper container">
                <div class="top-nav clearfix">
                    
                    <div id="top-menu" class="menu-top-menu-container">
                        <?php if ($page['top_menu']): ?>
                            <!-- Navigation start //-->
                            <?php print render($page['top_menu']); ?>
                            <!-- Navigation end //-->
                        <?php endif; ?>
                    </div>

                    <!--  shopping-cart -->
                    <div class="bk_small_cart"> 
                        <?php if ($page['shopping_cart']): ?>

                            <a class="cart-contents" href="" title="View your shopping cart"><i class="fa fa-shopping-cart"></i></a>
                            <div id="bk_small_cart_widget">
                                <aside id="" class="widget woocommerce widget_shopping_cart">
                                    <h3 class="widget-title"><?php print t('Cart')?></h3>
                                    <?php print render($page['shopping_cart']) ?>
                                </aside>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- end shopping-cart -->

                    <!-- social-->
                    <div class="header-social">
                        <ul class="clearfix">
                            <?php print theme_get_setting('header_social', 'sensen') ?>
                        </ul>
                    </div>
                    <!-- end social -->

                </div>
                <!--top-nav-->
                
            </div>
        </div>

        <!--top-bar-->

        <div class="header container">
            <div class="header-inner <?php print $adddclass; ?>"> 
                <div class="row">
                    <div class="logo-and-slogan col col-md-12 col-sm-12">                                            
                        <!-- logo open -->
                        <?php if ($logo): ?>
                            <div class="logo"> <a href="<?php print base_path(); ?>" ><img src="<?php print $logo; ?>" alt="<?php print $site_name; ?>"/> </a> </div>
                        <?php endif; ?>
                        <!-- logo close --> 

                      <?php if ($site_name || $site_slogan): ?>
                        <div id="name-and-slogan">
                          <?php if ($site_name): ?>
                            <?php if ($title): ?>
                              <div id="site-name"><strong>
                                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                              </strong></div>
                            <?php else: /* Use h1 when the content title is empty */ ?>
                              <h1 id="site-name">
                                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                              </h1>
                            <?php endif; ?>
                          <?php endif; ?>

                          <?php if ($site_slogan): ?>
                            <div id="site-slogan"><?php print $site_slogan; ?></div>
                          <?php endif; ?>
                        </div> <!-- /#name-and-slogan -->
                      <?php endif; ?>
                    </div>

                    <!-- header-banner open -->
                    <!--<div class="header-banner col col-md-8 col-sm-7">--> 
                        <!-- Header advertise -->
                        <?php //if ($page['header_advertise']): ?>
                            <!--<div class="header-advertise" id="header-advertise">-->
                                <?php //print render($page['header_advertise']); ?>
                            <!--</div>-->
                        <?php //endif; ?>
                        <!-- Header advertise -->
                        
                    <!--</div>-->
                    <!-- header-banner close --> 
                </div>
            </div>
        </div>

    </div>
    <!-- nav open -->

    <nav class="main-nav <?php print $addclass_menu; ?>">
        <div class="main-nav-inner bkwrapper container">
            <div class="main-nav-container clearfix ">
                <div class="main-nav-wrap">
                    <div class="mobile-menu-wrap">
                        <h3 class="menu-title"> MCC </h3>
                        <a class="mobile-nav-btn" id="nav-open-btn"><i class="fa fa-bars"></i></a> </div>
                    <div id="main-menu" class="menu-main-menu-container">
                        <?php if ($page['main_menu']): ?>
                            <!-- Navigation start //-->
                            <?php print render($page['main_menu']); ?>
                            <!-- Navigation end //--> 
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($page["search"]): ?>
                    <div class="ajax-search-wrap">
                        <div id="ajax-form-search" class="ajax-search-icon"><i class="fa fa-search"></i></div>
                        <?php print render($page["search"]); ?>
                        <div id="ajax-search-result"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- main-nav-inner --> 
    </nav>
    <!-- nav close --> 
</div>


