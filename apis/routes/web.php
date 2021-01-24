<?php
$router->get('/', function () use ($router) {  return response()->json(array(''), 403); });
$router->options('{all:.*}', function() use($router) { return response()->json(array(''), 200); });

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$router->get('/', function () use ($router) { return $router->app->version(); });
    // user
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('login', ['uses' => 'UserController@authenticate']);
        //$router->post('logout', ['uses' => 'UserController@logout']);

        // forget password
        $router->group(['prefix' => 'forget_password'], function () use ($router) {
            $router->post('', ['uses' => 'UserController@forgetPassword']);
            $router->get('code_verify', ['uses' => 'UserController@forgetPasswordCodeVerify']);
            $router->post('new_password', ['uses' => 'UserController@NewPassword']);
        });

        $router->post('signup', ['uses' => 'UserController@create']);
        $router->get('email-verify', ['uses' => 'UserController@registerCodeVerify']);
        $router->post('list', ['uses' => 'UserController@list']);
        $router->post('update', ['uses' => 'UserController@update']);
        $router->post('status/update', ['uses' => 'UserController@userStatusUpdate']);
        $router->post('change_password', ['uses' => 'UserController@changePassword']);
        //$router->post('status/update', ['uses' => 'UserController@statusUpdate']);

        $router->post('file_upload', ['uses' => 'UserController@fileupload']);
        $router->post('profile_image_upload', ['uses' => 'UserController@profile_image']);

    });
       
    // product
    $router->group(['prefix' => 'product'], function () use ($router) {
        $router->post('create',['uses' => 'ProductController@create']);
        $router->post('list',['uses' => 'ProductController@list']);
        $router->post('update',['uses' => 'ProductController@update']);
        $router->post('delete',['uses' => 'ProductController@delete']);
        $router->post('status/update', ['uses' => 'ProductController@productStatusUpdate']);
        $router->post('frontend/list', ['uses' => 'ProductController@list2']);
        
    });

    // // deposit
    // $router->group(['prefix' => 'deposit'], function () use ($router) {
    //     $router->post('create',['uses' => 'DepositController@create']);
    //     $router->post('list',['uses' => 'DepositController@list']);
    //     $router->post('update',['uses' => 'DepositController@update']);
    //     $router->post('delete',['uses' => 'DepositController@delete']);
    // });

    // // payment_transfer
    // $router->group(['prefix' => 'payment_transfer'], function () use ($router) {
    //     $router->post('create',['uses' => 'PaymentController@create']);
    //     $router->post('list',['uses' => 'PaymentController@list']);
    //     $router->post('update',['uses' => 'PaymentController@update']);
    //     $router->post('delete',['uses' => 'PaymentController@delete']);
    // });

    // // wallet_transfer
    // $router->group(['prefix' => 'wallet_transfer'], function () use ($router) {
    //     $router->post('create',['uses' => 'WalletController@create']);
    //     $router->post('list',['uses' => 'WalletController@list']);
    //     $router->post('update',['uses' => 'WalletController@update']);
    //     $router->post('delete',['uses' => 'WalletController@delete']);
    // });

    // // Coupon
    // $router->group(['prefix' => 'coupon'], function () use ($router) {
    //     $router->post('create',['uses' => 'CouponController@create']);
    //     $router->post('list',['uses' => 'CouponController@list']);
    //     //$router->post('update',['uses' => 'CouponController@update']);
    //     $router->post('delete',['uses' => 'CouponController@delete']);
    // });

    // superadmin
    $router->group(['prefix' => 'superadmin'], function () use ($router) {
        $router->post('login', ['uses' => 'SuperadminController@authenticate']);
        $router->post('list', ['uses' => 'SuperadminController@list']);
        $router->post('update', ['uses' => 'SuperadminController@update']);
        $router->post('change_password', ['uses' => 'SuperadminController@changePassword']);
        $router->post('reports', ['uses' => 'SuperadminController@report']);
    });
    // ====================  others  ================================== //
    // $router->post('file/upload', ['uses' => 'UserController@fileUpload']);
?>

