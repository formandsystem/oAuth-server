<?php namespace App\Http;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class Respond{
  // response
  protected $response;

  // make sure to include / at the end
  protected $devUrl = "http://dev.formandsystem.com/";

  // status code
  protected $status = 400;

  // respond headers
  protected $headers = [];

  function __construct(Response $response, Request $request)
  {
    $this->response = $response;
    $this->request = $request;
  }
  /*
   * set Content-Type header
   *
   * @return void
   */
  public function setContentType()
  {
    $this->setHeaders(['Content-Type' => config('response.defaultContentTypes')]);

    if( $this->request->headers->get('Accept') !== null && in_array($this->request->headers->get('Accept'), config('response.contentTypes')) )
    {
      $this->setHeaders(['Content-Type' => $this->request->headers->get('Accept')]);
    }
  }

  /*
   * get headers
   *
   * @return array
   */
  public function getHeaders()
  {
    $this->setContentType();
    return $this->headers;
  }
  /*
   * set headers
   *
   * @return void
   */
  public function setHeaders($headers)
  {
    $this->headers = array_merge($this->headers, $headers);
  }

  /*
   * get status
   *
   * @return int
   */
  public function getStatus()
  {
  return $this->status;
  }
  /*
   * set status
   *
   * @return void
   */
  public function setStatus($status)
  {
    $this->status = $status;
  }

  /*
   * return url to error docs
   *
   * @method errorUrl
   *
   * @param int $error_code
   *
   * @return string
   */
  private function errorUrl( $errorCode )
  {
    return $this->devUrl.'errors/#'.$errorCode;
  }

  /*
   * return info url
   *
   * @method infoUrl
   *
   * @param string $handle
   *
   * @return string
   */
  private function infoUrl( $handle )
  {
    return $this->devUrl.$handle;
  }

  /*
   * return a response
   *
   * @method respond
   *
   * @param array $data
   * @param int $status
   * @param array $headers
   *
   * @return Illuminate\Http\Response
   */
  public function respond($data, $status = HTTP_UNAUTHORIZED, $headers = [])
  {
    $this->response->setContent($data);
    $this->response->setStatusCode($this->getStatus());

    foreach($this->getHeaders() as $type => $value){
      $this->response->header($type, $value);
    }

    return $this->response;
  }

  /*
   * respond with error
   *
   * @method error
   *
   * @param array $data
   * @param int $status
   * @param array $headers
   *
   * @return Illuminate\Http\Response
   */
  public function error($data, $status = 400, $headers = [])
  {
    $error = array_merge(
      ['status' => $status],
      $data
    );

    if( is_null($error['code']) )
    {
      unset($error['code']);
    }

    if( isset($error['code']) && is_int($error['code']) )
    {
      $error['links'] = [
        'about' => $this->errorUrl($error['code'])
      ];
    }

    return $this->respond(
      ['errors' =>
        [
          'error' => $error
        ]
      ], $status, $headers);
  }

  /*
   * respond with Data
   *
   * @method withData
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function withData($data)
  {
    $data = array_merge([
        "jsonapi" => ["version" => "1.0"]
      ], $data
    );

    return $this->respond($data, $this->getStatus());
  }

  /*
   * respond ok
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function ok($data)
  {
    $this->setStatus(200);

    return $this->withData($data);
  }

  /*
   * respond noContent
   *
   * @return Illuminate\Http\Response
   */
  public function noContent()
  {
    $this->setStatus(204);

    return $this->respond(null, $this->getStatus());
  }

}
