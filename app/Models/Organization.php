<?php

namespace App\Models;

use App\Enums\OrganizationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','name','slug','type','contact_email','contact_phone','address','city','is_active'];

    protected function casts():array
    {
        return [
            'type' => OrganizationType::class,
            'is_active' => 'boolean',
        ];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function foodListings(): HasMany
    {
        return $this->hasMany(FoodListing::class);
    }
}
