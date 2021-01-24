<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/
 if(isset($_SERVER["HTTP_ORIGIN"])) 
{
	$http_origin = $_SERVER['HTTP_ORIGIN'];	
	header('Access-Control-Allow-Origin: '.$http_origin);
}
//$http_origin = $_SERVER['HTTP_ORIGIN'];
//print_r($http_origin);print_r("expression");
header('Access-Control-Allow-Credentials: true');
//header('Access-Control-Allow-Origin: '.$http_origin);
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Content-Range, Content-Disposition, Content-Description, X-Auth-Token');

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$app->run();
