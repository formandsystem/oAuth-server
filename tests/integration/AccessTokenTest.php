<?php

class AccessTokenTest extends BasetestCase
{
    /**
     * Get /
     *
     * @return void
     */
    public function testOptionsAccessToken()
    {
        $response = $this->call('OPTIONS', '/access_token');
        $this->checkDefaultHeader($response, 'OPTIONS,POST');

        $this->assertEquals(204, $response->status());
    }
}
