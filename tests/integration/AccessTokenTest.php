<?php

class AccessTokenTest extends BasetestCase
{
    /*
     * @test
     */
    public function request_options_for_token()
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
    public function request_post_to_token()
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
}
