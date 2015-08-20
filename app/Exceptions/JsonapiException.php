<?php namespace App\Exceptions;

use App\ValueObjects\JsonapiError;
use Lukasoppermann\Httpstatus\Httpstatuscodes;

class JsonapiException extends \Exception implements Httpstatuscodes
{
    protected $errorObject;

    public function __construct($message = 'Unknown exception', $code = 0, JsonapiError $errorObject)
    {
        $this->errorObject = $errorObject;
        parent::__construct($message, $code, null);
    }

    public function errorObject()
    {
        return [
            'errors' => [
                $this->errorObject->get(),
            ],
        ];
    }
}
