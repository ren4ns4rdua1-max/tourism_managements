<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new booking for a destination.
     */
    public function createForDestination(Destination $destination)
    {
        return view('booking.user-create', compact('destination'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function storeUserBooking(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string',
        ]);

        // Calculate total price based on destination price and number of nights
        $destination = Destination::find($validated['destination_id']);
        $checkIn = \Carbon\Carbon::parse($validated['check_in_date']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        
        // Calculate total price (destination price * nights)
        $totalPrice = $destination->price * $nights;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'destination_id' => $validated['destination_id'],
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'number_of_guests' => $validated['number_of_guests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.user.index')
            ->with('success', 'Booking submitted successfully! Pending for manager approval.');
    }

    /**
     * Display user's bookings.
     */
    public function userBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('destination')
            ->latest()
            ->get();
        
        return view('booking.user-index', compact('bookings'));
    }

    /**
     * Display all bookings for managers (manage bookings).
     */
    public function manageBookings()
    {
        $bookings = Booking::with(['user', 'destination'])
            ->latest()
            ->get();
        
        return view('booking.manage-index', compact('bookings'));
    }

    /**
     * Confirm a booking.
     */
    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        
        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
