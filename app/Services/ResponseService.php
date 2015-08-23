<?php

namespace App\Services;
use Illuminate\Http\Response;

class ResponseService
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
