<?php

namespace App\ValueObjects;

class JsonapiData extends AbstractValueObject
{
    // make sure to include / at the end
    protected $devUrl = 'http://dev.formandsystem.com/';

    public function _set($value)
    {
        $value['jsonapi'] = ['version' => '1.0'];

        return $value;
    }
}
