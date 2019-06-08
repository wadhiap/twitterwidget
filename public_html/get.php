<?php

namespace TwitterWebsiteWidget; 

require "../vendor/autoload.php";

session_start();
//unset($_SESSION['twitter_token']);
//exit;

$config = parse_ini_file('../config.ini');
$twitter = new TwitterWidget(new TwitterConnectorAuthOnlyOAuth2Curl($config['consumer_key'],$config['consumer_secret']));
$controller = new TwitterController($twitter);
$view = new TwitterView('user_timeline_template.php',$twitter);

$controller->query('https://api.twitter.com/1.1/statuses/user_timeline.json?count=5&exclude_replies=1&screen_name=anthonyfjoshua');
print $view->render();
