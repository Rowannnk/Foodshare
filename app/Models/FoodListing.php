<?php

namespace App\Models;

use App\Enums\ListingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ReservationStatus;

class FoodListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'food_category_id',
        'title',
        'description',
        'quantity',
        'pickup_from',
        'pickup_until',
        'expires_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'pickup_from' => 'datetime',
            'pickup_until' => 'datetime',
            'expires_at' => 'datetime',
            'status' => ListingStatus::class,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class);
    }
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function reservedQuantity(): int
    {
        return (int) $this->reservations()
            ->where('status', '!=', ReservationStatus::CANCELLED)
            ->sum('quantity');
    }

    public function remainingQuantity(): int
    {
        return max(0, $this->quantity - $this->reservedQuantity());
    }

    public function isReservable(): bool
    {
        return $this->status === ListingStatus::AVAILABLE
            && $this->remainingQuantity() > 0
            && $this->pickup_until->isFuture();
    }
}