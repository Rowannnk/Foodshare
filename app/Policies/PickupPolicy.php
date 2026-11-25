<?php

namespace App\Policies;

use App\Models\Pickup;
use App\Models\User;

class PickupPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function confirm(User $user, Pickup $pickup): bool
    {
        return($user->isDonor() && $pickup->reservation->foodListing->organization->user_id === $user->id);
    }
}