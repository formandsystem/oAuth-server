<?php

class ClientTest extends BasetestCase
{
    /**
     * OPTIONS /client
     *
     * @return void
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
     * @return void
     */
    public function testPostClient()
    {
        $response = $this->call('POST', '/client');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
    /**
     * POST /client
     *
     * @return void
     */
    public function testGetClientById()
    {
        $response = $this->call('GET', '/client/1');
        $this->checkDefaultHeader($response);
        $this->checkAuthHeader($response);
        $this->assertEquals(204, $response->status());
    }
}
