<?php

namespace spec\App\Http;

use Illuminate\Http\Response;
use Lukasoppermann\Httpstatus\Httpstatus;
use PhpSpec\ObjectBehavior;

class RespondSpec extends ObjectBehavior
{
    public function let(Response $response, Httpstatus $status)
    {
        $this->beConstructedWith($response, $status);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\Http\Respond');
    }

    public function it_should_let_url_be_configured()
    {
        $this->getUrl()->shouldNotBe('http://test.com');
        $this->setUrl('http://test.com');
        $this->getUrl()->shouldBe('http://test.com');
    }
}
