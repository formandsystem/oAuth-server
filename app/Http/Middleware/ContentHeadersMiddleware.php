<?php namespace App\Http\Middleware;

use Closure;

class ContentHeadersMiddleware {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $response = $next($request);
    $contentTypes = config('config.contentTypes');

    if( $request->getMethod() !== 'OPTIONS' )
    {
      // check accept header
      $acceptHeader   = $request->headers->get('Accept');
      $contentHeader  = $request->headers->get('Content-Type');
      $this->checkAcceptHeader($acceptHeader);
      // $this->checkContentHeader($contentHeader);
      $response->header('Content-Type', $contentTypes[$acceptHeader]);
    }
    else
    {
      $response->header('Content-Type', $contentTypes['application/json']);
    }

    return $response;
  }
  /*
   * checkAcceptHeader
   *
   * checks if acceptHeader is correctly formatted
   */
  public function checkAcceptHeader($acceptHeader)
  {
    if( strpos($acceptHeader,';') || !array_key_exists($acceptHeader, config('config.contentTypes')) )
    {
      $this->exitWithResponse([
          "errors" => [
            "error" => [
              "status" => 406,
              "title" => "Invalid accept header",
              "code" => 101,
              "links" =>  [
                "about" => "http://dev.formandsystem.com/errors/#101"
              ]
            ]
          ]
        ], 406);
    }
  }

  public function checkContentHeader($contentHeader)
  {
    if(strlen($contentHeader) >= 1 && (strpos($contentHeader,';') || !array_key_exists($contentHeader,config('config.contentTypes'))) )
    {
      $this->exitWithResponse([
          "errors" => [
            "error" => [
              "status" => 415,
              "title" => "Unsupported Media Type in content type header",
              "code" => 102,
              "links" =>  [
                "about" => "http://dev.formandsystem.com/errors/#102"
              ]
            ]
          ]
        ], 415);
    }
  }

  /*
   * exitWithResponse
   *
   * @description: exit and return an http response
   */
  private function exitWithResponse($data, $statusCode)
  {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    exit(json_encode($data));
  }
}
