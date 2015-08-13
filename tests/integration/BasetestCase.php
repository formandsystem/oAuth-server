<?php

class BasetestCase extends TestCase
{

      /**
       * checkDefaultHeader
       */
      public function checkDefaultHeader($response, $allowedMethods = null)
      {
          $this->assertEquals('application/vnd.formandsystem.oauth.v1+json', $response->headers->get('content-type'));
          $this->assertEquals('*', $response->headers->get('access-control-allow-origin'));

          if($allowedMethods !== null){
            $this->assertEquals($allowedMethods, $response->headers->get('access-control-allow-methods'));
            // allowMethods is only needed in OPTIONS, where allowedHeaders are also needed
            $this->assertEquals('Authorization, Content-Type, Accept', $response->headers->get('access-control-allow-headers'));
          }
      }

      /**
       * checkAuthHeader
       */
      public function checkAuthHeader($response)
      {
          $this->assertEquals('true', $response->headers->get('access-control-allow-credentials'));
      }

}
