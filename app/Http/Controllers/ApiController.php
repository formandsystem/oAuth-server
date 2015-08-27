<?php

namespace App\Http\Controllers;

use App\ValueObjects\JsonapiError;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use League\OAuth2\Server\Exception as LeagueException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class ApiController extends BaseController implements Httpstatuscodes
{
    protected $response;
    protected $request;
    protected $authorizer;
    protected $db;

    public function __construct(Response $response, Request $request, Authorizer $authorizer)
    {
        $this->response = $response;
        $this->request = $request;
        $this->authorizer = $authorizer;
        $this->db = app('db');
    }
    /*
     * validates the token provided in the request header and checks against needed scopes
     */
    protected function hasAccessOrFail($scopes)
    {
        $token = str_replace('Bearer ', '', $this->request->header('authorization'));

        if (!$this->isValidToken($token)) {
            return new JsonapiError([
                'code' => 100,
                'title' => 'Invalid request access token',
                'detail' => 'The access token used to perform the request may be wrong or expired.',
            ]);
        }

        if (!$this->hasScopes($token, $scopes)) {
            return new JsonapiError([
                'code' => 101,
                'title' => 'Invalid request scope',
                'detail' => 'You don\'t have the appropriate access rights to perform this request.',
            ]);
        }

        return true;
    }
    /*
     * validates the given token
     */
    protected function isValidToken($token)
    {
        try {
            $this->authorizer->validateAccessToken(false, $token);
        } catch (LeagueException\AccessDeniedException $e) {
            return false;
        }

        return true;
    }
    /*
    * check scopes
    */
    protected function hasScopes($token, $scopes)
    {
        // TODO: test if has scope can be fooled with empty string
        if (!$this->isValidToken($token) || $this->authorizer->hasScope($scopes) === false) {
            return false;
        }

        return true;
    }
}
