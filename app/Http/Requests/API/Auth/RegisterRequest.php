<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email','string', 'max:254','unique:users'],
            'password' => ['required','min:5','max:40'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
