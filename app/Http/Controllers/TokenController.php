<?php

namespace app\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;

class TokenController extends ApiController
{
    /*
   * get an access token using a client_id and client_secret
   */
    public function createAccessToken()
    {
        $token = $this->authorizer->issueAccessToken();

        return $this->respond->success(
            ['data' => [
                'id' => $token['access_token'],
                'type' => 'access_token',
                'attributes' => [
                    $token,
                ],
            ]],
          200
        );
    }
    /*
     * options for create access token
     */
    public function optionsAccessToken()
    {
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return $this->respond->success(null, self::HTTP_NO_CONTENT);
    }
    /*
     * @method: OPTIONS
    */
    public function optionsValidateToken()
    {
        header('Access-Control-Allow-Methods: OPTIONS, GET');

        return $this->respond->success(null, 204);
    }
    /*
     * validate an access token and return scopes
    */
    public function validateToken($token)
    {
        $scopes = array_map('trim', explode(',', $this->request->input('scope')));
        $this->validateAccess($scopes);

        return $respond->success(null, 204);
    }
}
