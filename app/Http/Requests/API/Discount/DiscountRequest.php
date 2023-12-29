<?php

namespace App\Http\Requests\API\Discount;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer','max:100'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
