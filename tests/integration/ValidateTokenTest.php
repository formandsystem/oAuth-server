<?php

class ValidateTokenTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_options_validate_token()
    {
        $response = $this->client->options('token/:token:', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response);

        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
