<?php

namespace App\Http\Requests\API\Category;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'menu_id' => ['nullable', 'integer']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
