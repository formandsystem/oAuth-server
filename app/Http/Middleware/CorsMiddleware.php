<?php

namespace App\Http\Middleware;

use App\Exceptions\UnsupportedAcceptHeaderException;
use App\Exceptions\UnsupportedMediaTypeException;
use App\ValueObjects\JsonapiError;
use Closure;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class CorsMiddleware implements Httpstatuscodes
{
    /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   *
   * @return mixed
   */
  public function handle($request, Closure $next, $disabledContentType = false)
  {
      $response = $next($request);
      $contentTypes = config('config.contentTypes');
      $acceptHeader = config('config.contentTypeDefault');

      if ($request->getMethod() !== 'OPTIONS') {
          // check accept header
            try {
                $acceptHeader = $request->headers->get('Accept');
                $this->checkAcceptHeader($acceptHeader);
            } catch (UnsupportedAcceptHeaderException $e) {
                return response()->json($e->errorObject());
            }
            // check content type header
            try {
                $contentHeader = $request->headers->get('Content-Type');
                if ($disabledContentType === false) {
                    $this->checkContentHeader($contentHeader);
                }
            } catch (UnsupportedMediaTypeException $e) {
                return response()->json($e->errorObject());
            }
      }
      // add allow method header if not exist
      if ($this->allowMethodHeaderExists() === false) {
          $response->header('Access-Control-Allow-Methods', $request->getMethod());
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
          throw new UnsupportedAcceptHeaderException('Unsupported Accept Header',
             self::HTTP_NOT_ACCEPTABLE,
             new JsonapiError([
                'status' => self::HTTP_NOT_ACCEPTABLE,
                'title' => 'Unsupported Accept Header',
                'code' => 101,
            ])
        );
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
          throw new UnsupportedMediaTypeException('Unsupported Media Type in content type header',
                 self::HTTP_UNSUPPORTED_MEDIA_TYPE,
                 new JsonapiError([
                    'status' => self::HTTP_UNSUPPORTED_MEDIA_TYPE,
                    'title' => 'Unsupported Media Type in content type header',
                    'code' => 102,
                ])
            );
      }
  }

  /*
   * Find the Access-Control-Allow-Methods: in header_list()
   */
  public function allowMethodHeaderExists()
  {
      return strpos(implode(' ', headers_list()), 'Access-Control-Allow-Methods:') !== false;
  }
}
