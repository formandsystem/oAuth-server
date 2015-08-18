<?php


$respond = $app->make('App\Http\Respond');
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
$app->post('access_token', ['middleware' => ['ContentHeader', 'RequestHeader:OPTIONS;POST'], 'uses' => 'OauthController@getAccessToken']);

$app->options('access_token', ['middleware' => ['ContentHeader', 'RequestHeader:OPTIONS;POST'], function () use ($respond) {
  return $respond->success(null, 204);
}]);
/*
 * path: /validate_token
 *
 * validate an access token and return scopes
 */
$app->post('validate_token', 'OauthController@validateAccessToken');

$app->options('validate_token', ['middleware' => ['ContentHeader', 'RequestHeader:OPTIONS;POST'], function () use ($respond) {
  return $respond->success(null, 204);
}]);
/*
|--------------------------------------------------------------------------
| /client
|--------------------------------------------------------------------------
| options
*/
$app->options('client', ['middleware' => ['ContentHeader', 'RequestHeader:OPTIONS;POST'], function () use ($respond) {
  $respond->addHeader('Access-Control-Allow-Credentials', 'true');

  return $respond->success(null, 204);
}]);
// create client
$app->post('client', ['middleware' => ['ContentHeader', 'RequestHeader'], 'uses' => 'ClientController@create']);
// client/{id} options
$app->options('client/{id}', ['middleware' => ['ContentHeader', 'RequestHeader:GET;POST;PUT;DELETE;OPTIONS'], function () use ($respond) {
  $respond->addHeader('Allow', 'GET,POST,PUT,DELETE,OPTIONS');
  $respond->addHeader('Access-Control-Allow-Credentials', 'true');

  return $respond->success(null, 204);
}]);
// get client/{id}
$app->get('client/{id}', ['middleware' => ['ContentHeader', 'RequestHeader'], 'uses' => 'ClientController@show']);
