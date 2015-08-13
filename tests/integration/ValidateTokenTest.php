<?php

class ValidateTokenTest extends BasetestCase
{
    /**
     * Get /
     *
     * @return void
     */
    public function testOptionsValidateToken()
    {
        $response = $this->call('OPTIONS', '/validate_token');
        $this->checkDefaultHeader($response);

        $this->assertEquals(204, $response->status());
    }
}
