
<?php

global $base_url;


$update_js = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array(// Set up an array of attributes inside the tag
        'href' => $base_url . '/' . path_to_theme() . "/js/update.js",
        'rel' => 'script',
        'type' => 'text/javascript',
        'id' => 'site-color',
        'data-baseurl' => $base_url . '/' . path_to_theme()
    ),
    '#weight' => 5,
);
drupal_add_html_head($update_js, "update_js");

function sensen_preprocess_html(&$variables) {
//-- Google web fonts -->
    drupal_add_css('https://fonts.googleapis.com/css?family=Oswald%3A300%2C400%2C700%7CArchivo+Narrow%3A400%2C700%2C400italic%2C700italic%7CLato%3A100%2C300%2C400%2C700%2C900%2C100italic%2C300italic%2C400italic%2C700italic%2C900italic&#038;ver=1444999490', array('type' => 'external'));
    // drupal_add_js(drupal_get_path('theme', 'sensen') . '/js/update.js',array('type' => 'external', 'id' => 'asd'));
//    drupal_add_css(drupal_get_path('theme', 'sensen') . '/css/font-awesome.min.css', array('type' => 'external', 'id' => 'asd'));
    if (!$variables['is_front']) {
        // Add unique class for each page.
        $path = drupal_get_path_alias($_GET['q']);
        $variables['classes_array'][] = get_safe_id('page-' . $path);
        // Add unique class for each website section.
        list($section, ) = explode('/', $path, 2);
        if (arg(0) == 'node') {
            if (arg(1) == 'add') {
                $section = 'node-add';
            } elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
                $section = 'node-' . arg(2);
            }
        }
        $variables['classes_array'][] = get_safe_id('section-' . $section);
    }
}

// Add css skin
$setting_skin = theme_get_setting('primary_color', 'sensen');
if (!empty($setting_skin)) {
    $skin_color = '/css/skins/' . $setting_skin;
} else {
    $skin_color = '/css/skins/default.css';
}
$css_skin = array(
    '#tag' => 'link', // The #tag is the html tag - <link />
    '#attributes' => array(// Set up an array of attributes inside the tag
        'href' => $base_url . '/' . path_to_theme() . $skin_color,
        'rel' => 'stylesheet',
        'type' => 'text/css',
        'id' => 'skins-color',
        'data-baseurl' => $base_url . '/' . path_to_theme()
    ),
    '#weight' => 4,
);
drupal_add_html_head($css_skin, 'skin');

function sensen_menu_tree(array $variables) {
    return '<ul class="menu">' . $variables['tree'] . '</ul>';
}

function sensen_menu_tree__menu_footer_menu(array $variables) {
    return '<ul class="menu-footer-menu">' . $variables['tree'] . '</ul>';
}

