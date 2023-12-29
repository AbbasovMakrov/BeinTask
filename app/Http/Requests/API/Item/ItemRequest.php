<?php

namespace App\Http\Requests\API\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required','int', Rule::exists("categories","id")],
            'price' => ['required', 'numeric'],
            'name' => ['required','string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
