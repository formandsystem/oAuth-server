<?php

namespace App\ValueObjects;

use InvalidArgumentException;

class JsonapiData extends AbstractValueObject
{
    // make sure to include / at the end
    protected $devUrl = 'http://dev.formandsystem.com/';

    protected $allowedKeys = [
        'id',
        'type',
        'attributes',
        'relationships',
        'links',
        'meta',
    ];

    public function _set($value)
    {
        $value['jsonapi'] = ['version' => '1.0'];

        return $value;
    }

    public function validateValue($value)
    {
        if (!isset($value['id']) || !isset($value['type'])) {
            throw new InvalidArgumentException('A resource object must at least contain a member of type "id" and "type".');
        }

        foreach ($value as $k => $v) {
            if (!in_array($k, $this->allowedKeys)) {
                throw new InvalidArgumentException('A resource object must not contain a member of type "'.$k.'".');
            }
        }

        return $value;
    }
}
