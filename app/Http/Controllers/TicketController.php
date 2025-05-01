<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    // View all tickets for logged-in user (upcoming first)
    public function index()
    {
        $tickets = Ticket::with('event.venue')
            ->where('user_id', auth()->id())
            ->orderBy('event_id') // Sort by event start time via relation
            ->get()
            ->sortBy(fn ($ticket) => $ticket->event->start_time);

        return response()->json($tickets->values());
    }

    // Book a ticket for an event
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'seat_info' => 'nullable|string',
        ]);

        $event = Event::with('tickets', 'venue')->findOrFail($data['event_id']);

        // Check if event has available seats
        $totalBooked = $event->tickets->count();
        $capacity = $event->venue->capacity;

        if ($totalBooked >= $capacity) {
            return response()->json(['message' => 'No seats available'], 400);
        }

        $ticket = Ticket::create([
            'user_id'   => auth()->id(),
            'event_id'  => $event->id,
            'price'     => 10.00,
            'seat_info' => $data['seat_info'],
            'booked_at' => now(),
        ]);

        Mail::to(auth()->user()->email)->send(new \App\Mail\TicketConfirmation($ticket));


        return response()->json([
            'message' => 'Ticket booked successfully.',
            'ticket'  => $ticket->load('event.venue'),
        ], 201);
    }
}
