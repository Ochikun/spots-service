<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'image' => [
                'nullable',
                'file:image',
                'max:6000',
                'mimes:jpeg,jpg,png,heic,heif',
            ],
            'introduction' => ['nullable','string','max:255'],
        ];
    }
}
