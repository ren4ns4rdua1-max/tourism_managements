<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $destinations = Destination::with('user')->where('is_active', true)->get();
        } else {
            $destinations = Destination::with('user')->where('is_active', true)
                ->whereHas('user', function($q) {
                    $q->where('role', 'manager');
                })->get();
        }
        return view('destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'image' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('destinations', 'public');
        }

        // Assign the current user as the creator
        $validated['user_id'] = auth()->id();

        Destination::create($validated);

        return redirect()->route('destinations.index')
            ->with('success', 'Destination created successfully!');
}

public function edit(Destination $destination)
{
    return view('destinations.edit', compact('destination'));
}

public function update(Request $request, Destination $destination)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'image' => 'nullable|image|max:2048',
        'price' => 'nullable|numeric|min:0',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('destinations', 'public');
    }

    $destination->update($validated);

    return redirect()->route('destinations.index')
        ->with('success', 'Destination updated successfully!');
}

public function show(Destination $destination)
{
    return view('destinations.show', compact('destination'));
}

public function destroy(Destination $destination)
{
    $destination->delete();
    return redirect()->route('destinations.index')
        ->with('success', 'Destination deleted successfully!');
}
}
