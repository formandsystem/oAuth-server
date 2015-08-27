<?php

use Lukasoppermann\Httpstatus\Httpstatus;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class BasetestCase extends TestCase implements Httpstatuscodes
{
    protected $client;
    protected $httpstatus;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => env('TEST_BASE_URL'),
            'exceptions' => false,
        ]);
        $this->httpstatus = new Httpstatus();
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

    /*
     * check status code
     */
    public function checkStatusCode($expectedCode, $responseCode)
    {
        $errorText = 'Expected: '.$expectedCode.' ('.$this->httpstatus->getReasonPhrase($expectedCode).') but received '.$responseCode.' ('.$this->httpstatus->getReasonPhrase($responseCode).')';
        $this->assertEquals($expectedCode, $responseCode, $errorText);
    }
    /*
     * check array against expected array
     */
    public function validateArray($expected, $actual)
    {
        ksort($expected);
        ksort($actual);
        $this->assertSame($expected, $actual);
    }
}