function sensen_menu_link(array $variables) {
    $element = $variables['element'];
    $sub_menu = '';
    if (($element['#original_link']['menu_name'] == 'main-menu')) {

        if ($element['#below'] && $element['#original_link']['depth'] >= 1) {
            unset($element['#below']['#theme_wrappers']);
            $sub_menu = '<ul class="sub-menu">' . drupal_render($element['#below']) . '</ul>';
        } elseif ($element['#below'] && $element['#original_link']['depth'] != 10) {
            $sub_menu = drupal_render($element['#below']);
        }
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    } elseif (($element['#original_link']['menu_name'] == 'menu-top-menu')) {

        if ($element['#below'] && $element['#original_link']['depth'] >= 1) {
            unset($element['#below']['#theme_wrappers']);
            $element['#attributes']['class'][] = 'menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children';
            $sub_menu = '<ul class="sub-menu">' . drupal_render($element['#below']) . '</ul>';
        } elseif ($element['#below'] && $element['#original_link']['depth'] != 10) {
            $element['#attributes']['class'][] = 'menu-item menu-item-type-custom menu-item-object-custom';
            $sub_menu = drupal_render($element['#below']);
        }
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    } else {
        if ($element['#below']) {
            $sub_menu = drupal_render($element['#below']);
        }
        $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    }

    return '<li' . drupal_attributes($element ['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function sensen_form_alter(&$form, &$form_state, $form_id) {
    if ($form_id == 'search_block_form') {
        $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
//$form['search_block_form']['#default_value'] = t(''); // Set a default value for the textfield
        $form['search_block_form']['#attributes']['id'] = array("search-form-text");
        $form['search_block_form']['#attributes']['class'] = array("field");
// $form['#atrributes']['class'][]="ajax-form";
        $form['search_block_form']['#attributes']['placeholder'] = t('Search this Site..');
//disabled submit button
//unset($form['actions']['submit']);
// unset($form['search_block_form']['submit']['#value']);
        unset($form['search_block_form']['#title']);
    }
    if ($form_id == 'webform-client-form-59') {
//        $form['mail']['#attributes']['class'] = array("input-contact-form");
//        $form['name']['#attributes']['class'] = array("input-contact-form");
//        $form['subject']['#attributes']['class'] = array("input-contact-form");
//        $form['message']['#attributes']['class'] = array("message-contact-form");
        $form['actions']['submit']['#attributes']['class'] = array('on-btn btn-style-2 text-uppercase');
        $form['#attributes']['class'][] = 'contact-form';
        print "adsadf";
    }
    if ($form_id == 'comment_form') {
        $form['comment_filter']['format'] = array(); // nuke wysiwyg from comments
    }
}

function sensen_alpha_preprocess_page(&$vars) {
    if (!empty($vars['page']['#views_contextual_links_info'])) {
        $key = array_search('contextual-links-region', $vars['attributes_array']['class']);
        if ($key !== FALSE) {
            unset($vars['attributes_array']['class'][$key]);
            // Add the JavaScript, with a group and weight such that it will run
            // before modules/contextual/contextual.js.
            drupal_add_js(drupal_get_path('module', 'views') . '/js/views-contextual.js', array('group' => JS_LIBRARY, 'weight' => -1));
        }
    }
}

function sensen_preprocess_page(&$vars) {

    if (isset($vars['node'])) {
        // $vars['comments'] = comment_render($vars['node']);
    }

    if (isset($vars['node'])) {
        $vars['theme_hook_suggestions'][] = 'page__' . $vars['node']->type;
    }
    if (!empty($variables['node']) && $variables['node']->type == 'page') {
        $variables['show_title'] = TRUE;
    }

//Taxonomy page
    if (arg(0) == 'taxonomy') {
        $vars['theme_hook_suggestions'][] = 'page__taxonomy';
    }

//View template
    if (views_get_page_view()) {
        $vars['theme_hook_suggestions'][] = 'page__view';
    }

    $font_awesome = array(
        '#tag' => 'link', // The #tag is the html tag - <link />
        '#attributes' => array(// Set up an array of attributes inside the tag
            'href' => base_path() . path_to_theme() . "/css/font-awesome.min.css",
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'id' => 'fa-css',
            'data-baseurl' => base_path() . path_to_theme()
        ),
        '#weight' => 3,
    );
    drupal_add_html_head($font_awesome, "font_awesome");
//
//     $flexslider = array(
//        '#tag' => 'link', // The #tag is the html tag - <link />
//        '#attributes' => array(// Set up an array of attributes inside the tag
//            'href' => base_path().path_to_theme() . "/css/flexslider.css",
//            'rel' => 'stylesheet',
//            'type' => 'text/css',
//            'id' => 'flexslider-css',
//            'data-baseurl' => base_path().path_to_theme()
//        ),
//        '#weight' => 2,
//    );
//    drupal_add_html_head($flexslider,"flexslider");

    drupal_add_js('jQuery.extend(Drupal.settings, { "pathToTheme": "' . base_path() . path_to_theme() . '" });', 'inline');

    // echo '<pre>';
    // print_r($vars['node']);
    // echo '</pre>';
}

function sensen_preprocess_node(&$vars) {
    unset($vars['content']['links']['statistics']['#links']['statistics_counter']['title']);
//    foreach (system_region_list($GLOBALS['theme']) as $region_key => $region_name) {
//
//        // Get the content for each region and add it to the $region variable
//        if ($blocks = block_get_blocks_by_region($region_key)) {
//            $variables['region'][$region_key] = $blocks;
//        } else {
//            $variables['region'][$region_key] = array();
//        }
//    }
//
//     if ($block_region_name = block_get_blocks_by_region('sidebar')) {
//    $vars['sidebar'] = $block_region_name;
//  }
}

//print phpinfo();
function sensen_breadcrumb($variables) {
    $crumbs = '<div class="bk-breadcrumbs-wrap bkwrapper container">'
            . '<div class="breadcrumbs">';
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        $crumbs .='<i class="fa fa-home"></i>';
        foreach ($breadcrumb as $value) {
            $crumbs .=$value . '<span class="delim">&rsaquo;</span> ';
        }
        $crumbs .=drupal_get_title();
        return $crumbs . '</div></div>';
    } else {
        return NULL;
    }
}

function sensen_preprocess_file_entity(&$variables) {
    if ($variables['type'] == 'image') {
// Alt Text
        if (!empty($variables['field_media_alt_text'])) {
            $variables['content']['filfore']['#alt'] = $variables['field_media_alt_text']['und'][0]['safe_value'];
        }
// Title
        if (!empty($variables['field_media_title'])) {
            $variables['content']['file']['#title'] = $variables['field_media_title']['und'][0]['safe_value'];
        }
    }
}

function sensen_form_comment_form_alter(&$form, &$form_state) {

    $form['comment_body']['#after_build'][] = 'sensen_customize_comment_form';
    $form['your_comment']['subject'] = $form['subject'];
    unset($form['subject']);
    $form['your_comment']['subject']['#access'] = FALSE;
    //Comment

    $form['author']['name']['#title'] = 'EDHAT Username';
    $form['author']['mail']['#title'] = 'Email';
    $form['author']['mail']['#description'] = FALSE;
    $form['author']['mail']['#access'] = TRUE;
    // $form['author']['homepage']['#title'] = 'Website';
    // $form['author']['homepage']['#access'] = TRUE;
    $form['author']['mail']['#required'] = TRUE;
    $form['author']['name']['#required'] = TRUE;
    $form["name"]["#attributes"]["#placeholder"] = array('EDHAT Username*...');
    $form['actions']['submit']['#value'] = 'Send';
    $form['actions']['submit']['#weight'] = '9';
    $form['actions']['user_register_link'] = array('#markup' => l('get a handle', 'user/register', array('attributes' => array('target' => '_blank', 'class' => 'signup-link btn-default btn-danger'))), '#weight' => 10);
    $form['actions']['forget_password_link'] = array('#markup' => l('lost a handle', 'user/password', array('attributes' => array('target' => '_blank', 'class' => 'forget-password-link btn-default'))), '#weight' => 11);
    $form['actions']['preview']['#access'] = FALSE;
}

function sensen_customize_comment_form(&$form) {
    $form[LANGUAGE_NONE][0]['format']['#access'] = FALSE;
    return $form;
}

/**
 * Implements hook_theme().
 */
function sensen_theme($existing, $type, $theme, $path) {
    $base = array(
        'render element' => 'form',
        'path' => drupal_get_path('theme', 'sensen') . '/tpl',
    );

// here array key is form_id
    return array(
        'comment_form' => $base + array(
            'template' => 'comment-form',
        ),
        'organizational_section_report_node_form' => $base + array(
            'arguments' => array(
                'form' => NULL,
            ),
            'template' => 'organizational-section-report',
        ),
        'mcc_users_profile_node_form' => array(
            'arguments' => array('form' => NULL),
            'template' => 'mcc-users-profile-node-form',
            'render element' => 'form',
            'path' => drupal_get_path('theme', 'sensen') . '/tpl',
        ),
    );
}

function sensen_comment_form(&$variables) {

    // echo '<pre>';
    // print_r($variables);
    // echo '</pre>';
    // hide($variables['form']['comment_body']['und']['0']['format']);
    // $comment_form = drupal_render_children($variables['form']);
    // $node = node_load($nid);
    // $node = $variables['form']['#node'];
    // $comments =  comment_load_multiple(comment_get_thread($node, 0, 100));
    // echo '<pre>';
    // print_r($comments);
    // echo '</pre>';
    // $comment_form = drupal_render($variables['form']);
    // $comment_form = drupal_render_children($variables['form']);
    // return $comment_form;
}

function single_navigation($ntype, $nid, $nav) {
    $current_node = node_load($nid);
    $prev_nid = db_query("SELECT n.nid FROM {node} n WHERE n.type = :type AND n.status = 1 AND n.created < :created  ORDER BY n.created DESC LIMIT 1", array(':created' => $current_node->created, ':type' => $ntype))->fetchField();

    $next_nid = db_query("SELECT n.nid FROM {node} n WHERE n.type = :type AND n.status = 1 AND n.created > :created LIMIT 1", array(':created' => $current_node->created, ':type' => $ntype))->fetchField();
    $link = '';

    if ($prev_nid > 0 && $nav == 'prev') {
        $node = node_load($prev_nid);
        $imageone = $node->field_image['und'][0]['uri'];
        $image = theme('image_style', array('path' => $imageone, 'style_name' => 'image90', 'attributes' => array('alt' => $node->title)));
        $link .= '<a href="' . url("node/" . $node->nid) . '"><span class="icon"><i class="fa fa-long-arrow-left"></i></span></a>'
                . '<div class="nav-c-wrap"><div class="thumb">' . $image . '</div>'
                . '<div class="nav-title"><span>Previous Story</span>'
                . '<h3>' . $node->title . '</h3>'
                . '</div><a class="bk-cover-link" href="' . url("node/" . $node->nid) . '"></a>'
                . '</div>';
    } elseif ($next_nid > 0 && $nav == 'next') {
        $node = node_load($next_nid);
        $imageone = $node->field_image['und'][0]['uri'];
        $image = theme('image_style', array('path' => $imageone, 'style_name' => 'image90', 'attributes' => array('alt' => $node->title)));
        $link .= '<a href="' . url("node/" . $node->nid) . '">'
                . '<span class="icon"><i class="fa fa-long-arrow-right"></i></span></a>'
                . '<div class="nav-c-wrap">'
                . '<div class="thumb">' . $image . '</div>'
                . '<div class="nav-title"><span>Next Story</span>'
                . '<h3>' . $node->title . '</h3>'
                . '</div><a class="bk-cover-link" href="' . url("node/" . $node->nid) . '"></a>'
                . '</div>';
    }

    return $link;
}

function get_safe_id($string) {
    // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
    $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
    // If the first character is not a-z, add 'n' in front.
    if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
        $string = 'id' . $string;
    }
    return $string;
}

