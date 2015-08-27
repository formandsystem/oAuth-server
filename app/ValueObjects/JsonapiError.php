<?php

namespace App\ValueObjects;

use InvalidArgumentException;

class JsonapiError extends AbstractValueObject
{
    // make sure to include / at the end
    protected $devUrl = 'http://dev.formandsystem.com/';

    protected $allowedKeys = [
        'id',
        'links',
        'status',
        'code',
        'title',
        'detail',
        'source',
        'meta',
    ];

    public function __construct($value)
    {
        // add about link if code is given
        if (isset($value['code'])) {
            $value['links']['about'] = $this->errorLink($value['code']);
        }

        parent::__construct($value);
    }

    protected function validateValue($value)
    {
        foreach ($value as $k => $v) {
            if (!in_array($k, $this->allowedKeys)) {
                throw new InvalidArgumentException('An error object must not contain a member of type "'.$k.'".');
            }
        }

        return $value;
    }

    private function errorLink($code)
    {
        return trim($this->devUrl, '/').'/errors/#'.$code;
    }

    protected function _set($value)
    {
        return [
            'errors' => $value,
        ];
    }
}
