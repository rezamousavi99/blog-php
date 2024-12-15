<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'identifier' => 'required|string', // Use a single field 'identifier' for both email and username
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'identifier.required' => 'The username or email field is required.',
            'password.required' => 'The password field is required.',
        ];
    }
}
