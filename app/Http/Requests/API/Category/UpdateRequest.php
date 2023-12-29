<?php

namespace App\Http\Requests\API\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
