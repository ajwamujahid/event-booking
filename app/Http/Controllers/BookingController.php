<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function store(StoreBookingRequest $request, Event $event)
    {
        $seatsRequested = $request->validated()['seats_booked'];

        DB::transaction(function () use ($event, $seatsRequested) {
            $event = Event::lockForUpdate()->findOrFail($event->id);

            if ($seatsRequested > $event->available_seats) {
                abort(422, 'Not enough seats available.');
            }

            Booking::create([
                'user_id'      => Auth::id(),
                'event_id'     => $event->id,
                'seats_booked' => $seatsRequested,
                'status'       => 'booked',
                'booking_date' => now(),
            ]);

            $event->decrement('available_seats', $seatsRequested);
        });

        return redirect()->route('bookings.index')
            ->with('success', $seatsRequested . ' seat(s) booked successfully! 🎉');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->isCancelled()) {
            return back()->with('error', 'This booking is already cancelled.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            $booking->event->increment('available_seats', $booking->seats_booked);
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled. Seats have been released.');
    }
}