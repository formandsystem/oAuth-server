<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;
use League\OAuth2\Server\Exception as LeagueException;

class OauthController extends ApiController
{
  /*
   * get an access token using a client_id and client_secret
   */
  function getAccessToken()
  {
    try{
      return $this->respond->ok(
        ['meta' =>
          $this->authorizer->issueAccessToken()
        ]
      );
    }
    catch(LeagueException\InvalidClientException $e)
    {
      return $this->catchError($e, 111);
    }
    catch(LeagueException\UnsupportedGrantTypeException $e)
    {
      return $this->catchError($e, 112);
    }
    catch(LeagueException\InvalidScopeException $e)
    {
      return $this->catchError($e, 113);
    }
    catch(LeagueException\InvalidRequestException $e)
    {
      return $this->catchError($e, 114);
    }
    catch(LeagueException\OAuthException $e)
    {
      return $this->catchError($e);
    }
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

      return $this->respond->noContent();
    }
    catch(LeagueException\AccessDeniedException $e)
    {
      return $this->respond->error([
        'title' => $e->getMessage(),
        'code' => 120
      ], 401);
    }
    catch(LeagueException\InvalidRequestException $e)
    {
      return $this->catchError($e, 121);
    }
    catch(LeagueException\OAuthException $e)
    {
      return $this->catchError($e);
    }
  }

}
