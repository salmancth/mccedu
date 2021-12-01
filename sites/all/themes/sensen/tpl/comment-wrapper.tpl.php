<?php if ($content['#node']->comment AND ! ($content['#node']->comment == 1 AND $content['#node']->comment_count)) { ?>
        <?php // print render($content['comments']); ?>
        <div id="respond" class="comment-respond">
            <!-- <h3 id="reply-title" class="comment-reply-title">Leave a reply </h3> -->
            <?php print render($content['comment_form']); ?>
        </div><!-- end comment form -->

<?php } ?>
