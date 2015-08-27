<?php

namespace spec\App\ValueObjects;

use SpecTestCase;

class JsonapiDataSpec extends SpecTestCase
{
    public function let()
    {
        $data = [
            'id' => 1,
            'type' => 'data',
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
        $this->get()['jsonapi']->shouldHaveKeyWithValue('version', '1.0');
    }

    public function it_should_return_json_when_accessed_as_a_string()
    {
        $this->shouldBeJson($this->getWrappedObject()->__toString());
    }

    public function it_should_throw_exception_if_no_value_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException("A value must be specified for App\ValueObjects\JsonapiData."))->during__construct(null);
    }

    public function it_should_throw_exception_if_wrong_value_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException('A resource object must not contain a member of type "wrong".'))->during__construct([
            'id' => 1,
            'type' => 'test',
            'wrong' => 'wrong',
        ]);
    }

    public function it_should_throw_exception_if_id_or_type_missing()
    {
        $this->shouldThrow(new \InvalidArgumentException('A resource object must at least contain a member of type "id" and "type".'))->during__construct([
            'type' => 'test',
        ]);
        $this->shouldThrow(new \InvalidArgumentException('A resource object must at least contain a member of type "id" and "type".'))->during__construct([
            'id' => 1,
        ]);
    }
}
