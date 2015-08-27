<?php

class AccessTokenTest extends BasetestCase
{
    /*
     * @test
     */
    public function options_token()
    {
        $response = $this->client->options('token', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response, 'OPTIONS, POST');
        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function options_validate_token()
    {
        $response = $this->client->options('token/:token:', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response);

        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_access_token()
    {
        $response = $this->client->post('/token', ['form_params' => [
            'client_id' => 'test_client_id',
            'client_secret' => 'test_client_secret',
            'grant_type' => 'client_credentials',
            'scope' => 'content.read',
            ],
            'headers' => [
                'Accept' => 'application/json',
            ], ]
        );
        $responseArray = json_decode($response->getBody()->getContents(), true);

        $this->validateArray([
            'id' => $responseArray['id'],
            'type' => 'access_token',
            'attributes' => [
                'access_token' => $responseArray['id'],
                'token_type' => 'Bearer',
                'expires_in' => 3600,
                'expire_time' => $responseArray['attributes']['expire_time'],
            ],
        ], $responseArray);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_OK, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_access_token_invalid_credentials()
    {
        $response = $this->client->post('/token', ['form_params' => [
            'client_id' => 'test_client_id',
            'client_secret' => 'invalid_secret',
            'grant_type' => 'client_credentials',
            'scope' => 'content.read',
            ],
            'headers' => [
                'Accept' => 'application/json',
            ], ]
        );
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_access_token_invalid_scope_requested()
    {
        $response = $this->client->post('/token', ['form_params' => [
            'client_id' => 'test_client_id',
            'client_secret' => 'test_client_secret',
            'grant_type' => 'client_credentials',
            'scope' => 'client.read,client.create',
            ],
            'headers' => [
                'Accept' => 'application/json',
            ], ]
        );
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function validate_valid_token()
    {
        // test valid token
        $response = $this->client->post('token/valid_access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer token_validation_token',
            ],
            'form_params' => [
                'scopes' => 'content.read',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function validate_valid_token_invalid_request_token()
    {
        // test valid token
        $response = $this->client->post('token/valid_access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer valid_access_token',
            ],
            'form_params' => [
                'scopes' => 'content.read',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function validate_expired_token()
    {
        // test valid token
        $response = $this->client->post('token/expired_access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer token_validation_token',
            ],
            'form_params' => [
                'scopes' => 'content.read',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_FORBIDDEN, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function validate_not_existing_token()
    {
        // test valid token
        $response = $this->client->post('token/not_found_access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer token_validation_token',
            ],
            'form_params' => [
                'scopes' => 'content.read',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_FORBIDDEN, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function validate_invalid_scope()
    {
        // test valid token
        $response = $this->client->post('token/valid_access_token', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer token_validation_token',
            ],
            'form_params' => [
                'scopes' => 'client.read',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
