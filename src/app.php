<?php

$app = new \Slim\Slim();

//end point landing page
$app->get('/', function()
{
    require_once realpath(__DIR__.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'NewLogin.html');
});

function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
    echo json_encode($response);
}


$app->post('/enroll',function () use($app) {

    $userIn = $app->request->params('username');
    $passIn = $app->request->params('password');
    $firstnameIn = $app->request->params('firstname');
    $lastnameIn = $app->request->params('lastname');
    $twitteridIn = $app->request->params('twitterid');
    $emailIn = $app->request->params('email');

    $consumer= new \Common\Authentication\Consumer($firstnameIn, $lastnameIn, $twitteridIn, $emailIn );

    $objSQLite = new \Common\Authentication\SQLiteConnection();
    $objSQLite->Enroll($userIn, $passIn, $consumer);

    if($objSQLite->generatedUserID === 0)
    {
        $app->response()->setStatus(401);
        $app->response()->getStatus();

        return json_encode($app->response()->header('Enrollment failed', 401));
    }
    if($objSQLite->generatedUserID > 0)
    {
        $app->response()->setStatus(200);
        $app->response()->getStatus();

        return json_encode($app->response()->header('You have been enrolled. ', 200));
    }
});

$app->post('/api',function () use($app){

    $userIn = $app->request->params('username');
    $passIn = $app->request->params('password');

    $access = new \Common\Authentication\SQLiteConnection(); //change file here!

    if(!$access->authenticate($userIn,$passIn))//GENNA, this is assuming the authenticate function will return a true or false
    {
        $app->response()->setStatus(401);
        $app->response()->getStatus();

        return json_encode($app->response()->header('Blah Blah something something', 401));
    }
    if($access->authenticate($userIn,$passIn))
    {
        $userProfileInfo = $access->GetProfileInfo($access->generatedUserID);

        $app->response()->header("Content-Type", "application/json",200);
        echo json_encode($userProfileInfo);

    }
});

$app->post('/profile',function () use($app) {

    $useridIn = $app->request->params('userid');

    $objSQLite = new Common\Authentication\SQLiteConnection();
    $response = $objSQLite->GetProfileInfo($useridIn);

    $app->response()->header("Content-Type", "application/json");
    echo json_encode($response);

});

$app->get('/access', function () use ($app) {

    $objSQLite = new Common\Authentication\SQLiteConnection();
    $uuid = $objSQLite->GetTheUUID();

    $response = array();

    $response["error"] = false;
    $response["message"] = "Your UUID is : $uuid";
    echoRespnse(200, $response);
});

$app->post('/twitter',function() use ($app)  {

    $userIn = $app->request->params('username');
    $passIn = $app->request->params('password');


    $access = new \Common\Authentication\TwitterAuth();
});



$app->run();