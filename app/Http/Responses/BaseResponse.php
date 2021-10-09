<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class BaseResponse implements Responsable
{
    protected $status;
    protected $data;
    protected $errors;
    protected $message;
    protected $customAttributes = [];

    public function __construct(
        $status = 200,
        $data = [],
        $errors = null,
        $message = 'Success'
    ) {
        $this->status = $status;
        $this->data = $data;
        $this->errors = $errors;
        if (is_null($message)) {
            $this->message = 'Success';
        } else {
            $this->message = $message;
        }
    }

    public function addCustomAttribute($key, $value)
    {
        if (
            array_key_exists($key, $this->customAttributes)
            && is_array($this->customAttributes[$key])
            && is_array($value)
        ) {
            $this->customAttributes[$key] = array_merge($this->customAttributes[$key], $value);
        } else {
            $this->customAttributes[$key] = $value;
        }
    }

    public function toResponse($request)
    {
        $payload = [
            'data' => $this->data,
            'message' => $this->message,
        ];
        if (!empty($this->errors)) {
            $payload['errors'] = $this->errors;
        }

        if (!empty($this->customAttributes)) {
            $payload = array_merge($payload, $this->customAttributes);
        }
        return response()
            ->json($payload, $this->status);
    }
}
