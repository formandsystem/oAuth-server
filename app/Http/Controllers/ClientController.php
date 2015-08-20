<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use App\Http\Respond;
use Carbon\Carbon;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Authorizer;

class ClientController extends ApiController
{
    protected $clientRepository;

    public function __construct(Respond $respond, Request $request, Authorizer $authorizer)
    {
        parent::__construct($respond, $request, $authorizer);
        $this->db = app('db');
    }

  /*
   * get a client
   */
  public function show($id)
  {
      try {
          $token = str_replace('Bearer ', '', $this->request->header('authorizer'));

          $this->authorizer->validateAccessToken(false, $token);
          $this->hasScopes(['client.read']);
          $configScopes = config('config.scopes');

          $client = $this->db->table('oauth_clients')->where('id', $id)->first();

          $scopes = $this->db->table('oauth_client_scopes')->where('client_id', $id)->get();
          foreach ($scopes as $scope) {
              if (in_array($scope->scope_id, $configScopes['client'])) {
                  return $this->respond->error([
            'description' => 'You are not allowed to view this user.',
            'code' => 106,
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
            'secret' => $client->secret,
          ],
        ],
      ], 200);
      } catch (\Exception $e) {
          return $this->catchException($e);
      }
  }

    public function create()
    {
        try {
            $token = str_replace('Bearer ', '', $this->request->header('authorizer'));
            $this->authorizer->validateAccessToken(false, $token);
            $this->hasScopes(['client.create']);
            $now = Carbon::now()->toDateTimeString();

            $clientData = [
        'id' => 'client_created_by_test',
        'secret' => 'secret',
        'name' => 'client_created_by_test',
        'created_at' => $now,
        'updated_At' => $now,
      ];

            $this->db->table('oauth_clients')->insert($clientData);


            return $this->respond->success(['data' =>
        [
          'id' => $clientData['id'],
          'type' => 'client',
          'attributes' => [
            'secret' => $clientData['secret'],
          ],
        ],
      ], url('/client/'.$clientData['id']), 201);
        } catch (\Exception $e) {
            return $this->catchException($e);
        }
    }
}
