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
use LucaDegasperi\OAuth2Server\Authorizer;
use League\OAuth2\Server\Exception as LeagueException;
$respond = $app->make('App\Http\Respond');
$authorizer = $app->make('oauth2-server.authorizer');
/*
 * path: /
 *
 * error handling for missing resource
 */
$app->get('/', 'ApiController@index');

/*
 * path: /jsonapi
 *
 * get an access token using a client_id and client_secret
 */
$app->get('jsonapi', 'ApiController@jsonapi');

/*
 * path: /access_token
 *
 * get an access token using a client_id and client_secret
 */
$app->post('access_token', 'OauthController@getAccessToken');

/*
 * path: /validate_token
 *
 * validate an access token and return scopes
 */
$app->post('validate_token', 'OauthController@validateAccessToken');

/*
 * path: /client
 *
 * get client info
 */
$app->get('client/{id}', 'ClientController@show');
