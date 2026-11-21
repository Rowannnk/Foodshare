<?php

namespace App\Models;

use App\Enums\ListingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}