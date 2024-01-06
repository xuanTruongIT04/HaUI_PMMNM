<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|max:25|min:8|confirmed',
            'password_confirmation' => 'required|string|max:25|min:8',
            'role' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be a character string.',
            'required' => 'The :attribute field is not blank.',
            'doesntExist' => 'The :attribute field already exists, please choose another :attribute!',
            'unique' => 'The :attribute field already exists, please enter another email.',
            'email' => 'Email address must be an email address in a valid format!',
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
