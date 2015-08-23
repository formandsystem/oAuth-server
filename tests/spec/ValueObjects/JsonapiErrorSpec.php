<?php

namespace spec\App\ValueObjects;

use PhpSpec\ObjectBehavior;

class JsonapiErrorSpec extends ObjectBehavior
{
    public function let()
    {
        $error = [];
        $this->beConstructedWith($error);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\ValueObjects\AbstractValueObject');
        $this->shouldHaveType('App\ValueObjects\JsonapiError');
    }

}
