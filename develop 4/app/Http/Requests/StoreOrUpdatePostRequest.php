<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdatePostRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')
            ],
            'excerpt' => [
                'required',
                'string',
                'max:500',
            ],
            'content' => [
                'required',
                'string',
                'max:2000',
            ],
            'tags' => [
                'array',
                'max:5'
            ],
            'tags.*' => [
                'string',
                'max:50',
                'distinct'
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title must be unique.',
            'excerpt.required' => 'The excerpt is required.',
            'excerpt.max' => 'The excerpt may not be greater than 500 characters.',
            'content.required' => 'The content is required.',
            'content.max' => 'The content may not be greater than 2000 characters.',
            'tags.array' => 'The tags must be an array.',
            'tags.max' => 'You may not specify more than 5 tags.',
            'tags.*.string' => 'Each tag must be a string.',
            'tags.*.max' => 'Each tag may not be greater than 50 characters.',
        ];
    }
}
