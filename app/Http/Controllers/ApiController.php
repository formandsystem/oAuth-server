<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use App\Http\Respond;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
  protected $respond;

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
   * catchError
   *
   * catch a generic error
   */
  protected function catchError($e, $code = null)
  {
    return $this->respond->error([
      'title' => $e->getMessage(),
      'code' => $code
    ], 400);
  }

}
