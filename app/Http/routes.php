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
  return $respond->notFound([
    'code' => 100,
    'title' => 'Invalid endpoint'
  ]);
});

/*
 * path: /jsonapi
 *
 * get an access token using a client_id and client_secret
 */
$app->get('jsonapi', ['middleware' => 'RequestHeader:GET;OPTIONS', function() use ($respond){
  return $respond->ok([
    'jsonapi' => [
      'version' => '1.0'
    ]
  ]);
}]);

$app->options('jsonapi', function() use ($respond){
  $respond->addHeader('Allow','GET,OPTIONS');
  return $respond->noContent();
});
/*
 * path: /access_token
 *
 * get an access token using a client_id and client_secret
 */
$app->post('access_token', 'OauthController@getAccessToken');

$app->options('access_token', function() use ($respond){
  $respond->addHeader('Allow','POST,OPTIONS');
  return $respond->noContent();
});
/*
 * path: /validate_token
 *
 * validate an access token and return scopes
 */
$app->post('validate_token', 'OauthController@validateAccessToken');

$app->options('validate_token', function() use ($respond){
  $respond->addHeader('Allow','POST,OPTIONS');
  return $respond->noContent();
});
/*
 * path: /client
 */
$app->options('client/{id}', function() use ($respond){
  $respond->addHeader('Allow','GET,POST,PUT,DELETE,OPTIONS');
  return $respond->noContent();
});

$app->get('client/{id}', 'ClientController@show');
