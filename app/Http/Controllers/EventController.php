<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // List upcoming events with optional filters
    public function index(Request $request)
    {
        $query = Event::with('venue')->where('start_time', '>', now());

        // Filters
        if ($request->has('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('start_time', [$request->from, $request->to]);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }


        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhereHas('venue', function ($vq) use ($searchTerm) {
                      $vq->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        return response()->json($query->orderBy('start_time')->get());
    }


    // Admin: Create event
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'venue_id' => 'required|exists:venues,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);


        $data['created_by'] = auth()->id();

        $event = Event::create($data);

        return response()->json([
            'message' => 'Event created successfully',
            'event'   => $event->load('venue'),
        ], 201);
    }

    // Admin: Update event
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->created_by !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'sometimes|string',
            'venue_id'    => 'sometimes|exists:venues,id',
            'start_time'  => 'sometimes|date|after:now',
            'end_time'    => 'sometimes|date|after:start_time',
        ]);

        $event->update($data);

        return response()->json([
            'message' => 'Event updated',
            'event'   => $event->fresh()->load('venue'),
        ]);
    }

    // Admin: Delete event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->created_by !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}
