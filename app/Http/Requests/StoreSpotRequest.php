<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpotRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable','max:255'],
            'body' => ['nullable','max:2000'],
            'date' => ['required','date'],
            'image' =>[
                'nullable',
            ],
            'category_id' => ['required','exists:categories,id'],
            'lat' => ['required'],
            'lng' => ['required'],
        ];
    }
}
