<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php

$out = '';
if ($block->region == 'main_menu') {
//$out .= '<nav  class="pi-navigation '.$classes.'" '.$attributes.'>';
//$out .= render($title_suffix);
    $out .= $content;
//$out .= '</nav>';
} elseif ($block->region == 'top_menu') {
//$out .= '<nav  class="pi-navigation '.$classes.'" '.$attributes.'>';
//$out .= render($title_suffix);
    $out .= $content;
//$out .= '</nav>';
} elseif ($block->region == 'slider') {
    $out .= '<div class="' . $classes . '" ' . $attributes . '>';
    $out .= render($title_suffix);
    $out .= $content;
    $out .= '</div>';
} elseif (($block->region == 'footer_first') || ($block->region == 'footer_second') || ($block->region == 'footer_third')) {
    $out .= '<aside id="' . $block_html_id . '" class="' . $classes . '"' . $attributes . '>';
    $out .= render($title_suffix);
    if ($block->subject):
        $out .= '<div class="bk-header"><div class="widget-title"><h3>' . $block->subject . '</h3></div></div>';
    endif;
    $out .= $content;
    $out .= '</aside>';
}elseif ($block->region == 'search') {
    $out .= '<div class="' . $classes . '"' . $attributes . '>';
    $out .= render($title_suffix);
    $out .= $content;
    $out .= '</div>';
} elseif ($block->region == 'page_title_right') {
    $out .= '<div class="search ' . $classes . '"' . $attributes . '>';
    $out .= render($title_suffix);
    $out .= $content;
    $out .= '</div>';
} elseif ($block->region == 'sidebar') {
    $out .= '<aside id="' . $block_html_id . '" class="' . $classes . '"' . $attributes . '>';
    $out .= render($title_suffix);
    if ($block->subject):
        $out .='<div class="widget-title-wrap"><div class="bk-header"><div class="widget-title">';
        $out .= '<h3> ' . $block->subject . '</h3>';
        $out .= '</div></div></div>';
    endif;
    $out .= $content;
    $out .= '</aside>';
}elseif ($block->region == 'bottom_page') {
    $out .= '<div class="row ' . $classes . '" ' . $attributes . '>';
    $out .= render($title_suffix);
    $out .= $content;
    $out .= '</div>';
} elseif ($block->region == 'content') {
    $out .= '<div  id="' . $block_html_id . '" class="' . $classes . ' ' . $zebra . '"' . $attributes . '>';
    $out .= render($title_suffix);
    if ( $block->subject || !empty($block->subtitle) ):
        $out .= '<div class="module-title">';
           if ($block->subject):            
               $out .= '<h2 class="main-title"><span>' . $block->subject . '</span></h2>';
           endif;
           if (!empty($block->subtitle)):
               $out .=' <div class="sub-title">' . $block->subtitle . '</div>';
           endif;
       $out .= '</div>';
    endif;
    $out .= $content;
    $out .= '</div>';
}
elseif ($block->region == 'section') {
    $out .= '<aside  id="' . $block_html_id . '" class="' . $classes . '"' . $attributes . '>';
    $out .= render($title_suffix);
    $out .= '<div class="module-title">';
    if ($block->subject):
        $out .= '<h2 class="main-title"><span>' . $block->subject . '</span></h2>';
    endif;
    if (!empty($block->subtitle)):
        $out .=' <div class="sub-title">' . $block->subtitle . '</div>';
    endif;
    $out .= '</div>';
    $out .= $content;
    $out .= '</aside>';
}
else {
    // $out .= '<div  id="' . $block_html_id . '" class="' . $classes . '"' . $attributes . '>';
    // $out .= render($title_suffix);
    // $out .= $content;
    // $out .= '</div>';
    $out .= '<aside id="' . $block_html_id . '" class="' . $classes . ' ' . $zebra . '"' . $attributes . '>';
    $out .= render($title_suffix);
    if ($block->subject):
        $out .='<div class="widget-title-wrap"><div class="bk-header"><div class="widget-title">';
        $out .= '<h3> ' . $block->subject . '</h3>';
        $out .= '</div></div></div>';
    endif;
    $out .= $content;
    $out .= '</aside>';
}

print $out;