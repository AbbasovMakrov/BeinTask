<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required','string', 'email', 'max:254'],
            'password' => ['required','string','min:6'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
