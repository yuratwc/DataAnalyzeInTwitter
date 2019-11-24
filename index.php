<?php
//error_reporting(E_ERROR | E_PARSE);
require_once('./twitteroauth/autoload.php');
/*
define("CONSUMER_KEY", '**********');
define("CONSUMER_SECRET", '**********');
define("ACCESS_TOKEN", '**********');
define("ACCESS_TOKEN_SECRET", '**********');

*/
echo mb_internal_encoding();

mb_internal_encoding("UTF-8");

define("DEFAULT_DIRECTORY", './jsons');

require_once('./keys.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$query = '(ペイ OR PAY OR Pay) -キャンペーン';

$result_count = 100;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

$opts = array("q" => $query, "max_id" => -1, "exclude"=> "retweets", "lang" => "ja", "result_type" => "recent", "count" => $result_count);
for($i = 0; $i < 5; $i++) {
    //var_dump($opts);
    $statuses = $connection->get("search/tweets", $opts);
    //print_r($statuses);
    $opts['max_id'] = $statuses->statuses[0]->id - 1;
    echo $statuses->statuses[0]->id - 1 . '<br>';
    //echo $statuses->search_metadata->max_id;
    //echo '<br>';
    
    $json = json_encode($statuses->statuses);

    if(!file_exists(DEFAULT_DIRECTORY))
        mkdir(DEFAULT_DIRECTORY);

    file_put_contents(DEFAULT_DIRECTORY . '/' . date("Y-m-d-H-i-s") . '-' . $i . '.json', $json);
}