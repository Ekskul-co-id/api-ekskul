<?php

namespace App\Http\Requests\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,jpg,png,svg|max:2048',
            'message' => 'required|string',
            'type' => 'required|in:private,public',
            'user_id' => 'required_if:type,private|integer',
        ];
    }
}
