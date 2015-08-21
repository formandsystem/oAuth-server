<?php

class BasetestCase extends TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://oauth.formandsystem.app',
            'exceptions' => false,
        ]);
        parent::setUp();
    }
    /*
     * checks default header.
     */
    public function checkDefaultHeader($response, $allowedMethods = null)
    {
        $this->assertEquals('application/vnd.formandsystem.oauth.v1+json', $response->getHeader('content-type')[0], 'Checking content type header:');
        $this->assertEquals('*', $response->getHeader('access-control-allow-origin')[0]);

        if ($allowedMethods !== null) {
            $this->assertEquals($allowedMethods, $response->getHeader('access-control-allow-methods')[0]);
            // allowMethods is only needed in OPTIONS, where allowedHeaders are also needed
            $this->assertEquals('Authorization, Content-Type, Accept', $response->getHeader('access-control-allow-headers')[0]);
        }
    }

      /*
       * checks credentials header
       */
      public function checkAuthHeader($response)
      {
          $this->assertEquals('true', $response->getHeader('access-control-allow-credentials')[0]);
      }
}
