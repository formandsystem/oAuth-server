<?php

namespace App\ValueObjects;
use InvalidArgumentException;

abstract class AbstractValueObject
{
    protected $value;

    public function __construct($value)
    {
        if (!isset($value)) {
            throw new InvalidArgumentException('A value must be specified for '.get_class($this).'.');
        }

        $this->value = $this->validateValue($value);
    }
    /*
     * validates the given value
     */
    public function validateValue($value)
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
