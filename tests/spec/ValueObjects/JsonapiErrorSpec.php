<?php

namespace spec\App\ValueObjects;

use SpecTestCase;

class JsonapiErrorSpec extends SpecTestCase
{
    protected $error = [
        'code' => 100,
    ];

    public function let()
    {
        $this->beConstructedWith($this->error);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\ValueObjects\AbstractValueObject');
        $this->shouldHaveType('App\ValueObjects\JsonapiError');
    }

    public function it_should_return_json_when_accessed_as_a_string()
    {
        $this->shouldBeJson($this->getWrappedObject()->__toString());
    }

    public function it_should_be_a_correct_jsonapi_error_object()
    {
        $this->get()->shouldHaveKey('errors');
        $this->get()['errors']->shouldBeArray();
    }

    public function it_should_automatically_add_an_about_link()
    {
        $this->get()->shouldBeArray();
        $this->get()['errors']->shouldHaveKey('links');
        $this->get()['errors']['links']->shouldHaveKeyWithValue('about', 'http://dev.formandsystem.com/errors/#'.$this->error['code']);
    }

    public function it_should_throw_exception_if_no_value_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException("A value must be specified for App\ValueObjects\JsonapiError."))->during__construct(null);
    }

    public function it_should_throw_exception_if_wrong_values_provided()
    {
        $this->shouldThrow(new \InvalidArgumentException('An error object must not contain a member of type "wrong".'))->during__construct([
            'code' => 100,
            'wrong' => 'test',
        ]);
    }
}
