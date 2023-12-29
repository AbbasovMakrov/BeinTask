<?php

namespace App\Http\Requests\API\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'discount_amount' => ['required','numeric','max:100']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
