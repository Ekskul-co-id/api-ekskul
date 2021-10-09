<?php

namespace App\Http\Responses;

class DetailResponse extends BaseResponse
{
    public function __construct($data, $errors = null, $message = "success")
    {
        parent::__construct(200, $data, $errors, $message);
    }
}
