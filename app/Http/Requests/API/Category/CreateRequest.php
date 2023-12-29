<?php

namespace App\Http\Requests\API\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'parent_id' => ['nullable', 'integer' ,'exists:categories,id'],
            'menu_id' => ['required','integer', 'exists:menus,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
