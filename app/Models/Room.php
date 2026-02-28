<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_type',
        'description',
        'capacity',
        'price_per_night',
        'status',
        'is_ac',
        'has_wifi',
        'has_breakfast',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'price_per_night' => 'decimal:2',
        'is_ac' => 'boolean',
        'has_wifi' => 'boolean',
        'has_breakfast' => 'boolean',
    ];

    /**
     * Get the hotel that owns the room.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the bookings for the room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if room is available for given dates.
     */
    public function isAvailable($checkIn, $checkOut)
    {
        $bookings = $this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->count();

        return $bookings === 0 && $this->status === 'available';
    }

    /**
     * Get room type options.
     */
    public static function getRoomTypes()
    {
        return [
            'standard' => 'Standard Room',
            'deluxe' => 'Deluxe Room',
            'suite' => 'Suite',
            'family' => 'Family Room',
            'presidential' => 'Presidential Suite',
        ];
    }

    /**
     * Get status options.
     */
    public static function getStatusOptions()
    {
        return [
            'available' => 'Available',
            'occupied' => 'Occupied',
            'maintenance' => 'Under Maintenance',
            'reserved' => 'Reserved',
        ];
    }
}
