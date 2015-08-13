<?php namespace App\Http\Middleware;

use Closure;

class RequestHeaderMiddleware {
  // TODO: Needs refactoring
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next, $allowedMethods, $credentials = false)
  {
    $response = $next($request);
    $acceptHeaderCheck = $this->checkAcceptHeader($request);
    $contentHeaderCheck = $this->checkContentHeader($request);
    $contentTypes = config('config.contentTypes');

    if( $acceptHeaderCheck !== null )
    {
      return $acceptHeaderCheck;
    }
    if( $contentHeaderCheck !== null )
    {
      return $contentHeaderCheck;
    }

    $contentType = $contentTypes['application/json'];
    if( array_key_exists($request->headers->get('Accept'),$contentTypes) )
    {
      $contentType = $contentTypes[$request->headers->get('Accept')];
    }
    
    if(strtolower($credentials) === 'credentials'){
      $response->header('Access-Control-Allow-Credentials', 'true');
    }

    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Content-Type', $contentType);

    $this->optionsHeaders($request, $response, $allowedMethods);

    return $response;
  }

  /*
   *
   */
  protected function optionsHeaders($request, $response, $allowedMethods){
    if($request->getMethod() === 'OPTIONS'){
      $response->header('Access-Control-Allow-Methods', str_replace(';',',',$allowedMethods));
      $response->header('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept');
    }
  }

  public function checkAcceptHeader($request)
  {
    $acceptHeader = $request->headers->get('Accept');
    $contentTypes = config('config.contentTypes');

    if($request->getMethod() === 'OPTIONS'){
      return null;
    }

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
