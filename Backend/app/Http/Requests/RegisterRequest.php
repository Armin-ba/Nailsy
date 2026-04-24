<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
            'role' => ['required', 'in:user,artist'],

            'city' => ['required_if:role,artist', 'nullable', 'string', 'max:255'],
            'postal_code' => ['required_if:role,artist', 'nullable', 'string', 'max:20'],
            'street' => ['required_if:role,artist', 'nullable', 'string', 'max:255'],
            'house_number' => ['required_if:role,artist', 'nullable', 'string', 'max:50'],
            'salon_address' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
