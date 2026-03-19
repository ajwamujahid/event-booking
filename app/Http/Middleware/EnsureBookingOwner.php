<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBookingOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $booking = $request->route('booking');

        if (!$booking instanceof Booking) {
            abort(404, 'Booking not found.');
        }

        if ($booking->user_id !== $request->user()->id) {
            abort(403, 'You are not authorised to manage this booking.');
        }

        return $next($request);
    }
}