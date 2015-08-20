<?php namespace App\Http\Controllers;

use App\Http\Respond;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ApiController extends BaseController implements Httpstatuscodes
{
    protected $respond;
    protected $request;
    protected $authorizer;


    public function __construct(Respond $respond, Request $request, Authorizer $authorizer)
    {
        $this->respond = $respond;
        $this->request = $request;
        $this->authorizer = $authorizer;
    // middleware
    // $this->middleware('cors');
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
