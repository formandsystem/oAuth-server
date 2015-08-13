<?php

class NonResourceTest extends BasetestCase
{
    /**
     * Get /
     *
     * @return void
     */
    public function testGetRoot()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(404, $response->status());
        $this->assertEquals($response->getOriginalContent(), [
          "errors" => [
           "error" => [
             "status" => 404,
             "title" => "Invalid endpoint",
             "code" => 100,
             "links" => [
               "about" => "http://dev.formandsystem.com/errors/#100"
             ]
           ]
          ]
        ]);
    }


    /**
     * Options /
     *
     * @return void
     */
    public function testOptionsJsonapi()
    {
        $response = $this->call('OPTIONS', '/jsonapi',[],[],[],['HTTP_Accept' => 'application/json'],[]);

        $this->checkDefaultHeader($response, 'OPTIONS,GET');
        $this->assertEquals(204, $response->status());
    }

    /**
     * Get /
     *
     * @return void
     */
    public function testGetJsonapi()
    {
        $response = $this->call('GET', '/jsonapi',[],[],[],['HTTP_Accept' => 'application/json'],[]);
        $this->checkDefaultHeader($response);

        $this->assertEquals(200, $response->status());
        $this->assertEquals($response->getOriginalContent(), [
          "jsonapi" => [
            "version" => "1.0"
          ]
        ]);
    }
}
