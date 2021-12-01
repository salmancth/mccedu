<?php

/**
 * @file
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since last the visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 *
 * @ingroup themeable
 */
// echo '<pre>' ; print_r($content['links']); echo '</pre>';
hide($content['links']['comment']['#links']['comment-reply']);
unset($content['links']['comment']['#links']['comment-reply']);
?>



<?php if ($node->type == "blog") { ?>

    <?php // echo '<pre>';print_r($content); echo '</pre>'; ?>

    <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1 comment_style">
        <article id="comment-5" class="comment-article  media">
            <header class="comment-author clear-fix">
                <div class="comment-avatar">
                    <?php
                    if ($picture) {
                        print strip_tags($picture, '<img>');
                    } else {
                        ?>
                        <img alt='' src='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=60&#038;d=mm&#038;r=g' srcset='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=120&amp;d=mm&amp;r=g 2x' class='avatar avatar-60 photo' height='60' width='60' />
                    <?php } ?>
                </div>
                <span class="comment-flag"><?php print render($content['links']['flag']); ?></span>
                <span class="comment-author-name"><?php print strip_tags($author); ?></span>
                <span class="comment-time" datetime="2015-01-22T08:47:04+00:00"><?php print date('F d, Y h:i A',$comment->created); ?></span>
                <span class="comment-links">  <?php print strip_tags(render($content['links']), '<a>'); ?> </span>
            </header>
            <div class="comment-text">
                <section class="comment-content"><p>
                        <?php
                        hide($content['links']);
                        print strip_tags(render($content), '<a>')
                        ?>
                        <?php //print format_date($node->created, 'custom', 'F d, Y');  ?>
                    </p>
                </section></div>
        </article>
    </li>
    <div class="fissure"></div>
<?php } else { ?>
    <li itemprop="review" itemscope itemtype="http://schema.org/Review" class="comment even thread-even depth-1" id="li-comment-61">
        <div  class="comment_container">
            <?php
            if ($picture) {
                print strip_tags($picture, '<img>');
            } else {
                ?>
                <img alt='' src='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=60&#038;d=mm&#038;r=g' srcset='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=120&amp;d=mm&amp;r=g 2x' class='avatar avatar-60 photo' height='60' width='60' />

            <?php } ?>
            <div class="comment-text">
                <!--<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="Rated 4 out of 5"> <span style="width:80%"><strong itemprop="ratingValue">4</strong> out of 5</span> </div>-->
                <p class="meta"> <strong itemprop="author">
                    <?php print $author;?> </strong> &ndash;
                    <time itemprop="datePublished" datetime="2013-06-07T11:46:52+00:00"><?php print format_date($node->created, 'custom', 'F d, Y') ?></time>
                    : </p>
                <div itemprop="description" class="description">
                     <?php
                        hide($content['links']);
                        print strip_tags(render($content), '<a>')
                        ?>

                </div>
            </div>
        </div>
    </li>
<?php } ?>
<!-- end section -->
