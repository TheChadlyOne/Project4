<?php
/**
 * Created by PhpStorm.
 * User: i51830
 * Date: 4/23/15
 * Time: 1:45 PM
 */

namespace Common\Authentication;

//require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


class TwitterAuth {


    public $url = "";

    function __construct() {

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        // $content = $connection->get("account/verify_credentials");
        $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        $this->url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    }


    function auth_session() {
        $request_token = [];
        $request_token['oauth_token'] = $_SESSION['oauth_token'];
        $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

        if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
            // Abort! Something is wrong.
        }

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

        $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));

        $_SESSION['access_token'] = $access_token;
    }
}