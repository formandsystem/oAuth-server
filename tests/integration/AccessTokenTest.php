<?php

class AccessTokenTest extends BasetestCase
{
    /**
     * OPTIONS /access_token
     *
     */
    public function testOptionsAccessToken()
    {
        $response = $this->call('OPTIONS', '/access_token');
        $this->checkDefaultHeader($response, 'OPTIONS,POST');

        $this->assertEquals(204, $response->status());
    }
    /**
     * Post /access_token
     *
     * @return json
     */
    public function testPostAccessToken()
    {
        $response = $this->call('POST', '/access_token', [
        'client_id' => 'test_client_id',
        'client_secret' => 'test_client_secret',
        'grant_type' => 'client_credentials',
        'scope' => 'content.read,client.read,client.create',
      ], [], [], ['HTTP_Accept' => 'application/json']);
        $this->checkDefaultHeader($response, 'OPTIONS,POST');

        $this->assertEquals(200, $response->status());
    }
}
