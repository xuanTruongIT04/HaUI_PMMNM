<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'The :attribute field field must be a character string.',
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
