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

  function __construct(Response $response, Request $request)
  {
    $this->response = $response;
    $this->request = $request;
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
   * add header to response
   *
   * @param string $type
   * @param string $header
   *
   * @return void
   */
  public function addHeader( $type, $header )
  {
    $this->response->header($type, $header);
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
   *
   * @return Illuminate\Http\Response
   */
  public function respond($data)
  {
    $this->response->setContent($data);
    $this->response->setStatusCode($this->getStatus());

    return $this->response;
  }

  /*
   * respond with error
   *
   * @method error
   *
   * @param array $data
   * @param int $status
   *
   * @return Illuminate\Http\Response
   */
  public function error($data)
  {
    $error = array_merge(
      ['status' => $this->getStatus()],
      $data
    );

    if( array_key_exists('code', $error) && !is_null($error['code']) && is_int($error['code']) )
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
      ]);
  }
  /*
   * respond with AuthenticationFailed
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function AuthenticationFailed($data)
  {
    $this->setStatus(401);
    return $this->error($data);
  }
  /*
   * respond with forbidden
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function forbidden($data)
  {
    $this->setStatus(403);
    return $this->error($data);
  }
  /*
   * respond with notFound
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function notFound($data)
  {
    $this->setStatus(404);
    return $this->error($data);
  }
  /*
   * respond with NotAcceptable
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function NotAcceptable($data)
  {
    $this->setStatus(406);
    return $this->error($data);
  }
  /*
   * respond with NotAcceptable
   *
   * @param array $data
   *
   * @return Illuminate\Http\Response
   */
  public function UnsupportedMediaType($data)
  {
    $this->setStatus(415);
    return $this->error($data);
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

    return $this->respond($data);
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
