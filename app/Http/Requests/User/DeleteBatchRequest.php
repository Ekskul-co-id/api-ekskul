<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteBatchRequest extends FormRequest
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
            'id' => 'required|array|min:1',
            'id.*' => 'required|numeric|exists:users,id',
        ];
    }

    public function attributes()
    {
        return[
            'id.*' => 'User id',
        ];
    }
}
