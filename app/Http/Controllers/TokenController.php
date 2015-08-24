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
        try {
            $token = $this->authorizer->issueAccessToken();
        } catch (\Exception $e) {
            return $this->catchException($e);
        }

        return $this->respond->success(
            ['data' => [
                'id' => $token['access_token'],
                'type' => 'access_token',
                'attributes' => [
                    $token,
                ],
            ]],
          self::HTTP_OK
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
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return $this->respond->success(null, self::HTTP_NO_CONTENT);
    }
    /*
     * validate an access token and return scopes
    */
    public function validateToken($token)
    {
        try {
            // validate current user
            $this->validateAccess(['token.validate']);
        } catch (\Exception $e) {
            return $this->catchException($e);
        }

        $scopes = array_map('trim', explode(',', $this->request->input('scopes')));

        if (!$this->validateAccess($scopes, $token)) {
            return $this->respond->error([], self::HTTP_UNAUTHORIZED);
        }

        return $this->respond->success(null, self::HTTP_NO_CONTENT);
    }
}
