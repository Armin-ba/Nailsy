<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'available_slot_id' => ['required', 'exists:available_slots,id'],
            'service_id' => ['required', 'exists:services,id'],
        ];
    }
}
