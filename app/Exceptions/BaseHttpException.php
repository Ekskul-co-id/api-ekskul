<?php

namespace App\Exceptions;

class BaseHttpException extends BaseException
{
    protected $status;
    protected $message;
    protected $errors;
    protected $customAttributes;

    public function __construct($status, $message, $errors = null, $data = [])
    {
        $this->addCustomAttribute('status', false);
        $this->addCustomAttribute('data', $data);
        parent::__construct($status, $message, $errors);
    }
}
