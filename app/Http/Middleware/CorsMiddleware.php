<?php

namespace App\Http\Middleware;

use App\ValueObjects\JsonapiError;
use Closure;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class CorsMiddleware implements Httpstatuscodes
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
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
            $acceptHeader = $request->headers->get('Accept');
            if (!$this->isValidAcceptHeader($acceptHeader)) {
                return response(new JsonapiError([
                        'status' => self::HTTP_NOT_ACCEPTABLE,
                        'title' => 'Unsupported Accept Header',
                        'code' => 102,
                    ]),
                    self::HTTP_NOT_ACCEPTABLE
                );
            }
            // check content type header
            $contentHeader = $request->headers->get('Content-Type');
            if ($disabledContentType === false && !$this->isValidContentHeader($contentHeader)) {
                return response(new JsonapiError([
                        'status' => self::HTTP_UNSUPPORTED_MEDIA_TYPE,
                        'title' => 'Unsupported Media Type in content type header',
                        'code' => 103,
                    ]),
                    self::HTTP_UNSUPPORTED_MEDIA_TYPE
                );
            }
        }

        return $this->responseWithHeaders($response, $contentTypes[$acceptHeader], $request->getMethod());
    }

    /**
     * set appropriate CORS header.
     */
    public function responseWithHeaders($response, $contentType, $allowMethods)
    {
        // add allow method header if not exist
        if ($this->allowMethodHeaderExists() === false) {
            $response->header('Access-Control-Allow-Methods', $allowMethods);
        }
        // set Content Type
        $response->header('Content-Type', $contentType);
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
    private function isValidAcceptHeader($acceptHeader)
    {
        if (strpos($acceptHeader, ';') || ($acceptHeader !== '' && !array_key_exists($acceptHeader, config('config.contentTypes')))) {
            return false;
        }

        return true;
    }

    /*
    * checkContentHeader
    *
    * checks if content type Header is correctly formatted
    */
    private function isValidContentHeader($contentHeader)
    {
        if (strpos($contentHeader, ';') || ($contentHeader !== '' && !array_key_exists($contentHeader, config('config.contentTypes')))) {
            return false;
        }

        return true;
    }

    /*
    * Find the Access-Control-Allow-Methods: in header_list()
    */
    private function allowMethodHeaderExists()
    {
        return strpos(implode(' ', headers_list()), 'Access-Control-Allow-Methods:') !== false;
    }
}
