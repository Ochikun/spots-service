<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required','exists:categories,id'],
            'title' => ['nullable','max:255'],
            'body' => ['nullable','max:2000'],
            'date' => ['required','date'],
            'image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,heic,heif',
                'max:4000'
            ],
        ];
    }
}
