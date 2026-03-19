@extends('layouts.app')
@section('title', 'My Bookings')

@section('content')
<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">
                <i class="fas fa-ticket me-2 text-primary"></i>My Bookings
            </h3>
            <p class="text-muted mb-0 small">All your event reservations in one place</p>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-primary">
            <i class="fas fa-calendar me-1"></i>Browse Events
        </a>
    </div>

    @if($bookings->count())

        {{-- Stats Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card p-3 text-center border-0" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <div class="text-white">
                        <div class="fs-2 fw-bold">{{ $bookings->total() }}</div>
                        <div class="small opacity-75">Total Bookings</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center border-0 bg-success bg-opacity-10">
                    <div class="text-success">
                        <div class="fs-2 fw-bold">
                            {{ $bookings->where('status', 'booked')->count() }}
                        </div>
                        <div class="small">Active Bookings</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center border-0 bg-danger bg-opacity-10">
                    <div class="text-danger">
                        <div class="fs-2 fw-bold">
                            {{ $bookings->where('status', 'cancelled')->count() }}
                        </div>
                        <div class="small">Cancelled</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bookings List --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Event</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Location</th>
                                <th class="py-3">Seats</th>
                                <th class="py-3">Booked On</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-4">
                                        <a href="{{ route('events.show', $booking->event) }}"
                                            class="fw-semibold text-decoration-none text-dark">
                                            {{ Str::limit($booking->event->title, 35) }}
                                        </a>
                                    </td>
                                    <td class="text-muted small">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        {{ $booking->event->event_date->format('M d, Y') }}<br>
                                        <span class="text-muted">
                                            {{ $booking->event->event_date->format('h:i A') }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                        {{ Str::limit($booking->event->location, 25) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill px-3">
                                            {{ $booking->seats_booked }}
                                            {{ Str::plural('seat', $booking->seats_booked) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $booking->booking_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @if($booking->isBooked())
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="fas fa-check me-1"></i>Booked
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3">
                                                <i class="fas fa-times me-1"></i>Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->isBooked())
                                            <form method="POST"
                                                action="{{ route('bookings.cancel', $booking) }}"
                                                onsubmit="return confirm('Cancel this booking?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $bookings->links() }}
        </div>

    @else
        <div class="text-center py-5">
            <i class="fas fa-ticket fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No bookings yet</h4>
            <p class="text-muted">You haven't booked any events. Start exploring!</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary mt-2">
                <i class="fas fa-calendar me-1"></i>Browse Events
            </a>
        </div>
    @endif

</div>
@endsection