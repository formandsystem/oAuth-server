<?php

class ClientTest extends BasetestCase
{
    public function getAccessToken()
    {
        return $this->call('POST', '/access_token', [
            'client_id' => 'test_cms_id',
            'client_secret' => 'test_cms_secret',
            'grant_type' => 'client_credentials',
            'scope' => 'client.read,client.create,client.delete,client.update',
        ], [], [], ['HTTP_Accept' => 'application/json']);
    }
    /**
     * OPTIONS /client
     * @test
     */
    public function Options_of_client_route()
    {
        $response = $this->call('OPTIONS', '/client');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * POST /client
     * @test
     */
    public function Create_a_client()
    {
        $token = json_decode($this->getAccessToken()->getContent())->data->id;
        $response = $this->call('POST', '/client', ['access_token' => $token], [], [], ['HTTP_Accept' => 'application/json', 'HTTP_Authorizer' => 'Bearer '.$token]);

        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * POST /client
     * @test
     */
    public function Get_a_client_by_id()
    {
        $token = json_decode($this->getAccessToken()->getContent())->data->id;
        $response = $this->call('GET', '/client/test_client_id', ['access_token' => $token], [], [], ['HTTP_Accept' => 'application/json', 'HTTP_Authorizer' => 'Bearer '.$token]);
        // print_r($response);
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(200, $response->status());
    }
}
