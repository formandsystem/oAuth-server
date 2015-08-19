<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use League\OAuth2\Server\Exception as LeagueException;

class TokenController extends ApiController
{
  protected $allowedMethods = ['OPTIONS','GET','POST'];
  /*
   * get an access token using a client_id and client_secret
   */
  function getAccessToken()
  {
    try{
      $token = $this->authorizer->issueAccessToken();
      return $this->respond->success(
        ['data' =>
          [
            'id' => $token['access_token'],
            'type' => 'access_token',
            'attributes' => [
              $token
            ]
          ]
        ],
        200
      );
    }
    catch(\Exception $e)
    {
      return $this->catchException($e);
    }
  }
  /*
   * @method: OPTIONS
   */
  function optionsValidateToken()
  {
    return $this->respond->success(null,204);
  }
  /*
   * validate an access token and return scopes
   */
  function validateAccessToken()
  {
    try {
      $this->authorizer->validateAccessToken(true);
      $scopes = array_map('trim',explode(',',$this->request->input('scope')));
      $this->hasScopes($scopes);

      return $respond->success(null,204);
    }
    catch(\Exception $e)
    {
      return $this->catchException($e);
    }
  }

}
