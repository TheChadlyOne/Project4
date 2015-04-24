<?php
/**
 * Created by PhpStorm.
 * User: i51830
 * Date: 4/23/15
 * Time: 1:45 PM
 */

namespace Common\Authentication;

require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterAuth {

    $access_token = "KMOtuI9UCPpeaqshDknjPvsvl";
    $access_token_secret = "BdTUFUUqNXMfWZWKaImzoWZQBoGmh0ntCcYNFqvSeA6qoNNt6I";


    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token, $access_token_secret);
    $content = $connection->get("account/verify_credentials");


    $connection->
/*
    function getConnectionWithAccessToken($oauth_token, $oauth_token_secret) {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
        return $connection;
    }

    $connection = getConnectionWithAccessToken("abcdefg", "hijklmnop");
    $content = $connection->

    get("statuses/home_timeline");
*/


}