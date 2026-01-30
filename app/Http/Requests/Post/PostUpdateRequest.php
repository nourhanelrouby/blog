<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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

            'ar.*' => 'required|string',
            'en.*' => 'required|string',
            'fr.*' => 'required|string',

            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ];
    }
}
