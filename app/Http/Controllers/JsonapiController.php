<?php namespace App\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;

class JsonapiController extends ApiController
{
  /*
   * error when trying to get /
   */
  function index()
  {
      return $this->respond->error([
        'code' => 100,
        'title' => 'Invalid endpoint'
      ], 404);
  }
  /*
   * get request to /jsonapi
   */
  function getJsonApi()
  {
    return $this->respond->success([
      'jsonapi' => [
        'version' => '1.0'
      ]
    ], 200);
  }

}
