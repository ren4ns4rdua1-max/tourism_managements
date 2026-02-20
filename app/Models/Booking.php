<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destination_id',
        'booking_date',
        'number_of_guests',
        'total_amount',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'number_of_guests' => 'integer',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the destination that owns the booking.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Scope to get confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope to get completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
        };
    }
}
