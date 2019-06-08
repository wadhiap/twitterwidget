<div class="tweet_wrapper">
    <div class="tweet_left">
        <img src="<?php print htmlspecialchars($tweet->user->profile_image_url); ?>" />
    </div>
    <div class="tweet_right">
        <div class="tweet_right_1 tweet_right_row">
            <span class="tweet_user_name"><?php print htmlspecialchars($tweet->user->name); ?></span>
            <span class="tweet_user_username">@<?php print htmlspecialchars($tweet->user->screen_name); ?></span>
            <span class="tweet_time">
            <?php 
                $time = strtotime($tweet->created_at);
                $date = date("M d", $time);
                print htmlspecialchars($date); 
            ?>
            </span>
        </div>
        <div class="tweet_right_2 tweet_right_row">
            <?php print $tweet_text_modded ?> 
            <?php print '<a target="_blank" href="https://twitter.com/'.htmlspecialchars($tweet->user->name).'/status/'.htmlspecialchars($tweet->id).'">[View tweet]</a>';?>
        </div>
        <div class="tweet_right_3 tweet_right_row">
            <span>Retweets: <?php print $tweet_count_retweet_modded; ?></span>
            <span>Likes: <?php print $tweet_count_fav_modded; ?></span> 				 
        </div>
    </div>
</div>
