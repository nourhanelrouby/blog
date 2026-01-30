<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

class TagStoreRequest extends FormRequest
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
            'ar' => 'required|array',
            'en' => 'required|array',
            'fr' => 'required|array',

            'ar.*' => 'required|string|max:255',
            'en.*' => 'required|string|max:255',
            'fr.*' => 'required|string|max:255',
        ];
    }
}
