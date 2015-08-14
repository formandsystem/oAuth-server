<?php

class ValidateTokenTest extends BasetestCase
{
    /**
     * Get /
     *
     */
    public function testOptionsValidateToken()
    {
        $response = $this->call('OPTIONS', '/validate_token');
        $this->checkDefaultHeader($response);

        $this->assertEquals(204, $response->status());
    }
}
