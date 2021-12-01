<h1>comment-wrapper.tpl.php</h1>
<?php if ($content['#node']->comment AND ! ($content['#node']->comment == 1 AND $content['#node']->comment_count)) { ?>
    <?php if ($node->type == "blog") { ?>

        <?php print render($content['comments']); ?>


        <div id="respond" class="comment-respond">
            <!-- <h3 id="reply-title" class="comment-reply-title">Leave a reply </h3> -->
            <?php print render($content['comment_form']); ?>
        </div><!-- end comment form -->

        <?php
    } else { ?>
        <div class="panel entry-content wc-tab" id="tab-reviews">
            <div id="reviews">
                <div id="comments">
                    <ol class="commentlist comment-list">
                       <?php print render($content['comments']); ?>
                    </ol>
                </div>
                <div id="review_form_wrapper">
                    <div id="review_form">
                        <div id="respond" class="comment-respond">
                            <h3 id="reply-title" class="comment-reply-title"><?php print t('Add a review')?> </h3>
                              <?php print render($content['comment_form']); ?>
                        </div>
                        <!-- #respond -->
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    <?php
    }
}
