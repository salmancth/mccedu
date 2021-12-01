
<?php
// To get the full url with alias for a node use it like this.
// url(drupal_get_path_alias('node/' . $node->nid));
//
    global $base_url;
    // echo '<pre>' ; print_r($form); echo '</pre>';
    $node = $form['#node'];
    $node_url = url(drupal_get_path_alias('node/' . $node->nid));
    $statistics = statistics_get($node->nid);

    // echo '<pre>' ; print_r($_GET); echo '</pre>';
    // echo '<pre>' ; print_r(drupal_get_query_parameters($query = NULL, array())); echo '</pre>';
    $order = (isset($_GET['order']) && $_GET['order'] == 'asc') ? 'desc' : 'asc';
?>
<!-- 
<div class="page-title">
    <div class="sub-title">Subscriber Comments for</div>
    <h2 class="main-title"><span><a title="" href="<?php // print $node_url;?>"><?php // print $node->title;?></a></span> </h2>
</div>
 -->

<div id="comments">
    <div class="comment-sort-wrapper">
        <div class="row">
            <div class="col col-sm-6">
                <div class="comments-count text-uppercase" itemprop="postComments "> <span title="Total Comments Count"> <i class="fa fa-comments"></i> <?php print $node->comment_count; ?> Comments | <i class="fa fa-book"></i> <?php print intval($statistics['totalcount']); ?> Readers</span> </div>
            </div>
            <div class="col col-sm-6">
                <span class="comment-sort-label">
                  <span class="box-icon"><i class="fa fa-clock-o"></i></span>  Most recent Comments first <span class="seperator"> | </span>
                </span>
                <span class="comment-sort-order">
                    <?php print l('Reverse Order', 'comment/reply/' . $node->nid, array('query' =>array('order'=>$order),'attributes'=>array('title'=>'Comment Sort by - ' . strtoupper($order)))); ?>
                    <span class="box-icon"><i class="fa fa-sort-<?php print $order;?>"></i></span>
                </span>
            </div>
        </div>
    </div>
    <ol class="commentlist comment-list">
       <?php
            if (isset($_GET['order']) && ($_GET['order'] == 'asc') ) {
                print views_embed_view('comments', 'block_comments_sorted_asc',$node->nid);
            }
            else {
                print views_embed_view('comments', 'block_comments_sorted_desc',$node->nid);
            }
        ?>
    </ol>
</div>

<div class="comment-help row">
    <div class="col col-md-5 col-sm-7 col-xs-12">
        <div class="comment-fields">
            <?php print drupal_render($form['author']); ?>
        </div>
    </div>
    <div class="col col-md-7 col-sm-5 hidden-xs">
        <div class="signup-help-text mt-lg">
            <div class="featured-box box-background box-bg-dark box-square box-left mb-none">
                <div class="box-icon"><i class="fa fa-question"></i></div>
                <p class="box-content">Don't have an Account? <br>
                    Don't know if you have an account? <br>
                    Don't remember your account info?</p>
            </div>
            <a class="btn-link" href="<?php print $base_url;?>/user/register">CLICK HERE</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col col-md-12">
        <?php print drupal_render_children($form); ?>
    </div>
</div>
