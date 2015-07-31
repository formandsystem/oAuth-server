<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Storage\FluentClient;
use LucaDegasperi\OAuth2Server\Authorizer;
use App\Http\Respond;
use Illuminate\Http\Request;

class ClientController extends ApiController
{

  protected $clientRepository;

  function __construct(Respond $respond, Request $request, Authorizer $authorizer, FluentClient $clientRepo)
  {
    parent::__construct($respond, $request, $authorizer);
    $this->clientRepository = $clientRepo;
  }

  /*
   * get a client
   */
  function show($id)
  {
    try{
      $this->authorizer->validateAccessToken(true);
      $this->hasScopes(['client.read']);
      $configScopes = config('config.scopes');

      $client = app('db')->table('oauth_clients')->where('id',$id)->first();

      $scopes = app('db')->table('oauth_client_scopes')->where('client_id',$id)->get();
      foreach($scopes as $scope)
      {
        if(in_array($scope->scope_id, $configScopes['client']) )
        {
          return $this->respond->forbidden([
            'title' => 'You are not allowed to view this user',
            'code' => 106
          ]);
        }
      }

      return $this->respond->ok(['data' =>
        [
          'id' => $client->id,
          'type' => 'client',
          'attribtues' => [
            'id' => $client->id,
            'name' => $client->name,
            'secret' => $client->secret
          ]
        ]
      ]);
    }
    catch( \Exception $e )
    {
      return $this->catchException($e);
    }
  }

}
