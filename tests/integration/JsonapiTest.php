<?php

class JsonapiTest extends BasetestCase
{
    /**
     * @test
     */
    public function request_options_on_jsonapi()
    {
        $response = $this->call('OPTIONS', '/jsonapi', [], [], [], ['HTTP_Accept' => 'application/json'], []);

        $this->checkDefaultHeader($response, 'OPTIONS,GET');
        $this->assertEquals(204, $response->status());
    }

    /**
     * @test
     */
    public function request_get_on_jsonapi()
    {
        $response = $this->call('GET', '/jsonapi', [], [], [], ['HTTP_Accept' => 'application/json']);
        $this->checkDefaultHeader($response);

        $this->assertEquals(200, $response->status());
        $this->assertEquals($response->getOriginalContent(), [
          'jsonapi' => [
            'version' => '1.0',
          ],
        ]);
    }
}
