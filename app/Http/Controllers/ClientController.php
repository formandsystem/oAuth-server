<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use App\Http\Respond;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClientController extends ApiController
{

  protected $clientRepository;

  function __construct(Respond $respond, Request $request, Authorizer $authorizer )
  {
    parent::__construct($respond, $request, $authorizer);
    $this->db = app('db');
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

      $client = $this->db->table('oauth_clients')->where('id',$id)->first();

      $scopes = $this->db->table('oauth_client_scopes')->where('client_id',$id)->get();
      foreach($scopes as $scope)
      {
        if(in_array($scope->scope_id, $configScopes['client']) )
        {
          return $this->respond->error([
            'description' => 'You are not allowed to view this user.',
            'code' => 106
          ], 403);
        }
      }

      return $this->respond->success(['data' =>
        [
          'id' => $client->id,
          'type' => 'client',
          'attribtues' => [
            'id' => $client->id,
            'name' => $client->name,
            'secret' => $client->secret
          ]
        ]
      ],200);
    }
    catch( \Exception $e )
    {
      return $this->catchException($e);
    }
  }

  function create()
  {
    try{
      $this->authorizer->validateAccessToken(true);
      $this->hasScopes(['client.create']);
      $now = Carbon::now()->toDateTimeString();
      $this->db->table('oauth_clients')->insert([
        'id' => 'A',
        'secret' => 'B',
        'name' => 'C',
        'created_at' => $now,
        'updated_At' => $now
      ]);

      $client = ['id' => 'abs'];

      return $this->respond->success(['data' =>
        [

        ]
      ], url('/client/'.$client['id']), 201);
    }
    catch( \Exception $e )
    {
      return $this->catchException($e);
    }
  }


}
