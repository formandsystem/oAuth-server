<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use League\OAuth2\Server\Exception as LeagueException;

class ClientController extends ApiController
{
  /*
   * get a client
   */
  function show($id)
  {
    try{
      $this->authorizer->validateAccessToken(true);
      $this->hasScopes(['client.read']);
      return $this->respond->ok(['data' =>
        [
          'id' => $this->authorizer->getClientId(),
          'type' => 'client',
          'attribtues' => [

          ]
        ]
      ]);
    }
    catch(LeagueException\AccessDeniedException $e)
    {
      return $this->respond->error([
        'title' => $e->getMessage(),
        'code' => 110
      ], 401);
    }
    catch(LeagueException\InvalidRequestException $e)
    {
      return $this->catchError($e, 104);
    }
    catch(LeagueException\OAuthException $e)
    {
      return $this->catchError($e);
    }
  }

}
