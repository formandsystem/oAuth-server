<?php

use PhpSpec\ObjectBehavior;

class SpecTestCase extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'beJson' => function ($string) {
                return is_object(json_decode((string) $string));
            },
        ];
    }
}
