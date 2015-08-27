<?php

class ClientTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_options_of_client_route()
    {
        $response = $this->client->options('client', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_a_client()
    {
        $response = $this->client->post('client', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
            'form_params' => [
                'client_name' => 'created_by_test',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_CREATED, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_client_missing_client_name()
    {
        $response = $this->client->post('client', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_client_missing_access_rights()
    {
        $response = $this->client->post('client', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function get_client_by_id()
    {
        $response = $this->client->get('client/test_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_OK, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function get_client_by_id_not_found()
    {
        $response = $this->client->get('client/not_found_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_NOT_FOUND, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function get_client_by_id_missing_access_rights()
    {
        $response = $this->client->get('client/test_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer test_client_id',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function update_client()
    {
        $response = $this->client->put('client/test_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);
        $this->markTestSkipped('Not yet done');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_OK, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function update_client_missing_access_rights()
    {
        $response = $this->client->put('client/test_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer test_client_id',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function update_client_client_not_found()
    {
        $response = $this->client->put('client/not_found_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_NOT_FOUND, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function delete_client()
    {
        $response = $this->client->delete('client/test_delete_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function delete_client_missing_access_rights()
    {
        $response = $this->client->delete('client/test_delete_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer test_delete_client_id',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function delete_client_client_not_found()
    {
        $response = $this->client->delete('client/test_delete_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer cms_token',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
