<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Authentication\Rules\RealEmailValidator;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new RealEmailValidator],
            'password' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
