<?php

namespace App\ValueObjects;

class JsonapiError extends AbstractValueObject
{
    // make sure to include / at the end
    protected $devUrl = 'http://dev.formandsystem.com/';

    public function __construct($value)
    {
        parent::__construct($value);

        // add about link if code is given
        if (isset($value['code'])) {
            $this->value['links']['about'] = $this->devUrl.'errors/#'.$value['code'];
        }
    }
}
