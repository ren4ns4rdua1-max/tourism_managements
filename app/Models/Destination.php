<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    protected $fillable = [
    'name',
    'description',
    'location',
    'latitude',
    'longitude',
    'image',
    'price',
    'is_active',
    'user_id'
];

protected $casts = [
    'latitude' => 'decimal:8',
    'longitude' => 'decimal:8',
    'price' => 'decimal:2',
    'is_active' => 'boolean',
];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
}
