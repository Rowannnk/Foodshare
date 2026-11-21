<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_listing_id',
        'user_id',
        'quantity',
        'status',
        'reserved_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ReservationStatus::class,
            'reserved_at' => 'datetime',
        ];
    }

    public function foodListing(): BelongsTo
    {
        return $this->belongsTo(FoodListing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}