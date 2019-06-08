<?php

namespace TwitterWebsiteWidget;

/**
 * Twitter view class
 * 
 * The class will display the widget as needed
 */
class TwitterView
{
    /**
     * Variable to hold template filename
     *
     * @var string
     */
    private $template;

    /**
     * Variable to hold main Twitter object/model
     *
     * @var TwitterWidget
     */
    private $twitter;

    /**
     * Main constructor
     *
     * @param string $template
     * @param TwitterWidget $twitter
     */
    function __construct($template, TwitterWidget $twitter)
    {
        $this->template = $template;
        $this->twitter = $twitter;
    }

    /**
     * Function to render the output using template files
     *
     * @return string
     */
    public function render()
    { 
        if (isset($this->twitter->data->errors)) {
            return 'Error: '.$this->twitter->data->errors[0]->message.'('.$this->twitter->data->errors[0]->code.')';
        }

        $content = '';
        foreach ($this->twitter->data as $tweet) {  
            $tweet_text_modded = $this->formatTweetText($tweet);
            $tweet_count_retweet_modded = $this->formatTweetCount($tweet->retweet_count);
            $tweet_count_fav_modded = $this->formatTweetCount($tweet->favorite_count);
            ob_start();
            include $this->template;
            $content .= ob_get_clean();
        }
 
        return $content;
    }

    /**
     * Function to enrich the main text of the tweet (supplied in plain text)
     *
     * @param object $tweet
     * 
     * @return void
     */
    private function formatTweetText($tweet)
    {
        $text = htmlspecialchars($tweet->text);

        // deal with URLS...
        if (isset($tweet->entities->urls)) {
            $urls_array = $tweet->entities->urls;
            $text = htmlspecialchars($tweet->text);
            foreach ($urls_array as $url) {
                $text = str_replace($url->url,'<a target="_blank" href="'.htmlspecialchars($url->url).'">'.htmlspecialchars($url->display_url).'</a>',$text);
            }
        }

        // deal with images...
        if (isset($tweet->entities->media)) {
            $media_array = $tweet->entities->media;
            foreach ($media_array as $img) {
                $text = str_replace($img->url,'<a target="_blank" href="'.htmlspecialchars($img->expanded_url).'"><img src="'.htmlspecialchars($img->media_url).'" /></a>',$text);
            }
        }

        // deal with user mentions...
        if (isset($tweet->entities->user_mentions)) {
            $mentions_array = $tweet->entities->user_mentions;
            foreach ($mentions_array as $men) {
                $text = str_replace('@'.$men->screen_name,'<a target="_blank" href="https://twitter.com/'.htmlspecialchars($men->screen_name).'">@'.htmlspecialchars($men->screen_name).'</a>',$text);
            }
        }
       
        // deal with hashtags...
        if (isset($tweet->entities->hashtags)) {
            $ht_array = $tweet->entities->hashtags;
            foreach ($ht_array as $ht) {
                $text = str_replace('#'.$ht->text,'<a target="_blank" href="https://twitter.com/hashtag/'.htmlspecialchars($ht->text).'?src=hash">#'.htmlspecialchars($ht->text).'</a>',$text);
            }
        }

        return $text;
    }

    /**
     * Function to format supplied count variables
     *
     * @param int $count
     * 
     * @return string
     */
    private function formatTweetCount($count)
    {
        if ($count >= 1000) {
            $count = $count / 1000;
            $count = round($count,1).'k';
        }

        return htmlspecialchars($count);
    }
}
