<?php

namespace App\Policies;

use App\Models\FoodListing;
use App\Models\User;

class FoodListingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isDonor();
    }

    public function view(User $user, FoodListing $foodListing): bool
    {
        return $this->manages($user, $foodListing);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isDonor();
    }

    public function update(User $user, FoodListing $foodListing): bool
    {
        return $this->manages($user, $foodListing);
    }

    public function delete(User $user, FoodListing $foodListing): bool
    {
        return $this->manages($user, $foodListing);
    }

    private function manages(User $user, FoodListing $foodListing): bool
    {
        return $user->isAdmin()
            || ($user->isDonor() && $foodListing->organization->user_id === $user->id);
    }
}
