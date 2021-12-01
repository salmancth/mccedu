<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
$path_alias = drupal_get_path_alias() ;
$get = $_GET;

if ($path_alias == 'comments2' && isset($get['date_filter'])) {
    // http://edhat_pantheon.local/comments2?date_filter[value][date]=Friday, April 15, 2016
    $next_day = strtotime($get['date_filter']['value']['date']);
    $today = $next_day = date('Y-m-d',$next_day);
    // $next_day = strtotime($next_day. "+1 day");
    $prev_day = date('l, F d, Y',strtotime($next_day . "-1 days"));
    $next_day = date('l, F d, Y',strtotime($next_day . "+1 days"));
    // print $next_day; 
}


?>

<?php if ( ($path_alias == 'comments2' || $path_alias == 'comments') && isset($get['date_filter'])) { ?>
<div class="comments-help-text">
    Subscriber Comments for  <?php print l(' All Local News', 'news', array('attributes'=>array('title'=>'View all local news'))); ?>  <br/>
    Currently displaying comments for the day : - <?php print date('l, F d, Y',strtotime($today)); ?>
</div>
<div class="comments-day-wrapper mt-md"> 
    <span class="field-label">Show Comments for : </span>   
    <span class="comment-prev-day">
        <?php print l('Previous Day', 'comments2', array('query' =>array('date_filter[value][date]'=>$prev_day),'attributes'=>array('title'=>'Comments Previous Day'))); ?>
        <span class="box-icon"><i class="fa fa-sort-<?php print $order;?>"></i></span>
    </span>

    <span class="seperator"> | </span>
    <span class="comment-next-day">
        <?php print l('Next Day', 'comments2', array('query' =>array('date_filter[value][date]'=>$next_day),'attributes'=>array('title'=>'Comments Next Day '))); ?>
        <span class="box-icon"><i class="fa fa-sort-<?php print $order;?>"></i></span>
    </span>    
</div>
<?php } ?>

<div class="comment-search-box">
  <?php 
    $block = module_invoke('views','block_view','-exp-comments-page_comments');
    print render($block['content']);
  ?>
</div>

<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>