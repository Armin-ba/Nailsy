<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'price' => ['required', 'integer', 'min:1000'],
            'duration_min' => ['required', 'integer', 'min:15', 'max:240'],
        ];
    }
}
