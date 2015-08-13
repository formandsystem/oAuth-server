<?php

namespace spec\App\Http;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Http\Response;
use Lukasoppermann\Httpstatus\Httpstatus;

class RespondSpec extends ObjectBehavior
{
    function let(Response $response, Httpstatus $status)
    {
        $this->beConstructedWith($response, $status);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Http\Respond');
    }

    function it_should_let_url_be_configured()
    {
        $this->getUrl()->shouldNotBe('http://test.com');
        $this->setUrl('http://test.com');
        $this->getUrl()->shouldBe('http://test.com');
    }

    
}
