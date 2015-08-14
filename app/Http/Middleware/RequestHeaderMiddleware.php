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
  public function handle($request, Closure $next, $allowedMethods = null, $allowedHeaders = 'Authorization;Content-Type;Accept')
  {
    $response = $next($request);

    if($allowedMethods === null)
    {
      $allowedMethods = $request->getMethod();
    }

    if( strpos($allowedHeaders,'Authorization') !== FALSE )
    {
      $response->header('Access-Control-Allow-Credentials', 'true');
    }

    $response->header('Access-Control-Allow-Origin', '*');
    $response->header('Access-Control-Allow-Methods', str_replace(';',',',$allowedMethods));
    $response->header('Access-Control-Allow-Headers', str_replace(';',',',$allowedHeaders));

    return $response;
  }
}
