<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'birthday' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|min:10|max:13',
            'address' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'string' => 'The :attribute field must be a character string.',
            'required' => 'The :attribute field is not blank.',
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
