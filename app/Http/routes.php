<?php
/*
|--------------------------------------------------------------------------
| /jsonapi
|--------------------------------------------------------------------------
| options
*/
$app->options('jsonapi', ['middleware' => ['cors'], 'uses' => 'JsonapiController@optionsJsonApi']);
// get
$app->get('jsonapi', ['middleware' => ['cors'], 'uses' => 'JsonapiController@getJsonApi']);
/*
|--------------------------------------------------------------------------
| /accesstoken
|--------------------------------------------------------------------------
| options
*/
$app->options('token', 'TokenController@optionsAccessToken');
// create token
$app->post('token', 'TokenController@createAccessToken');
// options token
$app->options('token/{token}', 'TokenController@optionsValidateToken');
// validate token
$app->get('token/{token}', 'TokenController@validateToken');
/*
|--------------------------------------------------------------------------
| /client
|--------------------------------------------------------------------------
| options
*/
$app->options('client', ['middleware' => ['cors'], 'uses' => 'ClientController@options']);
// create client
$app->post('client', ['middleware' => ['cors'], 'uses' => 'ClientController@create']);
// client/{id} options
$app->options('client/{id}', ['middleware' => ['cors'], 'uses' => 'ClientController@itemOptions']);
// get client/{id}
$app->get('client/{id}', ['middleware' => ['cors'], 'uses' => 'ClientController@show']);
