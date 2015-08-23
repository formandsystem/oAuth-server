<?php

namespace spec\App\Services;

use Illuminate\Http\Response;
use PhpSpec\ObjectBehavior;

class ResponseServiceSpec extends ObjectBehavior
{
    public function let(Response $response)
    {
        $this->beConstructedWith($response);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\Services\ResponseService');
    }

}
