<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'star_rating',
        'status',
    ];

    protected $casts = [
        'star_rating' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the rooms for the hotel.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the bookings for the hotel.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get available rooms for the hotel.
     */
    public function availableRooms()
    {
        return $this->rooms()->where('status', 'available');
    }

    /**
     * Get the hotel's star rating as stars.
     */
    public function getStarRatingHtmlAttribute()
    {
        $stars = '';
        for ($i = 0; $i < $this->star_rating; $i++) {
            $stars .= '★';
        }
        return $stars;
    }
}
