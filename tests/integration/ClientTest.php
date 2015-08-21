<?php

class ClientTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_post_on_token()
    {
        return $this->call('POST', '/access_token', [
            'client_id' => 'test_cms_id',
            'client_secret' => 'test_cms_secret',
            'grant_type' => 'client_credentials',
            'scope' => 'client.read,client.create,client.delete,client.update',
        ], [], [], ['HTTP_Accept' => 'application/json']);
    }
    /**
     * @test
     */
    public function request_options_of_client_route()
    {
        $response = $this->call('OPTIONS', '/client');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * @test
     */
    public function request_post_create_a_client()
    {
        $token = json_decode($this->request_post_on_token()->getContent())->data->id;
        $response = $this->call('POST', '/client', ['access_token' => $token], [], [], ['HTTP_Content_Type' => 'application/json', 'HTTP_Accept' => 'application/json', 'HTTP_Authorizer' => 'Bearer '.$token]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * @test
     */
    public function request_get_client_by_id()
    {
        $token = json_decode($this->request_post_on_token()->getContent())->data->id;
        $response = $this->call('GET', '/client/test_client_id', ['access_token' => $token], [], [], ['HTTP_Accept' => 'application/json', 'HTTP_Authorizer' => 'Bearer '.$token]);
        // print_r($response);
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(200, $response->status());
    }
}
