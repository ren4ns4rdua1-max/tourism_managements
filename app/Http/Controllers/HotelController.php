<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the hotels.
     */
    public function index()
    {
        $hotels = Hotel::with('rooms')->get();
        return view('hotel.index', compact('hotels'));
    }

    /**
     * Show the form for creating a new hotel.
     */
    public function create()
    {
        return view('hotel.create');
    }

    /**
     * Store a newly created hotel in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive,under_maintenance',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Hotel::create($request->all());

        return redirect()->route('hotel.index')
            ->with('success', 'Hotel created successfully!');
    }

    /**
     * Display the specified hotel.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load(['rooms', 'bookings' => function($query) {
            $query->whereIn('status', ['pending', 'confirmed'])
                ->orderBy('check_in_date');
        }]);
        
        return view('hotel.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified hotel.
     */
    public function edit(Hotel $hotel)
    {
        return view('hotel.edit', compact('hotel'));
    }

    /**
     * Update the specified hotel in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive,under_maintenance',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hotel->update($request->all());

        return redirect()->route('hotel.show', $hotel)
            ->with('success', 'Hotel updated successfully!');
    }

    /**
     * Remove the specified hotel from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        
        return redirect()->route('hotel.index')
            ->with('success', 'Hotel deleted successfully!');
    }

    // ==================== Room Management ====================

    /**
     * Show the form for creating a new room.
     */
    public function createRoom(Hotel $hotel)
    {
        return view('hotel.rooms.create', compact('hotel'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function storeRoom(Request $request, Hotel $hotel)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|string|max:20|unique:rooms,room_number,NULL,id,hotel_id,' . $hotel->id,
            'room_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:10',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'is_ac' => 'boolean',
            'has_wifi' => 'boolean',
            'has_breakfast' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hotel->rooms()->create($request->all());

        return redirect()->route('hotel.show', $hotel)
            ->with('success', 'Room added successfully!');
    }

    /**
     * Show the form for editing a room.
     */
    public function editRoom(Hotel $hotel, Room $room)
    {
        return view('hotel.rooms.edit', compact('hotel', 'room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function updateRoom(Request $request, Hotel $hotel, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'room_number' => 'required|string|max:20|unique:rooms,room_number,' . $room->id . ',id,hotel_id,' . $hotel->id,
            'room_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1|max:10',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance,reserved',
            'is_ac' => 'boolean',
            'has_wifi' => 'boolean',
            'has_breakfast' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $room->update($request->all());

        return redirect()->route('hotel.show', $hotel)
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroyRoom(Hotel $hotel, Room $room)
    {
        $room->delete();
        
        return redirect()->route('hotel.show', $hotel)
            ->with('success', 'Room deleted successfully!');
    }

    // ==================== Booking Management ====================

    /**
     * Display all hotel bookings.
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['hotel', 'room', 'user']);

        // Filter by hotel
        if ($request->has('hotel_id') && $request->hotel_id) {
            $query->where('hotel_id', $request->hotel_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('check_in_date') && $request->check_in_date) {
            $query->where('check_in_date', '>=', $request->check_in_date);
        }

        if ($request->has('check_out_date') && $request->check_out_date) {
            $query->where('check_out_date', '<=', $request->check_out_date);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        $hotels = Hotel::all();

        return view('hotel.bookings.index', compact('bookings', 'hotels'));
    }

    /**
     * Show the form for creating a new booking/reservation.
     */
    public function createBooking(Request $request)
    {
        $hotels = Hotel::where('status', 'active')->with('rooms')->get();
        
        $checkIn = $request->check_in_date ?? now()->addDay()->format('Y-m-d');
        $checkOut = $request->check_out_date ?? now()->addDays(2)->format('Y-m-d');

        return view('hotel.bookings.create', compact('hotels', 'checkIn', 'checkOut'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function storeBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1|max:10',
            'special_requests' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check room availability
        $room = Room::find($request->room_id);
        if (!$room->isAvailable($request->check_in_date, $request->check_out_date)) {
            return redirect()->back()
                ->withErrors(['room_id' => 'This room is not available for the selected dates.'])
                ->withInput();
        }

        // Calculate total price
        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price_per_night;

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'hotel_id' => $request->hotel_id,
            'room_id' => $request->room_id,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'number_of_guests' => $request->number_of_guests,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        // Update room status
        $room->update(['status' => 'reserved']);

        return redirect()->route('hotel.bookings.index')
            ->with('success', 'Reservation created successfully! Booking ID: ' . $booking->booking_id);
    }

    /**
     * Show the form for editing a booking.
     */
    public function editBooking(Booking $booking)
    {
        $hotels = Hotel::where('status', 'active')->with('rooms')->get();
        $booking->load(['hotel', 'room']);
        
        return view('hotel.bookings.edit', compact('booking', 'hotels'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'number_of_guests' => 'required|integer|min:1|max:10',
            'status' => 'required|in:pending,confirmed,cancelled,completed,checked_in,checked_out',
            'special_requests' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate total price if room changed or dates changed
        $room = Room::find($request->room_id);
        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price_per_night;

        $booking->update(array_merge($request->all(), ['total_price' => $totalPrice]));

        return redirect()->route('hotel.bookings.index')
            ->with('success', 'Reservation updated successfully!');
    }

    /**
     * Cancel the specified booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        // Update room status back to available
        if ($booking->room) {
            $booking->room->update(['status' => 'available']);
        }

        return redirect()->back()
            ->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Assign room to a booking.
     */
    public function assignRoom(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $room = Room::find($request->room_id);
        
        if (!$room->isAvailable($booking->check_in_date, $booking->check_out_date)) {
            return redirect()->back()
                ->withErrors(['room_id' => 'This room is not available for the booking dates.']);
        }

        // Free up old room if assigned
        if ($booking->room) {
            $booking->room->update(['status' => 'available']);
        }

        $booking->update([
            'room_id' => $request->room_id,
            'hotel_id' => $room->hotel_id,
            'status' => 'confirmed'
        ]);

        $room->update(['status' => 'occupied']);

        return redirect()->back()
            ->with('success', 'Room assigned successfully!');
    }

    /**
     * Check room availability.
     */
    public function checkAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $hotel = Hotel::with(['rooms' => function($query) use ($request) {
            $query->where('status', 'available');
            if ($request->guests) {
                $query->where('capacity', '>=', $request->guests);
            }
        }])->find($request->hotel_id);

        $availableRooms = [];
        
        foreach ($hotel->rooms as $room) {
            if ($room->isAvailable($request->check_in_date, $request->check_out_date)) {
                $availableRooms[] = $room;
            }
        }

        $checkIn = $request->check_in_date;
        $checkOut = $request->check_out_date;

        return view('hotel.bookings.availability', compact('hotel', 'availableRooms', 'checkIn', 'checkOut'));
    }

    /**
     * Confirm a booking.
     */
    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        
        if ($booking->room) {
            $booking->room->update(['status' => 'occupied']);
        }

        return redirect()->back()
            ->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Check in a guest.
     */
    public function checkIn(Booking $booking)
    {
        $booking->update(['status' => 'checked_in']);
        
        return redirect()->back()
            ->with('success', 'Guest checked in successfully!');
    }

    /**
     * Check out a guest.
     */
    public function checkOut(Booking $booking)
    {
        $booking->update(['status' => 'checked_out']);
        
        if ($booking->room) {
            $booking->room->update(['status' => 'available']);
        }

        return redirect()->back()
            ->with('success', 'Guest checked out successfully!');
    }
}
