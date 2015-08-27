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
                'Authorization' => 'Bearer test_cms_id',
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
                'Authorization' => 'Bearer test_cms_id',
            ],
        ]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->checkStatusCode(self::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
    /**
     * @test
     */
    public function create_client_missing_access_rights()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function get_client_by_id()
    {
        $response = $this->client->get('client/test_client_id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorizer' => 'Bearer test_cms_id',
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
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function get_client_by_id_missing_access_rights()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function update_client()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function update_client_missing_access_rights()
    {
        $this->fail('Missing implementation of test.');
    }
    /**
     * @test
     */
    public function update_client_client_not_found()
    {
        $this->fail('Missing implementation of test.');
    }
}
