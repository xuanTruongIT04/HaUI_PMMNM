<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users',
            'old_password' => 'required|string|min:6',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be a character string.',
            'required' => 'The :attribute field is not blank.',
            'exists' => 'The account does not exist, please register an account!',
            'confirmed' => 'The :attribute field confirmation does not match.',
            'max' => [
                'number' => 'The :attribute field no greater than :max.',
                'file' => 'The :attribute field is not more than :max KB.',
                'string' => 'The :attribute field is not more than :max characters.',
                'array' => 'The :attribute field is not more than :max item.',
            ],
            'min' => [
                'numeric' => 'The :attribute field is not better than:min.',
                'file' => 'The :attribute field is not less than :min KB.',
                'string' => 'The :attribute field is not less than :min characters.',
                'array' => 'The :attribute field must have at least :items.',
            ],

        ];
    }
}
