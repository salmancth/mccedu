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

<?php  // echo '<pre>';print_r($comment); echo '</pre>'; ?>

<li class="<?php print $classes; ?> even thread-even depth-1 comment_style ">
    <article id="comment-<?php print $comment->cid; ?>" class="comment-article  media">
        <header class="comment-author clear-fix">
            <div class="comment-avatar">
                <?php
                if(isset($content['comment_body']['#object']->uid) && 0 != $content['comment_body']['#object']->uid) {
                    if (function_exists('edhat_common_user_has_role')){
                        if(edhat_common_user_has_role('administrator')) {
                            if ($picture) {
                                print strip_tags($picture, '<img>');
                            } else {
                                ?>
                                <img alt='' src='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=60&#038;d=mm&#038;r=g' srcset='http://0.gravatar.com/avatar/662a272c8be177be19f47db7acac0cb9?s=120&amp;d=mm&amp;r=g 2x' class='avatar avatar-60 photo' height='60' width='60' />
                            <?php }
                        }
                    }
                }
                ?>
            </div>

            <?php if (render($content['links']['flag'])): ?>
                <span class="comment-flag"><?php print render($content['links']['flag']); ?></span>
            <?php else: ?>
                <span class="comment-flag">
                    <ul class="links inline"><li class="flag-agree first"><span><span class="flag-wrapper flag-agree flag-agree-48">
                          <a href="javascript:alert('SORRY, You must be LOGGED IN to use this feature');" title="I agree with this comment" class="flag flag-action" rel="nofollow"><i class="fa fa-check-square-o"></i></a><span class="flag-throbber">&nbsp;</span>
                        </span>
                    </span></li>
                        <li class="flag-helpful"><span><span class="flag-wrapper flag-helpful flag-helpful-48">
                          <a href="javascript:alert('SORRY, You must be LOGGED IN to use this feature');" title="I found this comment to be helpful" class="flag flag-action" rel="nofollow"><i class="fa fa-heart-o"></i></a><span class="flag-throbber">&nbsp;</span>
                        </span>
                    </span></li>
                        <li class="flag-negative"><span><span class="flag-wrapper flag-negative flag-negative-48">
                          <a href="javascript:alert('SORRY, You must be LOGGED IN to use this feature');" title="This comment is negative and it should be removed from this thread" class="flag flag-action" rel="nofollow"><i class="fa fa-minus-square-o"></i></a><span class="flag-throbber">&nbsp;</span>
                        </span>
                    </span></li>
                        <li class="flag-off_topic last"><span><span class="flag-wrapper flag-off-topic flag-off-topic-48">
                          <a href="javascript:alert('SORRY, You must be LOGGED IN to use this feature');" title="This comment is off topic. It should be removed." class="flag flag-action" rel="nofollow"><i class="fa fa-circle-o"></i></a><span class="flag-throbber">&nbsp;</span>
                        </span>
                    </span></li>
                    </ul>
                </span>
            <?php endif; ?>

            <span class="comment-author-name"><?php print strip_tags($author); ?></span>
            <span class="comment-meta<?php if (render($content['links'])) {print ' comment-meta-links';}else {print ' comment-meta-without-links';} ?>">
                <span class="comment-time" datetime="2015-01-22T08:47:04+00:00"><?php print date('F d, Y h:i A',$comment->created); ?></span>
            </span>
            <?php if(render($content['links'])): ?>
                <span class="comment-links">  <?php print strip_tags(render($content['links']), '<a>'); ?> </span>
            <?php endif; ?>
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