function edhat_common_get_advertise_nodes() {
    $query = "SELECT  node.nid AS nid,node.nid AS nid
                FROM 
                {node} node
                LEFT JOIN {weight_weights} weight_weights ON node.nid = weight_weights.entity_id
                WHERE (( (node.status = '1') AND (node.type IN  ('advertisers')) ))
                ORDER BY weight_weights.weight ASC
                LIMIT 20 OFFSET 0";

    // Get an associative array of nids to titles.
    $nodes = db_query($query)->fetchAllKeyed();
    $advertise_nodes = array_values($nodes);
    $random_num = mt_rand(0, count($advertise_nodes) - 1);
    $advertise_nid = $advertise_nodes[$random_num];
    $advertise_node = node_load($advertise_nid);
    $img_link = file_create_url($advertise_node->field_image_single[LANGUAGE_NONE][0]['uri']);

    if (empty($advertise_node->field_link)) {
        $advertise_node_link = drupal_get_path_alias('node/' . $advertise_node->nid);
    } else {
        $advertise_node_link = $advertise_node->field_link[LANGUAGE_NONE][0]['url'];
    }

    return '<a title="<?php print $advertise_node->title;?>" target="_blank" href="<?php print $advertise_node_link;?>"><img src="<?php print $img_link;?>" alt="<?php print $advertise_node->title;?>"></a>';
    // foreach ($nodes as $nid => $title) {        
    //     $node = node_load($nid);
    //     $advertise_nodes[] = node_load($nid);
    //     $img_link = file_create_url($node->field_image_single[LANGUAGE_NONE][0]['uri']);
    // }
    // echo '$random_num: ' ;
    // echo '<pre>'; print_r($advertise_node_link); echo '</pre>';
    // return $nodes;
}
