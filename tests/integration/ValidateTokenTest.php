<?php

class ValidateTokenTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_options_validate_token()
    {
        $response = $this->call('OPTIONS', '/validate_token');
        $this->checkDefaultHeader($response);

        $this->assertEquals(204, $response->status());
    }
}
