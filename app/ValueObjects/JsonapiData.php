<?php

namespace App\ValueObjects;

class JsonapiData extends AbstractValueObject
{
    // make sure to include / at the end
    protected $devUrl = 'http://dev.formandsystem.com/';

    public function __construct($value)
    {
        parent::__construct($value);

        $this->value['jsonapi'] = ['version' => '1.0'];
    }
}
