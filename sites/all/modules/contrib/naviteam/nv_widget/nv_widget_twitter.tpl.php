<?php
$twitter_username = $settings['nv_widget_twitter_username'];
$tweets_count = $settings['nv_widget_twitter_tweets_count'];
Global $base_url;
?>

<div class="cm-flex flexslider" id="twitter-slider-563723f9db590">
    <ul class="slides twitter-list" id="twitters">


    </ul>
</div>
<script type="text/javascript" src="<?php print $base_url . '/' . drupal_get_path('module', 'nv_widget'); ?>/js/tweety/twitter.js"></script>
<script type="text/javascript" src="<?php print $base_url . '/' . drupal_get_path('module', 'nv_widget'); ?>/js/tweety/get_tweet.php?url=statuses%2Fuser_timeline.json%3Fscreen_name%3D<?php print $twitter_username; ?>%26count%3D<?php print $tweets_count; ?>"></script>


