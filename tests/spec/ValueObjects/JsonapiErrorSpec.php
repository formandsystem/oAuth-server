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

    public function it_should_return_json_when_accessed_as_a_string()
    {
        // $this->__toString()->shouldBeTrue(is_object(json_decode((string)$this)));
    }

    public function it_should_be_a_correct_jsonapi_error_object()
    {
        // $this->get()->shouldHaveKey('errors');
    }

    public function it_should_automatically_add_an_about_link()
    {
        # code...
    }

    public function it_should_throw_exception_if_no_value_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException("A value must be specified for App\ValueObjects\JsonapiError."))->during__construct(null);
    }
}
