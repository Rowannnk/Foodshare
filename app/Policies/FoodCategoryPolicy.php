<?php

namespace App\Policies;

use App\Models\FoodCategory;
use App\Models\User;

class FoodCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, FoodCategory $foodCategory): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, FoodCategory $foodCategory): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, FoodCategory $foodCategory): bool
    {
        return $user->isAdmin();
    }
}