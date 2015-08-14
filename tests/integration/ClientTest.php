<?php

class ClientTest extends BasetestCase
{
    /**
     * OPTIONS /client
     *
     */
    public function testOptionsClient()
    {
        $response = $this->call('OPTIONS', '/client');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * POST /client
     *
     */
    public function testPostClient()
    {
        $response = $this->call('POST', '/client', [], [], [], ['HTTP_Accept' => 'application/json']);
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * POST /client
     *
     */
    public function testGetClientById()
    {
        $response = $this->call('GET', '/client/1', [], [], [], ['HTTP_Accept' => 'application/json']);
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
}
