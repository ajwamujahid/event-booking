<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'seats_booked' => [
                'required',
                'integer',
                'min:1',
                'max:' . ($event ? $event->available_seats : 1),
            ],
        ];
    }

    public function messages(): array
    {
        $available = $this->route('event')?->available_seats ?? 0;

        return [
            'seats_booked.max' => "Only {$available} seat(s) available for this event.",
            'seats_booked.min' => 'You must book at least 1 seat.',
        ];
    }
}