<?php

namespace app\Http\Middleware;

use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Closure;

class CORSMiddleware implements Httpstatuscodes
{
    /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   *
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
      $response = $next($request);
      $contentTypes = config('config.contentTypes');
      $acceptHeader = config('config.contentTypeDefault');

      // add allow method header if not exist
      if ($this->allowMethodHeaderExists() === false) {
          $response->header('Access-Control-Allow-Methods', $request->getMethod());
      }

      if ($request->getMethod() !== 'OPTIONS') {
          // check accept header
          $acceptHeader = $request->headers->get('Accept');
          $this->checkAcceptHeader($acceptHeader);
          // check content type header
          $contentHeader = $request->headers->get('Content-Type');
          $this->checkContentHeader($contentHeader);
      }
      // set Content Type
      $response->header('Content-Type', $contentTypes[$acceptHeader]);
      // set Origin
      $response->header('Access-Control-Allow-Origin', '*');
      // set Allow Header
      $response->header('Access-Control-Allow-Headers', config('config.allowHeaders'));
      // set Credentials
      $response->header('Access-Control-Allow-Credentials', 'true');

      return $response;
  }
  /*
   * checkAcceptHeader
   *
   * checks if acceptHeader is correctly formatted
   */
  public function checkAcceptHeader($acceptHeader)
  {
      if (strpos($acceptHeader, ';') || ($acceptHeader !== '' && !array_key_exists($acceptHeader, config('config.contentTypes')))) {
          $this->exitWithError([
            'status' => self::HTTP_NOT_ACCEPTABLE,
            'title' => 'Invalid accept header',
            'code' => 101,
            'links' => [
                'about' => 'http://dev.formandsystem.com/errors/#101',
            ],
        ], self::HTTP_NOT_ACCEPTABLE);
      }
  }
  /*
   * checkContentHeader
   *
   * checks if content type Header is correctly formatted
   */
  public function checkContentHeader($contentHeader)
  {
      if (strpos($contentHeader, ';') || ($contentHeader !== '' && !array_key_exists($contentHeader, config('config.contentTypes')))) {
          $this->exitWithError([
            'status' => self::HTTP_UNSUPPORTED_MEDIA_TYPE,
            'title' => 'Unsupported Media Type in content type header',
            'code' => 102,
            'links' => [
                'about' => 'http://dev.formandsystem.com/errors/#102',
            ],
        ], self::HTTP_UNSUPPORTED_MEDIA_TYPE);
      }
  }

  /*
   * exitWithResponse
   *
   * @description: exit and return an http response
   */
  private function exitWithError($error, $statusCode)
  {
      // set response header & status code
      header('Content-Type: application/json');
      http_response_code($statusCode);
      // build jsonAPI error object
      $error = ['errors' => [
              'error' => $error,
          ],
      ];
      // abort and return error
      exit(json_encode($error));
  }
  /*
   * Find the Access-Control-Allow-Methods: in header_list()
   */
  public function allowMethodHeaderExists()
  {
      return strpos(implode(' ', headers_list()), 'Access-Control-Allow-Methods:') !== false;
  }
}
