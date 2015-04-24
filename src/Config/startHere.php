<?php
session_start();

/**
 * Twitter Credentials
 */



define("CONSUMER_KEY", "KMOtuI9UCPpeaqshDknjPvsvl");
define("CONSUMER_SECRET", "BdTUFUUqNXMfWZWKaImzoWZQBoGmh0ntCcYNFqvSeA6qoNNt6I");
define("OAUTH_CALLBACK", "oob");
/**

*
 * Initialize Framework
 */
require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
\Slim\Slim::registerAutoloader();

/**
 * start app
 */
require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'app.php');





