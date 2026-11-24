<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function isAdmin(): bool{
        return $this->role === UserRole::ADMIN;
    }
    public function isDonor(): bool
    {
        return $this->role === UserRole::DONOR;
    }

    public function isRecipient(): bool
    {
        return $this->role === UserRole::RECIPIENT;
    }
    
    public function hasActiveOrganization(): bool
    {
        return $this->organizations()->where('is_active', true)->exists();
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    public function confirmedPickups(): HasMany
    {
        return $this->hasMany(Pickup::class, 'confirmed_by');
    }
}
