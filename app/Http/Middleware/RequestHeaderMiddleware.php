<?php namespace App\Http\Middleware;

use Closure;

class RequestHeaderMiddleware {

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next, $allowedMethods)
  {
    $response = $next($request);

    $acceptHeaderCheck = $this->checkAcceptHeader($request);
    $contentHeaderCheck = $this->checkAcceptHeader($request);
    $contentTypes = config('config.contentTypes');

    if( $acceptHeaderCheck !== null )
    {
      return $acceptHeaderCheck;
    }

    if( $contentHeaderCheck !== null )
    {
      return $contentHeaderCheck;
    }

    if( array_key_exists($request->headers->get('Accept'),$contentTypes) )
    {
      $response->header('Content-Type', $contentTypes[$request->headers->get('Accept')]);
    }
    else {
      $response->header('Content-Type', $contentTypes['application/json']);
    }

    $response->header('Access-Control-Allow-Methods', str_replace(';',',',$allowedMethods));
    $response->header('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept');
    $response->header('Access-Control-Allow-Origin', '*');

    return $response;
  }

  public function checkAcceptHeader($request)
  {
    $acceptHeader = $request->headers->get('Accept');
    $contentTypes = config('config.contentTypes');

    if(strpos($acceptHeader,';') || !array_key_exists($acceptHeader,$contentTypes) )
    {
      $response = app()->make('App\Http\Respond');
      return $response->NotAcceptable([
        'code' => 101,
        'title' => 'Invalid accept header',
      ]);
    }

  }

  public function checkContentHeader($request)
  {
    $contentHeader = $request->headers->get('Content-Type');
    $contentTypes = config('config.contentTypes');

    if(strlen($contentHeader) >= 1 && (strpos($contentHeader,';') || !array_key_exists($contentHeader,$contentTypes)) )
    {
      $response = app()->make('App\Http\Respond');
      return $response->UnsupportedMediaType([
        'code' => 102,
        'title' => 'Unsupported Media Type in content type header',
      ]);
    }
  }
}
