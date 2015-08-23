<?php

namespace App\Http\Controllers;

use App\Http\Respond;
use App\Services\ResponseService as ResponseService;
use Illuminate\Http\Response;
use App\ValueObjects\JsonapiError;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ApiController extends BaseController implements Httpstatuscodes
{
    protected $respond;
    protected $response;
    protected $request;
    protected $authorizer;

    public function __construct(Respond $respond, Response $response, Request $request, Authorizer $authorizer)
    {
        $this->respond = $respond;
        $this->response = $response;
        $this->request = $request;
        $this->authorizer = $authorizer;
    }
    /*
     * validates the token and checks against needed scopes
     */
    public function validateAccess($scopes, $token = null)
    {
        try {
            if( $token === null ){
                $token = str_replace('Bearer ', '', $this->request->header('authorization'));
            }
            $this->authorizer->validateAccessToken(true, $token);

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

          return $this->respond->error([], 500);
      } elseif ($e->errorType === 'access_denied') {
          return $this->respond->error([
          'description' => $e->getMessage(),
          'code' => 110,
      ], 401);
      } elseif ($e->errorType === 'invalid_client') {
          return $this->respond->error([
        'description' => $e->getMessage(),
        'code' => 111,
      ], 401);
      } elseif ($e->errorType === 'unsupported_grant_type') {
          return $this->respond->error([
        'description' => $e->getMessage(),
        'code' => 112,
      ], 400);
      } elseif ($e->errorType === 'invalid_scope') {
          return $this->respond->error([
        'description' => $e->getMessage(),
        'code' => 113,
      ], 400);
      } elseif ($e->errorType === 'invalid_request') {
          return $this->respond->error([
        'description' => $e->getMessage(),
        'code' => 114,
      ], 400);
      } else {
          return $this->respond->error([
        'description' => $e->getMessage(),
      ], 400);
      }
  }
}
