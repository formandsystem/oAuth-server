<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use App\Http\Respond;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
  protected $respond;
  protected $request;
  protected $authorizer;

  function __construct(Respond $respond, Request $request, Authorizer $authorizer){
    $this->respond = $respond;
    $this->request = $request;
    $this->authorizer = $authorizer;
  }

  /*
   * check scopes
   *
   * catch if acces_token has scopes
   */
  protected function hasScopes($scopes)
  {
    if( $this->authorizer->hasScope($scopes) === false )
    {
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
    if( !isset($e->errorType) )
    {
      app()->make('Psr\Log\LoggerInterface')->error($e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
      return $this->respond->internal();
    }
    elseif( $e->errorType === 'access_denied' )
    {
      return $this->respond->authenticationFailed([
        'description' => $e->getMessage(),
        'code' => 110
      ]);
    }
    elseif( $e->errorType === 'invalid_client' )
    {
      return $this->respond->authenticationFailed([
        'description' => $e->getMessage(),
        'code' => 111
      ]);
    }
    elseif( $e->errorType === 'unsupported_grant_type' )
    {
      return $this->respond->badRequest([
        'description' => $e->getMessage(),
        'code' => 112
      ]);
    }
    elseif( $e->errorType === 'invalid_scope' )
    {
      return $this->respond->badRequest([
        'description' => $e->getMessage(),
        'code' => 113
      ]);
    }
    elseif( $e->errorType === 'invalid_request' )
    {
      return $this->respond->badRequest([
        'description' => $e->getMessage(),
        'code' => 114
      ]);
    }
    else {
      return $this->respond->badRequest([
        'description' => $e->getMessage()
      ]);
    }
  }

}
