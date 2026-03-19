<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'location'    => 'required|string|max:255',
            'event_date'  => 'required|date|after:now',
            'total_seats' => 'required|integer|min:1|max:10000',
        ];
    }

    public function messages(): array
    {
        return [
            'event_date.after' => 'Event date must be a future date.',
            'total_seats.min'  => 'At least 1 seat is required.',
        ];
    }
}