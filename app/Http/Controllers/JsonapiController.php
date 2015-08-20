<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;

class JsonapiController extends ApiController
{
    /*
   * @method: GET
   */
  public function getJsonApi()
  {
      return $this->respond->success([
      'jsonapi' => [
        'version' => '1.0',
      ],
    ], self::HTTP_OK);
  }
  /*
   * @method: OPTIONS
   */
  public function optionsJsonApi()
  {
      header('Access-Control-Allow-Methods: OPTIONS,GET');
      return $this->respond->success(null, self::HTTP_NO_CONTENT);
  }
}
