@extends('layouts.app')
@section('title', 'Edit Event')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('events.show', $event) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h3 class="fw-bold mb-0">Edit Event</h3>
                    <p class="text-muted mb-0 small">Update the details below</p>
                </div>
            </div>

            <div class="card p-4">
                <form method="POST" action="{{ route('events.update', $event) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Event Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $event->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Location <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </span>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location', $event->location) }}" required>
                        </div>
                        @error('location')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Event Date & Time <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar text-primary"></i>
                                </span>
                                <input type="datetime-local" name="event_date"
                                    class="form-control @error('event_date') is-invalid @enderror"
                                    value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                                    required>
                            </div>
                            @error('event_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Total Seats <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-chair text-primary"></i>
                                </span>
                                <input type="number" name="total_seats"
                                    class="form-control @error('total_seats') is-invalid @enderror"
                                    value="{{ old('total_seats', $event->total_seats) }}"
                                    min="1" max="10000" required>
                            </div>
                            @error('total_seats')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Seats Info --}}
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        Currently <strong>{{ $event->total_seats - $event->available_seats }}</strong>
                        seat(s) are already booked.
                        Available seats will be automatically adjusted.
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold">
                            <i class="fas fa-save me-2"></i>Update Event
                        </button>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection