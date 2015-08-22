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
            'scope' => 'content.read,client.read,client.create',
            ],
            'headers' => [
                'Accept' => 'application/json',
            ], ]
        );
        $this->checkDefaultHeader($response, 'POST');

        $this->checkStatusCode(self::HTTP_OK, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_access_token_invalid_credentials()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function create_access_token_invalid_scope_requested()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function validate_valid_token()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function validate_invalid_token()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function validate_invalid_scope()
    {
        $this->fail('Missing implementation of test.');
    }
}
