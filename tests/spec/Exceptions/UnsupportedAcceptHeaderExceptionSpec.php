<?php

namespace spec\App\Exceptions;

use App\ValueObjects\JsonapiError;
use PhpSpec\ObjectBehavior;

class UnsupportedAcceptHeaderExceptionSpec extends ObjectBehavior
{
    public function let(JsonapiError $error)
    {
        $this->beConstructedWith('Unsupported Accept Header', 406, $error);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('\Exception');
        $this->shouldHaveType('App\Exceptions\UnsupportedAcceptHeaderException');
        $this->shouldImplement('Lukasoppermann\Httpstatus\Httpstatuscodes');
    }

}
