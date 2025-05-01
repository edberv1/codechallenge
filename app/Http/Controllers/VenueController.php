<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    // List all venues
    public function index()
    {
        return response()->json(Venue::all());
    }

    // Store a new venue
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $venue = Venue::create($data);

        return response()->json([
            'message' => 'Venue created successfully.',
            'venue'   => $venue,
        ], 201);
    }

    // Update an existing venue
    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $data = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
        ]);

        $venue->update($data);

        return response()->json([
            'message' => 'Venue updated.',
            'venue'   => $venue,
        ]);
    }

    // Delete a venue
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return response()->json(['message' => 'Venue deleted.']);
    }
}
