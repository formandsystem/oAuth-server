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
$app->options('token', ['middleware' => ['cors'], 'uses' => 'TokenController@optionsAccessToken']);
// create token
$app->post('token', ['middleware' => ['cors:disabledContentType'], 'uses' => 'TokenController@createAccessToken']);
// options token
$app->options('token/{token}', ['middleware' => ['cors'], 'uses' => 'TokenController@optionsValidateToken']);
// validate token
$app->get('token/{token}', ['middleware' => ['cors:disabledContentType'], 'uses' => 'TokenController@validateToken']);
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
