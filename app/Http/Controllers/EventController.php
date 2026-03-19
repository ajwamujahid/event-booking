<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('creator')->upcoming()->latest('event_date');

        if ($request->filled('location')) {
            $query->byLocation($request->location);
        }

        if ($request->filled('date')) {
            $query->byDate($request->date);
        }

        $events = $query->paginate(9)->withQueryString();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load('creator', 'bookings');
        return view('events.show', compact('event'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data                    = $request->validated();
        $data['created_by']      = Auth::id();
        $data['available_seats'] = $data['total_seats'];

        $event = Event::create($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event "' . $event->title . '" created successfully!');
    }

    public function edit(Event $event)
    {
        if (Auth::id() !== $event->created_by) {
            abort(403, 'You are not authorized to edit this event.');
        }
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        if (Auth::id() !== $event->created_by) {
            abort(403);
        }

        $data = $request->validated();

        if ($data['total_seats'] != $event->total_seats) {
            $seatsBooked             = $event->total_seats - $event->available_seats;
            $data['available_seats'] = max(0, $data['total_seats'] - $seatsBooked);
        }

        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if (Auth::id() !== $event->created_by) {
            abort(403);
        }

        $title = $event->title;
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event "' . $title . '" deleted.');
    }
}