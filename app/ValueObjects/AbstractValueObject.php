<?php

namespace App\ValueObjects;

use InvalidArgumentException;

abstract class AbstractValueObject
{
    protected $value;

    public function __construct($value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException('A value must be specified for '.get_class($this).'.');
        }

        $this->value = $this->_set($this->validateValue($value));
    }
    /*
     * validates the given value
     */
    protected function validateValue($value)
    {
        return $value;
    }
    /*
     * return jsonapi error object
     */
    public function get()
    {
        return $this->value;
    }
    /*
     * return jsonapi error object
     */
    protected function _set($value)
    {
        return $value;
    }
    /*
     * return json string of error object
     */
    public function __toString()
    {
        if (is_string($this->value)) {
            return $this->value;
        }

        return json_encode($this->value);
    }
}
