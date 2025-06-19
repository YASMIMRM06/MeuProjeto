<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with('creator')->orderBy('event_date', 'desc')->paginate(10);
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $this->authorize('create', Event::class);
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after_or_equal:now',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:scheduled,canceled,completed',
        ]);

        $event = Auth::user()->createdEvents()->create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after_or_equal:now',
            'location' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'required|in:scheduled,canceled,completed',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * Participate in an event.
     */
    public function participate(Event $event)
    {
        $user = Auth::user();
        if (!$user->eventsParticipating->contains($event->id)) {
            $user->eventsParticipating()->attach($event->id, ['status' => 'confirmed']);
            return back()->with('success', 'You have successfully joined the event!');
        }
        return back()->with('info', 'You are already participating in this event.');
    }

    /**
     * Cancel participation in an event.
     */
    public function cancelParticipation(Event $event)
    {
        $user = Auth::user();
        if ($user->eventsParticipating->contains($event->id)) {
            $user->eventsParticipating()->detach($event->id);
            return back()->with('success', 'You have canceled your participation in the event.');
        }
        return back()->with('info', 'You are not participating in this event.');
    }
}