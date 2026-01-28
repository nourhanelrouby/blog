<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'facebook' => 'required|string',
            'instagram' => 'required|string',
            'twitter' => 'required|string',
            'linkedin' => 'required|string',
            'phone' => 'required|numeric',
            'email' => 'required|string|email',

            'ar'=>'required|array',
            'en'=>'required|array',
            'fr'=>'required|array',

            'ar.*' => 'required|string',
            'en.*' => 'required|string',
            'fr.*' => 'required|string',
        ];
    }
}
