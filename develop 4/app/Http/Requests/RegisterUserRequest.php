<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => [
                'required',
                'min:3',
                'max:20',
                Rule::unique('users', 'user_name')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/[0-9]/',           // At least one number
                'regex:/[a-z]/',           // At least one lowercase letter
                'regex:/[A-Z]/',           // At least one uppercase letter
                'regex:/[#@$!%*?&]/',       // At least one special character
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.min' => 'The password must be at least 8 characters long.',
            'password.regex' => 'The password must include at least one number, one lowercase letter, one uppercase letter, and one special character.',
        ];
    }
}
