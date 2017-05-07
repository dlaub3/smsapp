<?php

namespace Smsapp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|string|min:3|max:255',
          'email' => 'required|email|max:255|unique:users',
          'phone_number' => 'required|string|min:10|max:20|unique:users',
          'password' => 'required|min:6|max:30|confirmed',
        ];
    }
}
