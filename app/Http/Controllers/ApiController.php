<?php

namespace App\Http\Controllers;

use App\Http\Respond;
use App\ValueObjects\JsonapiError;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ApiController extends BaseController implements Httpstatuscodes
{
    protected $response;
    protected $request;
    protected $authorizer;
    protected $db;

    public function __construct(Response $response, Request $request, Authorizer $authorizer)
    {
        $this->response = $response;
        $this->request = $request;
        $this->authorizer = $authorizer;
        $this->db = app('db');
    }
    /*
     * validates the token and checks against needed scopes
     */
    public function validateAccess($scopes, $token = null)
    {
        try {
            if ($token === null) {
                $token = str_replace('Bearer ', '', $this->request->header('authorization'));
            }

            $this->authorizer->validateAccessToken(false, $token);

            $this->hasScopes($scopes);
        } catch (LeagueException\AccessDeniedException $e) {
            return false;
        }
    }
    /*
    * check scopes
    *
    * catch if acces_token has scopes
    */
    protected function hasScopes($scopes)
    {
        if ($this->authorizer->hasScope($scopes) === false) {
            throw new LeagueException\AccessDeniedException();
        }

        return true;
    }

  /*
   * catchException
   *
   * catch a generic error
   */
  protected function catchException($e)
  {
      if (!isset($e->errorType)) {
          app()->make('Psr\Log\LoggerInterface')->error($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);

          return response(new JsonapiError([]), 500);
      } elseif ($e->errorType === 'access_denied') {
          return response(new JsonapiError([
          'detail' => $e->getMessage(),
          'code' => 110,
      ]), 401);
      } elseif ($e->errorType === 'invalid_client') {
          return response(new JsonapiError([
        'detail' => $e->getMessage(),
        'code' => 111,
      ]), 401);
      } elseif ($e->errorType === 'unsupported_grant_type') {
          return response(new JsonapiError([
        'detail' => $e->getMessage(),
        'code' => 112,
      ]), 400);
      } elseif ($e->errorType === 'invalid_scope') {
          return response(new JsonapiError([
        'detail' => $e->getMessage(),
        'code' => 113,
      ]), 400);
      } elseif ($e->errorType === 'invalid_request') {
          return response(new JsonapiError([
        'detail' => $e->getMessage(),
        'code' => 114,
      ]), 400);
      } else {
          return response(new JsonapiError([
        'detail' => $e->getMessage(),
      ]), 400);
      }
  }
}
