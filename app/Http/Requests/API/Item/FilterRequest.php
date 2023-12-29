<?php

namespace App\Http\Requests\API\Item;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'integer'],
            'menu_id' => ['nullable', 'integer']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
