<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        $booking = null;
    
        DB::transaction(function () use ($event, $seatsRequested, &$booking) {
            $event = Event::lockForUpdate()->findOrFail($event->id);
    
            if ($seatsRequested > $event->available_seats) {
                abort(422, 'Not enough seats available.');
            }
    
            $booking = Booking::create([
                'user_id'      => Auth::id(),
                'event_id'     => $event->id,
                'seats_booked' => $seatsRequested,
                'status'       => 'booked',
                'booking_date' => now(),
            ]);
    
            $event->decrement('available_seats', $seatsRequested);
        });
    
        // Mail transaction ke BAHAR bhejo
        if ($booking) {
            try {
                $booking->load('event', 'user');
                Mail::to($booking->user->email)
                    ->send(new BookingConfirmed($booking));
            } catch (\Exception $e) {
                logger()->warning('Email failed: ' . $e->getMessage());
            }
        }
    
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