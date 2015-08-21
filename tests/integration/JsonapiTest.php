<?php

class JsonapiTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_options_on_jsonapi()
    {
        $response = $this->client->options('jsonapi', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response, 'OPTIONS,GET');
        $this->checkStatusCode(self::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function request_get_on_jsonapi()
    {
        $response = $this->client->get('jsonapi', [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
        $this->checkDefaultHeader($response);
        $this->checkStatusCode(self::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_decode($response->getBody()->getContents(), true), [
          'jsonapi' => [
            'version' => '1.0',
          ],
        ]);
    }
}
