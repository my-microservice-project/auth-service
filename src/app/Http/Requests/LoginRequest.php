<?php

namespace App\Http\Requests;

use App\Data\LoginData;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function payload(): LoginData
    {
        return LoginData::from($this->validated());
    }

}
