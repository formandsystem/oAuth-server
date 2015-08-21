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

            return $this->respond->success(
            ['data' => [
              'id' => $token['access_token'],
              'type' => 'access_token',
              'attributes' => [
                $token,
              ],
            ],
          ],
          200
        );
        } catch (\Exception $e) {
            return $this->catchException($e);
        }
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
      try {
          dd($this->request->input('scopes'));

          $this->authorizer->validateAccessToken(true, $token);
          $scopes = array_map('trim', explode(',', $this->request->input('scope')));
          $this->hasScopes($scopes);

          return $respond->success(null, 204);
      } catch (\Exception $e) {
          return $this->catchException($e);
      }
  }
}
