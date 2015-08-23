<?php

namespace spec\App\ValueObjects;

use PhpSpec\ObjectBehavior;

class JsonapiDataSpec extends ObjectBehavior
{
    public function let()
    {
        $data = [
            'id' => '1',
            'type' => 'data'
        ];
        $this->beConstructedWith($data);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\ValueObjects\AbstractValueObject');
        $this->shouldHaveType('App\ValueObjects\JsonapiData');
    }

    public function it_adds_jsonapi_info()
    {
        $this->get()->shouldBeArray();
        $this->get()->shouldHaveKey('jsonapi');
        $this->get()['jsonapi']->shouldHaveKeyWithValue('version','1.0');
    }

    public function it_should_return_json_when_accessed_as_a_string()
    {

        // $this->__toString()->shouldBeTrue(is_object(json_decode((string)$this)));
    }

    public function it_should_throw_exception_if_no_value_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException("A value must be specified for App\ValueObjects\JsonapiData."))->during__construct(null);
    }

}
