@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="container py-5">
    <div class="row g-4">

        {{-- Left: Event Details --}}
        <div class="col-lg-8">
            <div class="card p-4 mb-4">
                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $event->location }}
                    </span>
                    @if($event->available_seats > 0)
                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="fas fa-chair me-1"></i>{{ $event->available_seats }} seats available
                        </span>
                    @else
                        <span class="badge bg-danger rounded-pill px-3 py-2">Fully Booked</span>
                    @endif
                </div>

                <h2 class="fw-bold mb-3">{{ $event->title }}</h2>

                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            <div>
                                <div class="small">Date</div>
                                <div class="fw-semibold text-dark">{{ $event->event_date->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="fas fa-clock text-primary"></i>
                            <div>
                                <div class="small">Time</div>
                                <div class="fw-semibold text-dark">{{ $event->event_date->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex align-items-center gap-2 text-muted">
                            <i class="fas fa-users text-primary"></i>
                            <div>
                                <div class="small">Total Seats</div>
                                <div class="fw-semibold text-dark">{{ $event->total_seats }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h5 class="fw-bold mb-3">About this Event</h5>
                <p class="text-muted lh-lg">
                    {{ $event->description ?? 'No description provided.' }}
                </p>

                <div class="mt-3 text-muted small">
                    <i class="fas fa-user-circle me-1"></i>
                    Organized by <strong>{{ $event->creator->name }}</strong>
                    · Posted {{ $event->created_at->diffForHumans() }}
                </div>
            </div>

            {{-- Owner Actions --}}
            @auth
                @if(Auth::id() === $event->created_by)
                    <div class="card p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-cog me-1 text-primary"></i>Manage Event
                        </h6>
                        <div class="d-flex gap-2">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>Edit Event
                            </a>
                            <form method="POST" action="{{ route('events.destroy', $event) }}"
                                onsubmit="return confirm('Delete this event? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash me-1"></i>Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Right: Booking Card --}}
        <div class="col-lg-4">
            <div class="card p-4 sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-1">Reserve Your Seats</h5>
                <p class="text-muted small mb-3">
                    <i class="fas fa-chair me-1"></i>
                    <strong class="text-success">{{ $event->available_seats }}</strong>
                    / {{ $event->total_seats }} seats available
                </p>

                {{-- Progress Bar --}}
                @php
                    $percent = $event->total_seats > 0
                        ? round(($event->total_seats - $event->available_seats) / $event->total_seats * 100)
                        : 100;
                    $barColor = $percent >= 90 ? 'bg-danger' : ($percent >= 60 ? 'bg-warning' : 'bg-success');
                @endphp
                <div class="progress mb-4" style="height: 8px;">
                    <div class="progress-bar {{ $barColor }}" style="width: {{ $percent }}%"></div>
                </div>

                @auth
                    @if($event->available_seats > 0)
                        <form method="POST" action="{{ route('bookings.store', $event) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Number of Seats</label>
                                <input type="number" name="seats_booked"
                                    class="form-control @error('seats_booked') is-invalid @enderror"
                                    min="1" max="{{ $event->available_seats }}"
                                    value="{{ old('seats_booked', 1) }}" required>
                                @error('seats_booked')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                <i class="fas fa-ticket me-2"></i>Book Now
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger text-center mb-0">
                            <i class="fas fa-times-circle me-1"></i>
                            This event is fully booked.
                        </div>
                    @endif
                @else
                    <div class="alert alert-info text-center mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Please login to book seats.
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-1"></i>Login to Book
                    </a>
                @endauth

                <hr>
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-1"></i>Back to Events
                </a>
            </div>
        </div>

    </div>
</div>
@endsection