<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be a character string.',
            'required' => 'The :attribute field is not blank.',
            'exists' => 'The :attribute field does not exist, please register an :attribute!',
            'max' => [
                'number' => 'The :attribute field no greater than :max.',
                'file' => 'The :attribute field is not more than :max KB.',
                'string' => 'The :attribute field is not more than :max characters.',
                'array' => 'The :attribute field is not more than :max item.',
            ],
        ];
    }
}
