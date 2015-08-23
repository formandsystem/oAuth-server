<?php

namespace App\Http\Controllers;

use App\ValueObjects\JsonapiData;

class JsonapiController extends ApiController
{
    /*
   * @method: GET
   */
  public function getJsonApi()
  {
      return response(new JsonapiData([]), self::HTTP_OK);
  }
  /*
   * @method: OPTIONS
   */
  public function optionsJsonApi()
  {
      header('Access-Control-Allow-Methods: OPTIONS,GET');

      return response(null, self::HTTP_NO_CONTENT);
  }
}
