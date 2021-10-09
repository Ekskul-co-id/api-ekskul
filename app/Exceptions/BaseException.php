<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $status;
    protected $message;
    protected $errors;
    protected $customAttributes = [];

    public function __construct($status, $message, $errors = null, $customAttributes = null)
    {
        $this->status = $status;
        $this->message = $message;
        if (empty($errors)) {
            $this->errors = ['*' => $message];
        } else {
            $this->errors = $errors;
        }

        if (!empty($customAttributes)) {
            $this->customAttributes = $customAttributes;
        }
    }

    public function addCustomAttribute($key, $value)
    {
        $this->customAttributes[$key] = $value;
    }

    public function render($request)
    {
        $payload = [
            'status' => $this->status,
            'message' => $this->message,
            'errors' => $this->errors,
        ];

        if (!empty($this->customAttributes)) {
            $payload = array_merge($payload, $this->customAttributes);
        }
        asort($payload);

        return response()->json($payload, $this->status);
    }
}
