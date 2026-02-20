<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // If user is admin or manager, show all bookings
        if ($user->role === 'admin' || $user->role === 'manager') {
            $bookings = Booking::with(['user', 'destination'])->latest()->get();
        } else {
            // Regular user - show only their own bookings
            $bookings = Booking::with(['destination'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }
        
        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $destinations = Destination::all();
        $destination = null;
        
        // Check if destination_id is provided in the request
        if ($request->has('destination_id')) {
            $destination = Destination::find($request->destination_id);
        }
        
        return view('booking.create', compact('destinations', 'destination'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'total_amount' => 'required|numeric|min:0',
            'special_requests' => 'nullable|string',
        ]);

        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->destination_id = $request->destination_id;
        $booking->booking_date = $request->booking_date;
        $booking->number_of_guests = $request->number_of_guests;
        $booking->total_amount = $request->total_amount;
        $booking->special_requests = $request->special_requests;
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('booking.index')->with('success', 'Booking created successfully!');
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

    // ========== Admin Booking Methods ==========

    /**
     * Display admin booking list - shows all bookings
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'destination'])->latest()->get();
        return view('booking.admin.index', compact('bookings'));
    }

    /**
     * Show the form for editing a booking (admin)
     */
    public function adminEdit(string $id)
    {
        $booking = Booking::with(['user', 'destination'])->findOrFail($id);
        $destinations = Destination::all();
        return view('booking.admin.edit', compact('booking', 'destinations'));
    }

    /**
     * Update a booking (admin - full update)
     */
    public function adminUpdate(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'booking_date' => 'required|date',
            'number_of_guests' => 'required|integer|min:1|max:20',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
        ]);

        $booking->destination_id = $request->destination_id;
        $booking->booking_date = $request->booking_date;
        $booking->number_of_guests = $request->number_of_guests;
        $booking->total_amount = $request->total_amount;
        $booking->status = $request->status;
        $booking->special_requests = $request->special_requests;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove a booking (admin - can delete)
     */
    public function adminDestroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }

    // ========== Manager Booking Methods ==========

    /**
     * Display manager booking list - shows all bookings (read-only)
     */
    public function managerIndex()
    {
        $bookings = Booking::with(['user', 'destination'])->latest()->get();
        return view('booking.manager.index', compact('bookings'));
    }

    /**
     * Show the form for editing a booking status (manager)
     */
    public function managerEdit(string $id)
    {
        $booking = Booking::with(['user', 'destination'])->findOrFail($id);
        return view('booking.manager.edit', compact('booking'));
    }

    /**
     * Update a booking status (manager - can only update status)
     */
    public function managerUpdate(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('manager.bookings.index')->with('success', 'Booking status updated successfully!');
    }

    /**
     * Accept a booking (manager)
     */
    public function accept(string $id)
    {
        $booking = Booking::with(['user', 'destination'])->findOrFail($id);

        if ($booking->status !== 'pending') {
            return redirect()->route('manager.bookings.index')
                ->with('error', 'Only pending bookings can be accepted.');
        }

        $booking->status = 'confirmed';
        $booking->save();

        // Send confirmation email
        try {
            Mail::to($booking->user->email)->send(new BookingConfirmation($booking, 'accepted'));
        } catch (\Exception $e) {
            // Log error but don't fail the operation
            \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
        }

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking has been accepted and the user has been notified via email.');
    }

    /**
     * Decline a booking (manager)
     */
    public function decline(string $id)
    {
        $booking = Booking::with(['user', 'destination'])->findOrFail($id);

        if ($booking->status !== 'pending') {
            return redirect()->route('manager.bookings.index')
                ->with('error', 'Only pending bookings can be declined.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        // Send decline email
        try {
            Mail::to($booking->user->email)->send(new BookingConfirmation($booking, 'declined'));
        } catch (\Exception $e) {
            // Log error but don't fail the operation
            \Log::error('Failed to send booking decline email: ' . $e->getMessage());
        }

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking has been declined and the user has been notified via email.');
    }
}
