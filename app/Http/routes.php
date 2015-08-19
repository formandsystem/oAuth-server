<?php
/*
|--------------------------------------------------------------------------
| /jsonapi
|--------------------------------------------------------------------------
| options
*/
$app->options('jsonapi', 'JsonapiController@optionsJsonApi');
// get
$app->get('jsonapi', 'JsonapiController@getJsonApi');
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
 * path: /access_token
 *
 * get an access token using a client_id and client_secret
 */
$app->post('access_token', 'OauthController@getAccessToken');

$app->options('access_token', function () {
  // return $respond->success(null, 204);
});
/*
 * path: /validate_token
 *
 * validate an access token and return scopes
 */
$app->post('validate_token', 'OauthController@validateAccessToken');

$app->options('validate_token', function () {
  // return $respond->success(null, 204);
});
/*
|--------------------------------------------------------------------------
| /client
|--------------------------------------------------------------------------
| options
*/
$app->options('client','ClientController@options');
// create client
$app->post('client', 'ClientController@create');
// client/{id} options
$app->options('client/{id}', 'ClientController@itemOptions');
// get client/{id}
$app->get('client/{id}', 'ClientController@show');
