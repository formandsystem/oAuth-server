<?php

namespace App\Http\Controllers;

class JsonapiController extends ApiController
{
    /*
    * @method: GET
    */
    public function getJsonApi()
    {
        return response(json_encode([
            'jsonapi' => [
                'version' => '1.0',
            ]
        ]), self::HTTP_OK);
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
