<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => 'integer',
            'offset' => 'integer',
            'order_by' => 'nullable|string|in:created_at,id',
            'order_direction' => 'nullable|string|in:asc,desc',
            'keyword' => 'nullable|string'
        ];
    }
}
