<?php namespace App\Http;

use Illuminate\Http\Response;
use Lukasoppermann\Httpstatus\Httpstatus;

class Respond{
  // response
  protected $response;
  protected $request;
  protected $httpstatus;
  protected $status;
  // make sure to include / at the end
  protected $devUrl = "http://dev.formandsystem.com/";

  function __construct(Response $response, Httpstatus $httpstatus)
  {
    $this->response = $response;
    $this->httpstatus = $httpstatus;
  }

    /*
     * set devUrl
     */
    public function setUrl($url)
    {
      $this->devUrl = $url;
    }

    /*
     * get devUrl
     */
    public function getUrl()
    {
      return $this->devUrl;
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
    public function setStatus($statusCode)
    {
      if(!is_int($statusCode) || strlen($statusCode) !== 3){
        throw new InvalidArgumentException('An error code needs to be provided.');
      }
      $this->status = $statusCode;
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
      return $this->getUrl().'errors/#'.$errorCode;
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
      return $this->getUrl().$handle;
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
     *
     * @return Illuminate\Http\Response
     */
    public function error($data = [], $statusCode)
    {
      $this->setStatus($statusCode);

      $error = array_merge(
        [
          'status' => $this->getStatus(),
          'title' => $this->httpstatus->getReasonPhrase($this->getStatus())
        ],
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
     * respond with Data
     *
     * @method withData
     *
     * @param array $data
     *
     * @return Illuminate\Http\Response
     */
    public function success($data = null, $statusCode)
    {
      $this->setStatus($statusCode);

      if( $data !== null )
      {
        $data = array_merge([
            "jsonapi" => ["version" => "1.0"]
          ], $data
        );
      }

      return $this->respond($data);
    }

}
