<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="" lang="en-US">
    <!--<![endif]-->

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php print $head_title; ?></title>


        <?php print $styles; ?>
        <?php print $head; ?>
        <?php
        //Tracking code
        $tracking_code = theme_get_setting('general_setting_tracking_code', 'sensen');
        print $tracking_code;
        //Custom css
        $custom_css = theme_get_setting('custom_css', 'sensen');
        if (!empty($custom_css)):
            ?>
            <style type="text/css" media="all">
    <?php print $custom_css; ?>
            </style>
            <?php
        endif;
        ?>
            <?php print $scripts; ?>
    </head>

    <?php
    if (theme_get_setting('site_layout', 'sensen') == "wide") {
        $adddclass = 'class="wide"';
    } else {
        $adddclass = 'class="boxed"';
    }
    $bg = theme_get_setting('background_image', 'sensen');
    if (isset(file_load($bg)->uri)) {
        $url_bg = file_create_url(file_load($bg)->uri);
    } else {
        $url_bg = '';
    }
    ?>
    <body class="<?php print $classes; ?>" <?php print $attributes; ?> itemscope itemtype="http://schema.org/WebPage" data-bg="<?php print $url_bg?>">


        <div id="skip-link">
            <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
        </div>
        <div id="page-wrap" <?php print $adddclass; ?>>

            <?php print $page_top; ?><?php print $page; ?><?php print $page_bottom; ?>
        </div>
        <?php if (theme_get_setting('disable_switch', 'sensen') == "on"): ?>
            <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/style-switcher.tpl.php'); ?>
        <?php endif; ?>
        <?php //print $scripts; ?>

    </body>
</html>