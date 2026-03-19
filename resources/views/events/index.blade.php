@extends('layouts.app')
@section('title', 'All Events')

@section('content')

{{-- Hero --}}
<div class="hero text-center">
    <div class="container">
        <h1 class="fw-bold display-5 mb-2">
            <i class="fas fa-calendar-star me-2"></i>Upcoming Events
        </h1>
        <p class="lead mb-0 opacity-75">Discover and book amazing events near you</p>
    </div>
</div>

<div class="container py-5">

    {{-- Filter Form --}}
    <div class="card p-4 mb-4">
        <form method="GET" action="{{ route('events.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold">
                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>Filter by Location
                </label>
                <input type="text" name="location" class="form-control"
                    placeholder="e.g. Lahore, Karachi..."
                    value="{{ request('location') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar me-1 text-primary"></i>Filter by Date
                </label>
                <input type="date" name="date" class="form-control"
                    value="{{ request('date') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                @if(request('location') || request('date'))
                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Results Count --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            Showing <strong>{{ $events->total() }}</strong> event(s)
        </p>
        @auth
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Create Event
            </a>
        @endauth
    </div>

    {{-- Events Grid --}}
    @if($events->count())
        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-4">
                    <div class="card h-100 event-card">
                        <div class="card-body p-4">

                            {{-- Status Badge --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-primary rounded-pill">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $event->location }}
                                </span>
                                @if($event->available_seats > 0)
                                    <span class="badge bg-success rounded-pill">
                                        {{ $event->available_seats }} seats left
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill">Fully Booked</span>
                                @endif
                            </div>

                            <h5 class="fw-bold mb-2">{{ $event->title }}</h5>

                            <p class="text-muted small mb-3">
                                {{ Str::limit($event->description, 80) }}
                            </p>

                            <div class="text-muted small mb-3">
                                <div class="mb-1">
                                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                    {{ $event->event_date->format('D, M d Y') }}
                                </div>
                                <div class="mb-1">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    {{ $event->event_date->format('h:i A') }}
                                </div>
                                <div>
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    By {{ $event->creator->name }}
                                </div>
                            </div>

                            {{-- Seats Progress Bar --}}
                            @php
                                $percent = $event->total_seats > 0
                                    ? round(($event->total_seats - $event->available_seats) / $event->total_seats * 100)
                                    : 100;
                                $barColor = $percent >= 90 ? 'bg-danger' : ($percent >= 60 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Seats filled</span>
                                    <span>{{ $percent }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar {{ $barColor }}" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-primary w-100">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $events->links() }}
        </div>

    @else
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No events found</h4>
            <p class="text-muted">Try changing your filters or check back later.</p>
            @auth
                <a href="{{ route('events.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus me-1"></i>Create First Event
                </a>
            @endauth
        </div>
    @endif

</div>
@endsection