<?php

namespace App\Models;

use App\Enums\PickupStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'confirmed_by',
        'pickup_code',
        'status',
        'collected_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PickupStatus::class,
            'collected_at' => 'datetime',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public static function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(4)).'-'.random_int(1000, 9999);
        } while (static::where('pickup_code', $code)->exists());

        return $code;
    }
}