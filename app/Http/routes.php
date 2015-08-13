<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$respond = $app->make('App\Http\Respond');
/*
 * path: /
 *
 * error handling for missing resource
 */
$app->get('/', function() use ($respond){
  return $respond->error([
    'code' => 100,
    'title' => 'Invalid endpoint'
  ], 404);
});

/*
 * path: /jsonapi
 *
 * get an access token using a client_id and client_secret
 */
$app->get('jsonapi', ['middleware' => 'RequestHeader:OPTIONS;GET', function() use ($respond){
  return $respond->success([
    'jsonapi' => [
      'version' => '1.0'
    ]
  ], 200);
}]);

$app->options('jsonapi', ['middleware' => 'RequestHeader:OPTIONS;GET', function() use ($respond){
  return $respond->success(null,204);
}]);
/*
 * path: /access_token
 *
 * get an access token using a client_id and client_secret
 */
$app->post('access_token', 'OauthController@getAccessToken');

$app->options('access_token', ['middleware' => 'RequestHeader:OPTIONS;POST', function() use ($respond){
  return $respond->success(null,204);
}]);
/*
 * path: /validate_token
 *
 * validate an access token and return scopes
 */
$app->post('validate_token', 'OauthController@validateAccessToken');

$app->options('validate_token', ['middleware' => 'RequestHeader:OPTIONS;POST', function() use ($respond){
  return $respond->success(null,204);
}]);
/*
 * path: /client
 */
$app->options('client', ['middleware' => 'RequestHeader:OPTIONS;POST,Credentials', function() use ($respond){
  return $respond->success(null,204);
}]);

$app->options('client/{id}', function() use ($respond){
  $respond->addHeader('Allow','GET,POST,PUT,DELETE,OPTIONS');
  return $respond->success(null,204);
});

$app->get('client/{id}', 'ClientController@show');

$app->post('client', 'ClientController@create');
