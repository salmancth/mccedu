<?php

function sensen_settings_form_submit(&$form, $form_state) {
    $image_fid = $form_state['values']['header_banner'];
    $image_fid2 = $form_state['values']['background_image'];

    $image1 = file_load($image_fid);
    $image2 = file_load($image_fid2);


    if (is_object($image1)) {
// Check to make sure that the file is set to be permanent.
        if ($image1->status == 0) {
// Update the status.
            $image1->status = FILE_STATUS_PERMANENT;
// Save the update.
            file_save($image1);
// Add a reference to prevent warnings.
            file_usage_add($image1, 'sensen', 'theme', 1);
        }
    }

    if (is_object($image2)) {
        // Check to make sure that the file is set to be permanent.
        if ($image2->status == 0) {
            // Update the status.
            $image2->status = FILE_STATUS_PERMANENT;
            // Save the update.
            file_save($image2);
            // Add a reference to prevent warnings.
            file_usage_add($image2, 'sensen', 'theme', 1);
        }
    }
}

function sensen_form_system_theme_settings_alter(&$form, &$form_state) {

    $theme_path = drupal_get_path('theme', 'sensen');


    $form['#submit'][] = 'sensen_settings_form_submit';
// Get all themes.
    $themes = list_themes();
// Get the current theme
    $active_theme = $GLOBALS['theme_key'];
    $form_state['build_info']['files'][] = str_replace("/$active_theme.info", '', $themes[$active_theme]->filename) . '/theme-settings.php';

    $theme_path = drupal_get_path('theme', 'sensen');

    $form['settings'] = array(
        '#type' => 'vertical_tabs',
        '#title' => t('Theme settings'),
        '#weight' => 2,
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
        '#attached' => array(
            'css' => array(drupal_get_path('theme', 'sensen') . '/css/drupalet_base/admin.css'),
            'js' => array(
                drupal_get_path('theme', 'sensen') . '/js/drupalet_admin/admin.js',
            ),
        ),
    );

    $form['settings']['general_setting'] = array(
        '#type' => 'fieldset',
        '#title' => t('General Settings'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );
    $form['settings']['general_setting']['general_setting_tracking_code'] = array(
        '#type' => 'textarea',
        '#title' => t('Tracking Code'),
        '#default_value' => theme_get_setting('general_setting_tracking_code', 'sensen'),
    );
    $form['settings']['general_setting']['sidebar_sticky'] = array(
        '#type' => 'checkbox',
        '#title' => t('Sticky Sidebar'),
        '#description' => t('Sidebar will be sticky if user scroll down'),
        '#default_value' => theme_get_setting('sidebar_sticky', 'sensen'),
    );
    $form['settings']['custom_css'] = array(
        '#type' => 'fieldset',
        '#title' => t('Custom CSS'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );
    $form['settings']['custom_css']['custom_css'] = array(
        '#type' => 'textarea',
        '#title' => t('Custom CSS'),
        '#default_value' => theme_get_setting('custom_css', 'sensen'),
        '#description' => t('<strong>Example:</strong><br/>h1 { font-family: \'Metrophobic\', Arial, serif; font-weight: 400; }')
    );
    $form['settings']['background'] = array(
        '#type' => 'fieldset',
        '#title' => t('Background image'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );
    $form['settings']['background']['background_image'] = array(
        '#title' => t('Background image'),
        '#type' => 'managed_file',
        '#required' => FALSE,
        '#upload_location' => 'public://bg-image/',
        '#default_value' => theme_get_setting('background_image', 'sensen'),
    );


////    switcher style
    $form['settings']['switcher'] = array(
        '#type' => 'fieldset',
        '#title' => t('Switcher style'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );

    $form['settings']['switcher']['disable_switch'] = array(
        '#title' => t('Switcher style'),
        '#type' => 'select',
        '#options' => array('on' => t('ON'), 'off' => t('OFF')),
        '#default_value' => theme_get_setting('disable_switch', 'sensen'),
    );
    $form['settings']['switcher']['site_layout'] = array(
        '#title' => t('Site Layout'),
        '#type' => 'select',
        '#options' => array(
            'wide' => t('Wide'),
            'boxed' => t('Boxed'),
        ),
        '#default_value' => theme_get_setting('site_layout', 'sensen')
    );

    $form['settings']['switcher']['logo_position'] = array(
        '#title' => t('Logo Position'),
        '#type' => 'select',
        '#options' => array(
            'leftlogo' => t('Left logo'),
            'centerlogo' => t('Center logo'),),
        '#default_value' => theme_get_setting('logo_position', 'sensen')
    );

    $form['settings']['switcher']['menu_scheme'] = array(
        '#title' => t('Menu Scheme'),
        '#type' => 'select',
        '#options' => array(
            'darkmenu' => t('Dark Menu'),
            'lightmenu' => t('Light Menu'),),
        '#default_value' => theme_get_setting('menu_scheme', 'sensen')
    );

    $form['settings']['switcher']['primary_color'] = array(
        '#title' => t('Primary Color'),
        '#type' => 'radios',
        '#options' => array(
            '1.css' => t('#FF6600'),
            '2.css' => t('#00FA00'),
            '3.css' => t('#F9B281'),
            '4.css' => t('#53B7F9'),
            'default.css' => t('Default'),),
        '#default_value' => theme_get_setting('primary_color', 'sensen')
    );


////   end switcher style  
//
    $form['settings']['header'] = array(
        '#type' => 'fieldset',
        '#title' => t('Header setting'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );


    $form['settings']['header']['header_social'] = array(
        '#title' => t('Header social'),
        '#type' => 'textarea',
        '#default_value' => theme_get_setting('header_social', 'sensen'),
    );
    $form['settings']['header']['header_banner'] = array(
        '#title' => t('Header banner'),
        '#type' => 'managed_file',
        '#required' => FALSE,
        '#upload_location' => 'public://banner-image/',
        '#default_value' => theme_get_setting('header_banner', 'sensen'),
    );

    $form['settings']['footer'] = array(
        '#type' => 'fieldset',
        '#title' => t('Footer setting'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );


    $form['settings']['footer']['footer_copyright_message'] = array(
        '#title' => t('Footer copyright message'),
        '#type' => 'textarea',
        '#default_value' => theme_get_setting('footer_copyright_message', 'sensen'),
    );
//
////blog
    $form['settings']['blog'] = array(
        '#type' => 'fieldset',
        '#title' => t('Blog style'),
        '#collapsible' => TRUE,
        '#collapsed' => FALSE,
    );


    $form['settings']['blog']['sidebar_style'] = array(
        '#title' => t('Sidebar style'),
        '#type' => 'select',
        '#options' => array(
            'left' => t('Sidebar left'),
            'right' => t('Sidebar right'),
            'none' => t('Sidebar none'),),
        '#default_value' => theme_get_setting('sidebar_style', 'sensen'),
    );

    $form['settings']['blog']['blog_style'] = array(
        '#title' => t('Blog format'),
        '#type' => 'select',
        '#options' => array(
            'largeblog' => t('Large blog'),
            'classblog' => t('Class blog'),
            'masonryblog' => t('Masonry blog'),
            'squaregridblog' => t('Square grid'),),
        '#default_value' => theme_get_setting('blog_style', 'sensen'),
    );
    $form['settings']['blog']['disable_recommend_box'] = array(
        '#title' => t('Recommend box'),
        '#type' => 'select',
        '#options' => array('on' => t('ON'), 'off' => t('OFF')),
        '#default_value' => theme_get_setting('disable_recommend_box', 'sensen'),
    );
}
