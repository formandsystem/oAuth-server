<?php

namespace app\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\ValueObjects\JsonapiError;

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
            return response(new JsonapiError([
                'code' => 102,
                'title' => 'Invalid client credentials',
                'detail' => 'You must provide valid client credentials as well as a valid grant type and scope.',
            ]), self::HTTP_BAD_REQUEST);
        }

        // add expire_time
        $tokenFromDb = $this->db->table('oauth_access_tokens')->where('id', $token['access_token'])->first();
        $token['expire_time'] = (int) $tokenFromDb->expire_time;

        return response([
                'id' => $token['access_token'],
                'type' => 'access_token',
                'attributes' => $token,
            ],
            self::HTTP_OK
        );
    }
    /*
     * options for create access token
     */
    public function optionsAccessToken()
    {
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return response(null, self::HTTP_NO_CONTENT);
    }
    /*
     * @method: OPTIONS
    */
    public function optionsValidateToken()
    {
        header('Access-Control-Allow-Methods: OPTIONS, POST');

        return response(null, self::HTTP_NO_CONTENT);
    }
    /*
     * validate an access token and return scopes
    */
    public function validateToken($token)
    {
        // validate request access token
        $validateAccess = $this->hasAccessOrFail(['token.validate']);
        if ($validateAccess !== true) {
            return response($validateAccess, self::HTTP_UNAUTHORIZED);
        }

        // check provided token
        if ($this->isValidToken($token) === false) {
            return response(new JsonapiError([
                'code' => 200,
                'title' => 'Invalid access token',
                'detail' => 'The access token you checked is invalid, it may be wrong or expired.',
            ]), self::HTTP_FORBIDDEN);
        }
        // get scope & check provided scope
        $scopes = array_map('trim', explode(',', $this->request->input('scopes')));

        if ($this->hasScopes($token, $scopes) === false) {
            return response(new JsonapiError([
                'code' => 201,
                'title' => 'Invalid scope',
                'detail' => 'The access token you checked does not have the desired access rights.',
            ]), self::HTTP_FORBIDDEN);
        }

        return response(null, self::HTTP_NO_CONTENT);
    }
}
