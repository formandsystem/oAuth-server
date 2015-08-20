<?php namespace app\Http\Controllers;

use App\Http\Controllers\ApiController as ApiController;

class TokenController extends ApiController
{
    /*
   * get an access token using a client_id and client_secret
   */
  public function getAccessToken()
  {
      try {
          $token = $this->authorizer->issueAccessToken();
          return $this->respond->success(
        ['data' =>
          [
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
   * @method: OPTIONS
   */
  public function optionsValidateToken()
  {
      return $this->respond->success(null, 204);
  }
  /*
   * validate an access token and return scopes
   */
  public function validateAccessToken()
  {
      try {
          $this->authorizer->validateAccessToken(true);
          $scopes = array_map('trim', explode(',', $this->request->input('scope')));
          $this->hasScopes($scopes);

          return $respond->success(null, 204);
      } catch (\Exception $e) {
          return $this->catchException($e);
      }
  }
}
