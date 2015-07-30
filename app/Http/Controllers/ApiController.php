<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use LucaDegasperi\OAuth2Server\Authorizer;
use League\OAuth2\Server\Exception as LeagueException;
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

  function index(){
    return $this->respond->error([
      'code' => 100,
      'title' => 'Invalid endpoint',
      'detail' => 'A resource is required in the url'
    ], 404);

  }
  /*
   * path: /jsonapi
   *
   * get jsonapi version
   */
  function jsonapi()
  {
    return $this->respond->ok([
      'jsonapi' => [
        'version' => '1.0'
      ]
    ]);
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
