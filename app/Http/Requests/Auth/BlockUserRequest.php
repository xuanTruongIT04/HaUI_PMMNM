<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class BlockUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute is not blank.',
            'exists' => 'The :attribute does not exist, please register an :attribute!',
        ];
    }
}
